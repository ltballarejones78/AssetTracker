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
$sql = "SELECT  UserID,AssociateID , FirstName, LastName, Email from tblcisuser where TeamID= ".$_POST['Teamselectid'];
$data = array();
$result = mysqli_query($mysql_connection, $sql);
echo  "<option value=''>Select an Associate:</option> ";
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row['UserID'] . "' >" . $row['FirstName'] ."  ". $row['LastName']. "</option>";
    //bash_print_r($row);
}
//encoded for the datatables plug in.
