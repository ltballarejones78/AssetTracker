<?php
	function db_open($database)
	{
		$mysql_connection = mysqli_connect($database['hostname'],$database['username'],$database['password']) or db_error(mysqli_error());
		mysqli_select_db($mysql_connection,$database['database']) or db_error(mysqli_error());
		return $mysql_connection;
	}