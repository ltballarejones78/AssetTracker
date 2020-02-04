<?php
	require_once("functions/functions.php");
	
	session_start();
	
	$QUERIES = array();
		static $DATABASE = array(
		'hostname' => 'localhost',
		'username' => 'connectuser',
		'password' => 'connectuser',
		'database' => 'devicecheckoutdev'
	);