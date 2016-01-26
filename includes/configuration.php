<?php
//général
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	mb_internal_encoding('UTF-8');
	date_default_timezone_set( "Europe/Paris");  // http://www.php.net/manual/en/timezones.php
	define( "SITE_PATH", "http://nathanchevalier.fr/projets/projet/");

// Pages
	define( "SITE_NAME", "Party MANAGEMENT");

// BASE DE DONNEES
	define( "DB_DSN", "mysql:host=nathanchkxbde.mysql.db;dbname=nathanchkxbde" );
	define( "DB_USERNAME", "nathanchkxbde" );
	define( "DB_PASSWORD", "3pJTizY24kK9" );
	define( "DB_PREFIX", "");
	 
?>