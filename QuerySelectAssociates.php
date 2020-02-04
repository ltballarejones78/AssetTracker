<?php
require_once("includes/globalphp.php");
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$data = array();
$mysql_connection = db_open($DATABASE);
$query2 = "SELECT UserID,AssociateID,FirstName,LastName,Email,Title,Manager,TeamID,Manages from tblcisuser";
//$query2 = "SELECT UserID,AssociateID,FirstName,LastName,Email,Title,Manager,tblteam.TeamID,tblteam.TeamName,Manages,tblteam.Department FROM `tblcisuser` inner join tblteam on tblcisuser.TeamID = tblteam.TeamID ";
$result = mysqli_query($mysql_connection, $query2);
while ($row = mysqli_fetch_array($result))
{
    $data[] = $row;
    //bash_print_r($row);
}
//encoded for the datatables plug in.
echo json_encode($data);