<?php

session_start();
if(!isset($_SESSION["logged"])) {
    $_SESSION["logged"] = false;
}
if(!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}



try{
	$db=new PDO("pgsql:dbname=si1; host=localhost","alumnodb","alumnodb");
	
	}
catch(PDOException$e){echo$e->getMessage();}






?>
