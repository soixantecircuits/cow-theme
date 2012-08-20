<?php

class autoptimizeYUI
{
	static function available()
	{
		//If we can run apps
		if(function_exists('shell_exec') && is_callable('shell_exec'))
		{
			//And if YUI is there for us
			if(file_exists('/usr/bin/java') && file_exists(WP_PLUGIN_DIR.'/autoptimize/yui/yuicompressor.jar'))
			{
				//And we have a dir in where to work
				if(is_writable(WP_PLUGIN_DIR.'/autoptimize/yui/'))
				{
					//Then we're available
					return true;
				}
			}
		}
		//We can't use YUI :(
		return false;
	}
	
	static function compress($type,$code)
	{
		//Check for supported types
		if(!in_array($type,array('js','css')))
			return false;
		
		//Write temp file
		$file = tempnam(WP_PLUGIN_DIR.'/autoptimize/yui/',$type);
		file_put_contents($file,$code);
		
		//Call YUI
		$yuipath = escapeshellarg(WP_PLUGIN_DIR.'/autoptimize/yui/yuicompressor.jar');
		$code = shell_exec('/usr/bin/java -jar '.$yuipath.' --type '.$type.' '.escapeshellarg($file));
		
		//Delete temp file
		unlink($file);
		
		//Give the code!
		return $code;
	}
}
