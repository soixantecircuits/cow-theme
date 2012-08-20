<?php

class autoptimizeScripts extends autoptimizeBase
{
	private $scripts = array();
	private $dontmove = array('document.write','show_ads.js','google_ad','blogcatalog.com/w','tweetmeme.com/i','mybloglog.com/','var s_sid = ','histats.com/js','smowtion_size','ads.smowtion.com/ad.js','sc_project','statcounter.com/counter/counter.js','widgets.amung.us','WAU_','wau_add','ws.amazon.com/widgets','media.fastclick.net','/ads/','comment-form-quicktags/quicktags.php','edToolbar','intensedebate.com','ch_client','scripts.chitika.net/','_gaq.push','jotform.com/');
	private $domove = array('gaJsHost','load_cmc','jd.gallery.transitions.js','swfobject.embedSWF(','tiny_mce.js','tinyMCEPreInit.go');
	private $domovelast = array('addthis.com','/afsonline/show_afs_search.js','disqus.js','networkedblogs.com/getnetworkwidget','infolinks.com/js/','jd.gallery.js.php','jd.gallery.transitions.js','swfobject.embedSWF(','linkwithin.com/widget.js','tiny_mce.js','tinyMCEPreInit.go');
	private $trycatch = false;
	private $yui = false;
	private $jscode = '';
	private $url = '';
	private $move = array('first' => array(), 'last' => array());
	private $restofcontent = '';
	private $md5hash = '';
	
	//Reads the page and collects script tags
	public function read($options)
	{
		//Remove everything that's not the header
		if($options['justhead'] == true)
		{
			$content = explode('</head>',$this->content,2);
			$this->content = $content[0].'</head>';
			$this->restofcontent = $content[1];
		}
		
		//Should we add try-catch?
		if($options['trycatch'] == true)
			$this->trycatch = true;
		
		//Do we use yui?
		$this->yui = $options['yui'];
		
		//Get script files
		if(preg_match_all('#<script.*</script>#Usmi',$this->content,$matches))
		{
			foreach($matches[0] as $tag)
			{
				if(preg_match('#src=("|\')(.*)("|\')#Usmi',$tag,$source))
				{
					//External script
					$url = current(explode('?',$source[2],2));
					$path = $this->getpath($url);
					if($path !==false && preg_match('#\.js$#',$path))
					{
						//Inline
						if($this->ismergeable($tag))
						{
							//We can merge it
							$this->scripts[] = $path;
						}else{
							//No merge, but maybe we can move it
							if($this->ismovable($tag))
							{
								//Yeah, move it
								if($this->movetolast($tag))
								{
									$this->move['last'][] = $tag;
								}else{
									$this->move['first'][] = $tag;
								}
							}else{
								//We shouldn't touch this
								$tag = '';
							}
						}
					}else{
						//External script (example: google analytics)
						//OR Script is dynamic (.php etc)
						if($this->ismovable($tag))
						{
							if($this->movetolast($tag))
							{
								$this->move['last'][] = $tag;
							}else{
								$this->move['first'][] = $tag;
							}
						}else{
							//We shouldn't touch this
							$tag = '';
						}
					}
				}else{
					//Inline script
					if($this->ismergeable($tag))
					{
						preg_match('#<script.*>(.*)</script>#Usmi',$tag,$code);
						$code = preg_replace('#.*<!\[CDATA\[(?:\s*\*/)?(.*)(?://|/\*)\s*?\]\]>.*#sm','$1',$code[1]);
						$code = preg_replace('/(?:^\\s*<!--\\s*|\\s*(?:\\/\\/)?\\s*-->\\s*$)/','',$code);
						$this->scripts[] = 'INLINE;'.$code;
					}else{
						//Can we move this?
						if($this->ismovable($tag))
						{
							if($this->movetolast($tag))
							{
								$this->move['last'][] = $tag;
							}else{
								$this->move['first'][] = $tag;
							}
						}else{
							//We shouldn't touch this
							$tag = '';
						}
					}
				}
				
				//Remove the original script tag
				$this->content = str_replace($tag,'',$this->content);
			}
			
			return true;
		}
	
		//No script files :(
		return false;
	}
	
	//Joins and optimizes JS
	public function minify()
	{
		foreach($this->scripts as $script)
		{
			if(preg_match('#^INLINE;#',$script))
			{
				//Inline script
				$script = preg_replace('#^INLINE;#','',$script);
				//Add try-catch?
				if($this->trycatch)
					$script = 'try{'.$script.'}catch(e){}';
				$this->jscode .= "\n".$script;
			}else{
				//External script
				if($script !== false && file_exists($script) && is_readable($script))
				{
					$script = file_get_contents($script);
					//Add try-catch?
					if($this->trycatch)
						$script = 'try{'.$script.'}catch(e){}';
					$this->jscode .= "\n".$script;
				}/*else{
					//Couldn't read JS. Maybe getpath isn't working?
				}*/
			}
		}
		
		//Check for already-minified code
		$this->md5hash = md5($this->jscode);
		$ccheck = new autoptimizeCache($this->md5hash,'js');
		if($ccheck->check())
		{
			$this->jscode = $ccheck->retrieve();
			return true;
		}
		unset($ccheck);
		
		//$this->jscode has all the uncompressed code now. 
		if($this->yui == false && class_exists('JSMin'))
		{
			$this->jscode = trim(JSMin::minify($this->jscode));
			return true;
		}elseif($this->yui == true && autoptimizeYUI::available()){
			$this->jscode = autoptimizeYUI::compress('js',$this->jscode);
			return true;
		}else{
			return false;
		}
	}
	
	//Caches the JS in uncompressed, deflated and gzipped form.
	public function cache()
	{
		$cache = new autoptimizeCache($this->md5hash,'js');
		if(!$cache->check())
		{
			//Cache our code
			$cache->cache($this->jscode,'text/javascript');
		}
		$this->url = AUTOPTIMIZE_CACHE_URL.$cache->getname();
	}
	
	//Returns the content
	public function getcontent()
	{
		//Restore the full content
		if(!empty($this->restofcontent))
		{
			$this->content .= $this->restofcontent;
			$this->restofcontent = '';
		}
		
		//Add the scripts
		$bodyreplacement = implode('',$this->move['first']);
		$bodyreplacement .= '<script type="text/javascript" src="'.$this->url.'"></script>';
		$bodyreplacement .= implode('',$this->move['last']).'</body>';
		$this->content = str_replace('</body>',$bodyreplacement,$this->content);
		
		//Return the modified HTML
		return $this->content;
	}
	
	//Checks agains the whitelist
	private function ismergeable($tag)
	{
		foreach($this->domove as $match)
		{
			if(strpos($tag,$match)!==false)
			{
				//Matched something
				return false;
			}
		}
		
		foreach($this->dontmove as $match)
		{
			if(strpos($tag,$match)!==false)
			{
				//Matched something
				return false;
			}
		}
		
		//If we're here it's safe to merge
		return true;
	}
	
	//Checks agains the blacklist
	private function ismovable($tag)
	{
		
		foreach($this->domove as $match)
		{
			if(strpos($tag,$match)!==false)
			{
				//Matched something
				return true;
			}
		}
		
		foreach($this->dontmove as $match)
		{
			if(strpos($tag,$match)!==false)
			{
				//Matched something
				return false;
			}
		}
		
		//If we're here it's safe to move
		return true;
	}
	
	private function movetolast($tag)
	{
		foreach($this->domovelast as $match)
		{
			if(strpos($tag,$match)!==false)
			{
				//Matched, return true
				return true;
			}
		}
		
		//Should be in 'first'
		return false;
	}
}
