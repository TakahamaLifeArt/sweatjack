<?php
	$url = 'http://api.aoikujira.com/zip/xml/get.php?zn=';
	
	$filepath = $url . $_POST['zipcode'];
	$xml = simplexml_load_file($filepath) or die("XMLパースエラー");
	$addr = $xml->value->ken.$xml->value->shi.$xml->value->cho;
	$addr = mb_convert_encoding($addr,"EUC-JP","utf-8");
	echo $addr;
?>