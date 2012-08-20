<?php

class autoptimizeHTML extends autoptimizeBase
{
	private $keepcomments = false;
	
	//Does nothing
	public function read($options)
	{
		//Remove the HTML comments?
		$this->keepcomments = (bool) $options['keepcomments'];
		
		//Nothing to read for HTML
		return true;
	}
	
	//Joins and optimizes CSS
	public function minify()
	{
		if(class_exists('Minify_HTML'))
		{
			//Minify html
			$options = array('keepComments' => $this->keepcomments);
			$this->content = Minify_HTML::minify($this->content,$options);
			return true;
		}
		
		//Didn't minify :(
		return false;
	}
	
	//Does nothing
	public function cache()
	{
		//No cache for HTML
		return true;
	}
	
	//Returns the content
	public function getcontent()
	{
		return $this->content;
	}
}
