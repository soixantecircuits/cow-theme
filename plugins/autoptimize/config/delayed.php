<?php exit;

//Check everything exists before using it
if(!isset($_SERVER['HTTP_ACCEPT_ENCODING']))
	$_SERVER['HTTP_ACCEPT_ENCODING'] = '';
if(!isset($_SERVER['HTTP_USER_AGENT']))
	$_SERVER['HTTP_USER_AGENT'] = '';
	
// Determine supported compression method
$gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
$deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');

// Determine used compression method
$encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');

// Check for buggy versions of Internet Explorer
if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') && 
	preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches))
{
	$version = floatval($matches[1]);
	
	if ($version < 6)
		$encoding = 'none';
		
	if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) 
		$encoding = 'none';
}

//Some servers compress the output of PHP - Don't break in those cases
if(ini_get('output_handler') == 'ob_gzhandler' || ini_get('zlib.output_compression') == 1)
	$encoding = 'none';

$iscompressed = file_exists(__FILE__.'.'.$encoding);
if($encoding != 'none' && $iscompressed == false)
{
	$flag = ($encoding == 'gzip' ? FORCE_GZIP : FORCE_DEFLATE);
	$code = file_get_contents(__FILE__.'.none');
	$contents = gzencode($code,9,$flag);
}else{
	//Get data
	$contents = file_get_contents(__FILE__.'.'.$encoding);
}

if ($encoding != 'none') 
{
	// Send compressed contents
	header('Content-Encoding: '.$encoding);
}
header('Vary: Accept-Encoding');
header('Content-Length: '.strlen($contents));

header('Content-type: %%CONTENT%%; charset=utf-8');
header('Cache-Control: max-age=315360000, public, must-revalidate');
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 315360000).' GMT'); //10 years

echo $contents;

//Write it here
if($encoding != 'none' && $iscompressed == false)
{
	//Write the content we sent
	file_put_contents(__FILE__.'.'.$encoding,$contents);
	
	//And write the new content
	$flag = ($encoding == 'gzip' ? FORCE_DEFLATE : FORCE_GZIP);
	$ext = ($encoding == 'gzip' ? 'deflate' : 'gzip');
	$contents = gzencode($code,9,$flag);
	file_put_contents(__FILE__.'.'.$ext,$contents);
}
