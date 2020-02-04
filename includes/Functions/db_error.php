<?php
	function db_error($mysqli_error, $query = "")
	{
			echo "<pre>";
			echo "Query: {$query}\n";
			echo "Error: {$mysqli_error}";
			echo "</pre>";
		
		die();
	}
?>