<?php
	if(isset($_POST['email'])){
		list($localname, $domain) = explode("@", $_POST['email']);
		echo checkdnsrr($domain, 'MX');
	}else{
		echo false;
	}
?>