<?php

class autoptimizeCDN extends autoptimizeBase
{
	private $js = false;
	private $jsurl = null;
	private $css = false;
	private $cssurl = null;
	private $replace = array();
	
	//Gets the tags that need replacing
	public function read($options)
	{
		//Remove the HTML comments?
		$this->js = (bool) $options['js'];
		$this->jsurl = $options['jsurl'];
		$this->css = (bool) $options['css'];
		$this->cssurl = $options['cssurl'];
		$this->img = (bool) $options['img'];
		$this->imgurl = $options['imgurl'];
		$siteurl = get_bloginfo('siteurl');
		
		if($this->js)
		{
			if(preg_match_all('#<script[^>]*src[^>]*>.*</script>#Usmi',$this->content,$matches))
			{
				foreach($matches[0] as $tag)
				{
					if(preg_match('#src=("|\')(.*)("|\')#Usmi',$tag,$url))
					{
						$url = $url[2];
						if(strpos($url,$siteurl)!==false)
						{
							$this->replace[$tag] = str_replace($siteurl,$this->jsurl,$tag);
						}
					}
				}
			}
		}
		
		if($this->css)
		{
			if(preg_match_all('#<link[^>]*stylesheet[^>]*>#Usmi',$this->content,$matches))
			{
				foreach($matches[0] as $tag)
				{
					if(preg_match('#href=("|\')(.*)("|\')#Usmi',$tag,$url))
					{
						$url = $url[2];
						if(strpos($url,$siteurl)!==false)
						{
							$this->replace[$tag] = str_replace($siteurl,$this->cssurl,$tag);
						}
					}
				}
			}
		}
		
		if($this->img)
		{
			if(preg_match_all('#<img[^>]*src[^>]*>#Usmi',$this->content,$matches))
			{
				foreach($matches[0] as $tag)
				{
					if(preg_match('#src=("|\')(.*)("|\')#Usmi',$tag,$url))
					{
						$url = $url[2];
						if(strpos($url,$siteurl)!==false)
						{
							$this->replace[$tag] = str_replace($siteurl,$this->imgurl,$tag);
						}
					}
				}
			}
		}
		//Do we need further processing?
		return (count($this->replace)>0);
	}
	
	//Do the tag replacing
	public function minify()
	{
		//Replace the tags with the CDNed ones
		$this->content = str_replace(array_keys($this->replace),array_values($this->replace),$this->content);
	}
	
	//Does nothing
	public function cache()
	{
		//No cache for CDN
		return true;
	}
	
	//Returns the content
	public function getcontent()
	{
		return $this->content;
	}
}
