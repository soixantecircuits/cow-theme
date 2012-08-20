<?php
class autoptimizeStyles extends autoptimizeBase
{
	private $css = array();
	private $csscode = array();
	private $url = array();
	private $restofcontent = '';
	private $mhtml = '';
	private $datauris = false;
	private $yui = false;
	private $hashmap = array();
	
	//Reads the page and collects style tags
	public function read($options)
	{
		//Remove everything that's not the header
		if($options['justhead'] == true)
		{
			$content = explode('</head>',$this->content,2);
			$this->content = $content[0].'</head>';
			$this->restofcontent = $content[1];
		}
		
		//Store data: URIs setting for later use
		$this->datauris = $options['datauris'];
		
		//Do we use yui?
		$this->yui = $options['yui'];
		
		//Save IE hacks
		$this->content = preg_replace('#(<\!--\[if.*\]>.*<\!\[endif\]-->)#Usie',
			'\'%%IEHACK%%\'.base64_encode("$1").\'%%IEHACK%%\'',$this->content);
		
		//Get <style> and <link>
		if(preg_match_all('#(<style[^>]*>.*</style>)|(<link[^>]*text/css[^>]*>)#Usmi',$this->content,$matches))
		{
			foreach($matches[0] as $tag)
			{
				//Get the media
				if(strpos($tag,'media=')!==false)
				{
					preg_match('#media=(?:"|\')([^>]*)(?:"|\')#Ui',$tag,$medias);
					$medias = explode(',',$medias[1]);
					$media = array();
					foreach($medias as $elem)
					{
						$media[] = current(explode(' ',trim($elem),2));
					}
				}else{
					//No media specified - applies to all
					$media = array('all');
				}
			
				if(preg_match('#<link.*href=("|\')(.*)("|\')#Usmi',$tag,$source))
				{
					//<link>
					$url = current(explode('?',$source[2],2));
					$path = $this->getpath($url);
					
					if($path !==false && preg_match('#\.css$#',$path))
					{
						//Good link
						$this->css[] = array($media,$path);
					}else{
						//Link is dynamic (.php etc)
						$tag = '';
					}
				}else{
					//<style>
					preg_match('#<style.*>(.*)</style>#Usmi',$tag,$code);
					$code = preg_replace('#^.*<!\[CDATA\[(?:\s*\*/)?(.*)(?://|/\*)\s*?\]\]>.*$#sm','$1',$code[1]);
					$this->css[] = array($media,'INLINE;'.$code);
				}
				
				//Remove the original style tag
				$this->content = str_replace($tag,'',$this->content);
			}
			
			return true;
		}
	
		//No styles :(
		return false;
	}
	
