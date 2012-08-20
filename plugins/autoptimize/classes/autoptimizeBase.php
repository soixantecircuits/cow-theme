<?php

abstract class autoptimizeBase
{
	protected $content = '';
	
	public function __construct($content)
	{
		$this->content = $content;
		//Best place to catch errors
	}
	
	//Reads the page and collects tags
	abstract public function read($justhead);
	
	//Joins and optimizes collected things
	abstract public function minify();
	
	//Caches the things
	abstract public function cache();
	
	//Returns the content
	abstract public function getcontent();
	
	//Converts an URL to a full path
	protected function getpath($url)
	{
		$path = str_replace(get_settings('home'),'',$url);
		if(preg_match('#^(https?|ftp)://#i',$path))
		{
			//External script (adsense, etc)
			return false;
		}
		$path = str_replace('//','/',ABSPATH.$path);
		return $path;
	}
}
