<?php
	/**
	*		SQLの接続
	*/
	function db_connect(){
		$dbUser = "tlauser";
		$dbPass = "crystal428";
		$dbHost = "localhost";
		$dbName = "tladata1";
		$dbType = "mysql";
		
		$conn = mysql_connect("$dbHost", "$dbUser", "$dbPass", true) 
			or die("MESSAGE : cannot connect!<BR>");
		
		mysql_select_db($dbName);
		exe_sql('set names utf8');
	}
	

	/**
	*		エスケープ処理
	*/
	function quote_smart($value){
		if (!is_numeric($value)) {
			if(get_magic_quotes_gpc()) stripslashes($value);
			$value = mysql_real_escape_string($value);
		}
		return $value;
	}
		
	/**
	*		SQLの発行
	*/
	function exe_sql($sql){
		$result = mysql_query($sql) 
			or die ('Invalid query: ' . mysql_error());
		return $result;
	}
?>
