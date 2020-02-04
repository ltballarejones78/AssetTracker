<?php
	function db_mysql_query($query)
	{
		global $QUERIES;
		$start = microtime(true);
		$result = mysqli_query($query) or db_error(mysqli_error(),$query);
		$end = microtime(true);
		
		$QUERIES[] = array(
			'query' => $query,
			'total_time' => $end-$start
		);
		
		return $result;
	}