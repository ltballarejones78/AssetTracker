<?php
require_once("includes/globalphp.php");
//Sanitze anything we receive from a user
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
//get connection string from global
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$data = array();
$mysql_connection = db_open($DATABASE);
$query2 = "SELECT TypeID,DeviceType from tbltypedevice";
$result = mysqli_query($mysql_connection, $query2);
while ($row = mysqli_fetch_array($result))
{
    $data[] = $row;
    //bash_print_r($row);
}
//encoded for the datatables plug in.
echo json_encode($data);
