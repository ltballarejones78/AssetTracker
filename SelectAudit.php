<?php

require_once("includes/globalphp.php");
//Sanitze anything we receive from a user

//get connection string from global
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$sql = "SELECT `AuditID`, `Actiondate`, `Username`, `ActionType`, `DeviceID`, `ActionPerformed` FROM `tblauditlog`  ";
$data = array();
$result = mysqli_query($mysql_connection, $sql);
while ($row = mysqli_fetch_array($result)) {
    $data[] = $row;
    //bash_print_r($row);
}
//encoded for the datatables plug in.
echo json_encode($data);