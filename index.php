<?php
//TO DO
	//&mode=twitter,facebook,simple,all
		//mode=all
			//default behaviour
		//mode=twitter
			//return just the ones that start with twitter
		//mode=facebook
			//return just the ones that start with facebook
		//mode=simple
			//return the first of each

header("Access-Control-Allow-Origin: *");

$URL_to_grab = $_GET['q'];
$mode = $_GET['mode'];


if ($URL_to_grab > '') {
	$meta_array = [];
	
	
	$doc = new DOMDocument();
	@$doc->loadHTMLFile($URL_to_grab);
	$xpath = new DOMXPath($doc);
	$meta_array['title'] = $xpath->query('//title')->item(0)->nodeValue;
	
	$metas = $xpath->query('/html/head/meta');
	
	foreach ($metas as $meta) {
		if (strtolower($meta->getAttribute('name')) > '') {
			$name = strtolower($meta->getAttribute('name'));	
		} else {
			$name = strtolower($meta->getAttribute('property'));	
		}
		
		if ($name > '') {
			$meta_array[$name] = $meta->getAttribute('content');	
		}
	}		
	echo '['.json_encode($meta_array).']';
} else {
	echo 'This page returns all meta information from an external site.<br />';
	echo 'To use this page, add "?q=" and a web link to the URL<br />';	
	echo 'Specific meta tags are available by using "&mode=" and one of the following options<br />';
	echo '- all: returns all meta tags (default)';
	echo '- simple: returns only the first instance of a metatag, rather than duplicating';
	echo '- twitter: returns only meta tags related to Twitter';
	echo '- facebook: returns only meta tags related to Facebook';
}
?>