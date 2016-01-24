<?php
//général
	mb_internal_encoding('UTF-8');
    ini_set( "display_errors", true );
	date_default_timezone_set( "Europe/Paris");  // http://www.php.net/manual/en/timezones.php
	define( "SITE_PATH", "http://localhost/projet/");

// Pages
	define( "SITE_NAME", "Party MANAGEMENT");

// BASE DE DONNEES
	define( "DB_DSN", "mysql:host=localhost;dbname=projet_1" );
	define( "DB_USERNAME", "root" );
	define( "DB_PASSWORD", "" );
	define( "DB_PREFIX", "");

	 
?>