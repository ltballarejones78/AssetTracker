<?php
require_once("includes/globalphp.php");
//Sanitze anything we receive from a user
$mykey = filter_input(INPUT_GET, 'mykey', FILTER_SANITIZE_STRING);
//get connection string from global
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$sql = "SELECT cu.UserID, dv.DeviceID ,dt.DeviceType, dv.AssetTag, dv.Manufacturer, cu.AssociateID as CheckoutBy , dv.ReturnDate, tt.TeamID FROM  tbldevice dv 
INNER join tbltypedevice dt on dt.TypeID = dv.DeviceType 
LEFT join tblcisuser cu on cu.UserID = dv.CheckoutBy
Left join tblteam tt on tt.TeamID = dv.TeamOwnedID
 where TeamOwnedID= ".$mykey;
$data = array();
$result = mysqli_query($mysql_connection, $sql);
while ($row = mysqli_fetch_array($result)) {
    $data[] = $row;
    //bash_print_r($row);
}
//encoded for the datatables plug in.
echo json_encode($data);
?>