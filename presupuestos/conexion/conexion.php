<?php		//local a phpmyadmin
		$username="root";
		$password="";
		$database="sarmiento";
		$url="localhost";
		mysql_connect($url,$username,$password);
		@mysql_select_db($database) or die( "No pude conectarme a la base de datos");
?>