	//Joins and optimizes CSS
	public function minify()
	{
		foreach($this->css as $group)
		{
			list($media,$css) = $group;
			if(preg_match('#^INLINE;#',$css))
			{
				//<style>
				$css = preg_replace('#^INLINE;#','',$css);
				$css = $this->fixurls(ABSPATH.'/index.php',$css);
			}else{
				//<link>
				if($css !== false && file_exists($css) && is_readable($css))
				{
					$css = $this->fixurls($css,file_get_contents($css));
				}else{
					//Couldn't read CSS. Maybe getpath isn't working?
					$css = '';
				}
			}
			
			foreach($media as $elem)
			{
				if(!isset($this->csscode[$elem]))
					$this->csscode[$elem] = '';
				$this->csscode[$elem] .= "\n/*FILESTART*/".$css;
			}
		}
		
		//Check for duplicate code
		$md5list = array();
		$tmpcss = $this->csscode;
		foreach($tmpcss as $media => $code)
		{
			$md5sum = md5($code);
			$medianame = $media;
			foreach($md5list as $med => $sum)
			{
				//If same code
				if($sum === $md5sum)
				{
					//Add the merged code
					$medianame = $med.', '.$media;
					$this->csscode[$medianame] = $code;
					$md5list[$medianame] = $md5list[$med];
					unset($this->csscode[$med], $this->csscode[$media]);
					unset($md5list[$med]);
				}
			}
			$md5list[$medianame] = $md5sum;
		}
		unset($tmpcss);
		
		//Manage @imports, while is for recursive import management
		foreach($this->csscode as &$thiscss)
		{
			//Flag to trigger import reconstitution
			$fiximports = false;
			while(preg_match_all('#@import.*(?:;|$)#Um',$thiscss,$matches))
			{
				foreach($matches[0] as $import)
				{
					$url = trim(preg_replace('#^.*((?:https?|ftp)://.*\.css).*$#','$1',$import)," \t\n\r\0\x0B\"'");
					$path = $this->getpath($url);
					if(file_exists($path) && is_readable($path))
					{
						$code = $this->fixurls($path,file_get_contents($path));
						/*$media = preg_replace('#^.*(?:\)|"|\')(.*)(?:\s|;).*$#','$1',$import);
						$media = array_map('trim',explode(' ',$media));
						if(empty($media))
						{
							$thiscss = [...] (Line under)
						}else{
							//media in @import - how should I handle these?
							//TODO: Infinite recursion!
						}*/
						$thiscss = preg_replace('#(/\*FILESTART\*/.*)'.preg_quote($import,'#').'#Us','/*FILESTART2*/'.$code.'$1',$thiscss);
					}else{
						//getpath is not working?
						//Encode so preg_match doesn't see it
						$thiscss = str_replace($import,'/*IMPORT*/'.base64_encode($import).'/*IMPORT*/',$thiscss);
						$fiximports = true;
					}
				}
				$thiscss = preg_replace('#/\*FILESTART\*/#','',$thiscss);
				$thiscss = preg_replace('#/\*FILESTART2\*/#','/*FILESTART*/',$thiscss);
			}
			
			//Recover imports
			if($fiximports)
			{
				$thiscss = preg_replace('#/\*IMPORT\*/(.*)/\*IMPORT\*/#Use','base64_decode("$1")',$thiscss);
			}
		}
		unset($thiscss);
		
		//$this->csscode has all the uncompressed code now. 
		$mhtmlcount = 0;
		foreach($this->csscode as &$code)
		{
			//Check for already-minified code
			$hash = md5($code);
			$ccheck = new autoptimizeCache($hash,'css');
			if($ccheck->check())
			{
				$code = $ccheck->retrieve();
				$this->hashmap[md5($code)] = $hash;
				continue;
			}
			unset($ccheck);
			
			$imgreplace = array();
			//Do the imaging!
			if($this->datauris == true && function_exists('base64_encode') && preg_match_all('#(background[^;}]*url\((.*)\)[^;}]*)(?:;|$|})#Usm',$code,$matches))
			{
				foreach($matches[2] as $count => $quotedurl)
				{
					$url = trim($quotedurl," \t\n\r\0\x0B\"'");
					$path = $this->getpath($url);
					if($path != false && preg_match('#\.(jpe?j|png|gif|bmp)$#',$path) && file_exists($path) && is_readable($path) && filesize($path) <= 5120)
					{
						//It's an image
						//Get type
						switch(end(explode('.',$path)))
						{
							case 'jpej':
							case 'jpg':
								$dataurihead = 'data:image/jpeg;base64,';
								break;
							case 'gif':
								$dataurihead = 'data:image/gif;base64,';
								break;
							case 'png':
								$dataurihead = 'data:image/png;base64,';
								break;
							case 'bmp':
								$dataurihead = 'data:image/bmp;base64,';
								break;
							default:
								$dataurihead = 'data:application/octet-stream;base64,';
						}
						
						//Encode the data
						$base64data = base64_encode(file_get_contents($path));
						
						//Add it to the list for replacement
						$imgreplace[$matches[1][$count]] = str_replace($quotedurl,$dataurihead.$base64data,$matches[1][$count]).";\n*".str_replace($quotedurl,'mhtml:%%MHTML%%!'.$mhtmlcount,$matches[1][$count]).";\n_".$matches[1][$count].';';
						
						//Store image on the mhtml document
						$this->mhtml .= "--_\r\nContent-Location:{$mhtmlcount}\r\nContent-Transfer-Encoding:base64\r\n\r\n{$base64data}\r\n";
						$mhtmlcount++;
					}
				}
				//Replace the images
				$code = str_replace(array_keys($imgreplace),array_values($imgreplace),$code);
			}
			
			//Minify
			if($this->yui == false && class_exists('Minify_CSS_Compressor'))
			{
				$code = trim(Minify_CSS_Compressor::process($code));
			}elseif($this->yui == true && autoptimizeYUI::available()){
				$code = autoptimizeYUI::compress('css',$code);
			}
			
			$this->hashmap[md5($code)] = $hash;
		}
		unset($code);
		return true;
	}
	
