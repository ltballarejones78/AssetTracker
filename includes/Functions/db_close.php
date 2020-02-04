<?php
	function db_close($mysql_connection)
	{
		mysqli_close($mysql_connection);
	}