	//Caches the CSS in uncompressed, deflated and gzipped form.
	public function cache()
	{
		if($this->datauris)
		{
			//MHTML Preparation
			$this->mhtml = "/*\r\nContent-Type: multipart/related; boundary=\"_\"\r\n\r\n".$this->mhtml."*/\r\n";
			$md5 = md5($this->mhtml);
			$cache = new autoptimizeCache($md5,'txt');
			if(!$cache->check())
			{
				//Cache our images for IE
				$cache->cache($this->mhtml,'text/plain');
			}
			$mhtml = AUTOPTIMIZE_CACHE_URL.$cache->getname();
		}
		
		//CSS cache
		foreach($this->csscode as $media => $code)
		{
			if($this->datauris)
			{
				//Images for ie! Get the right url
				$code = str_replace('%%MHTML%%',$mhtml,$code);
			}
			
			$md5 = $this->hashmap[md5($code)];
			$cache = new autoptimizeCache($md5,'css');
			if(!$cache->check())
			{
				//Cache our code
				$cache->cache($code,'text/css');
			}
			$this->url[$media] = AUTOPTIMIZE_CACHE_URL.$cache->getname();
		}
	}
	
	//Returns the content
	public function getcontent()
	{
		//Restore IE hacks
		$this->content = preg_replace('#%%IEHACK%%(.*)%%IEHACK%%#Usie','base64_decode("$1")',$this->content);
		
		//Restore the full content
		if(!empty($this->restofcontent))
		{
			$this->content .= $this->restofcontent;
			$this->restofcontent = '';
		}
		
		//Add the new stylesheets
		foreach($this->url as $media => $url)
		{
			$this->content = str_replace('</head>','<link type="text/css" media="'.$media.'" href="'.$url.'" rel="stylesheet" /></head>',$this->content);
		}
		
		//Return the modified stylesheet
		return $this->content;
	}
	
	private function fixurls($file,$code)
	{
		$file = str_replace(ABSPATH,'/',$file); //Sth like /wp-content/file.css
		$dir = dirname($file); //Like /wp-content
		
		if(preg_match_all('#url\((.*)\)#Usi',$code,$matches))
		{
			$replace = array();
			foreach($matches[1] as $k => $url)
			{
				//Remove quotes
				$url = trim($url," \t\n\r\0\x0B\"'");
				if(substr($url,0,1)=='/' || preg_match('#^(https?|ftp)://#i',$url))
				{
					//URL is absolute
					continue;
				}else{
					//relative URL. Let's fix it!
					$newurl = get_settings('home').str_replace('//','/',$dir.'/'.$url); //http://yourblog.com/wp-content/../image.png
					$hash = md5($url);
					$code = str_replace($matches[0][$k],$hash,$code);
					$replace[$hash] = 'url('.$newurl.')';
				}
			}
			
			//Do the replacing here to avoid breaking URLs
			$code = str_replace(array_keys($replace),array_values($replace),$code);
		}
		
		return $code;
	}
}
