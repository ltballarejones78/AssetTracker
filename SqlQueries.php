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
$User = $_COOKIE['ID_my_site'];
date_default_timezone_set('America/Chicago');
switch ($q) {
    case "InsertUser":

        if ($stmt = mysqli_prepare($mysql_connection, "INSERT INTO  tblcisuser( AssociateID, FirstName, LastName, Email, Title, Manager, TeamID, Manages) VALUES (?,?,?,?,?,?,?,?)")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 'ssssssss', $AID, $FName, $LName, $Email, $Title, $Manager, $TID, $Manages);
            $TID = $_POST['TID'];
            $AID = $_POST['AID'];
            $FName = $_POST['AFname'];
            $LName = $_POST['ALname'];
            $Email = $_POST['AEmail'];
            $Title = $_POST['Atitle'];
            $Manager = $_POST['Amanager'];
            $Manages = 0;
            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Insert User';
                    $DeviceID = Null;
                    $Action = 'User - ' . $User . ' created a new Associate ' . $FName . ' ' . $LName . ' AssociateID - ' . $AID;
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }
        }
        db_close($mysql_connection);
        break;
    case "UpdateUser":
        if ($stmt = mysqli_prepare($mysql_connection, "Update tblcisuser set associateid = ?, FirstName = ?,LastName = ?, Email = ?,Title = ? , Manager = ? ,TeamID = ?  where AssociateID = ? ")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 'sssssss', $AID, $FName, $LName, $Email, $Title, $Manager, $TID);
            $AID = $_POST['AID'];
            $FName = $_POST['AFname'];
            $LName = $_POST['ALname'];
            $Email = $_POST['AEmail'];
            $Title = $_POST['Atitle'];
            $Manager = $_POST['Amanager'];
            $TID = $_POST['TID'];
        }
        //$sql = "Update tblcisuser Set associateid = '$AID', FirstName='$FName', LastName ='$LName', Email = '$Email', Title ='$Title', Manager ='$Manager', TeamID = '$TID' where AssociateID = '$AID'  ";

        if (mysqli_stmt_execute($stmt)) {
            if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
            {
                if (!$stmt1) {
                    die('mysqli error: ' . mysqli_error($mysql_connection));
                }
                mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                $Date = date("Y-m-d H:i:s");
                $ActionType = 'Update User Profile';
                $DeviceID = Null;
                $Action = 'User - ' . $User . ' Updated User profile ' . $FName . '  ' . $LName . ' AssociateID - ' . $AID;
                //$Action ='User ';
                mysqli_stmt_execute($stmt1);
            }
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($mysql_connection);
        }

        db_close($mysql_connection);
        break;
    case "InsertDevice":

        if ($stmt = mysqli_prepare($mysql_connection, "INSERT INTO  tbldevice(  DeviceType, AssetTag, Manufacturer, CheckoutBy, ReturnDate) VALUES (?,?,?,?,?)")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 'ssssss', $DID, $ATag, $Manu, $Checkout, $ReturnDate);
            $DID = $_POST['DID'];
            $ATag = $_POST['ATag'];
            $Manu = $_POST['Manu'];
            $Checkout = null;
            $ReturnDate = null;

            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Insert New Device';
                    $DeviceID = Null;
                    $Action = 'User - ' . $User . ' Inserted New  Device ' . $ATag;
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }
        }
        db_close($mysql_connection);
        break;
    case "UpdateDevice":
        if ($stmt = mysqli_prepare($mysql_connection, "Update tbldevice set DeviceType = ?, AssetTag = ?,Manufacturer = ?, Checkoutby = ?,ReturnDate = ? , TeamOwnedID = ? where tbldevice.DeviceID = ?")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 'sssssss', $DT, $ATag, $Manu, $AssocID, $Rdate, $TeamID, $DID);
            //$sql = "Update tbldevice set DeviceType='$DT',AssetTag='$ATag',Manufacturer='$Manu',Checkoutby= $AssocID,ReturnDate = '$Rdate' ,TeamOwnedID= $TeamID where tbldevice.DeviceID = '$DID' ";
            $DID = $_POST['DID'];
            $ATag = $_POST['ATag'];
            $Manu = $_POST['Manu'];
            $DT = $_POST['DeviceType'];
            //this was done because the field in the DB is a DateTime and wont accept a String 'NULL' as a value to completely NULL the column value. So i had to send a NULL
            if (!empty($_POST['Rdate'])) {
                $Rdate = $_POST['Rdate'];
            } else {
                $Rdate = null;
            }
            //echo $Rdate;
            if (!empty($_POST['AssocSelect'])) {
                $AssocID = $_POST['AssocSelect'];
            } else {
                $AssocID = null;
            }
            // echo $AssocID;
            if (!empty($_POST['Teamselectid'])) {

                $TeamID = $_POST['Teamselectid'];
            } else {
                $TeamID = null;
            }
            //echo $TeamID;
            /* execute prepared statement */
            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Update Device';
                    $DeviceID = $DID;
                    $Action = 'User - ' . $User . ' Updated Device -' . $ATag;
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }


        }
        db_close($mysql_connection);
        break;
    case "RemoveUserDevice":
        //this is not in use right now.
        $DID = filter_input(INPUT_GET, 'DID', FILTER_SANITIZE_NUMBER_INT);
        $sql = "UPDATE `tbldevice` SET `CheckoutBy`= Null , `ReturnDate` = Null WHERE DeviceID = '$DID'";
        if ($mysql_connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo mysqli_error($mysql_connection);
        }

        db_close($mysql_connection);
        break;
    case "UpdateDeviceOwner":
        if ($stmt = mysqli_prepare($mysql_connection, "Update tbldevice set  Checkoutby = ?,ReturnDate = ? , TeamOwnedID = ? where tbldevice.DeviceID = ?")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 'ssss', $AssocID, $Rdate, $TeamID, $DID);
            $DID = $_POST['DID'];
            if (!empty($_POST['Teamselectid'])) {
                $TeamID = $_POST['Teamselectid'];
            } else {
                $TeamID = null;
            }
            if (!empty($_POST['AssocSelect'])) {
                $AssocID = $_POST['AssocSelect'];
            } else {
                $AssocID = null;
            }
            if (!empty($_POST['AssocSelecttxt'])) {
                $AssocTxt = $_POST['AssocSelecttxt'];
            }
            if (!empty($_POST['Rdate'])) {
                $Rdate = $_POST['Rdate'];
            }
            if (!empty($_POST['Teamselecttxt'])) {
                $Teamselecttxt = $_POST['Teamselecttxt'];
            }
             if (!empty($_POST['DeviceAssetTag'])) {
                 $DeviceAssetTag = $_POST['DeviceAssetTag'];
             }
            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Update Device';
                    $DeviceID = $DID;
                    if (!empty($_POST['CIN'])) {
                        $Action = 'User - ' . $User . ' Checked in device. Device Asset Tag - ' . $DeviceAssetTag . ' Reassigned to Team - ' . $Teamselecttxt;
                    }
                    else{
                        $Action = 'User - ' . $User . ' Checked out device. Device Asset Tag -' . $DeviceAssetTag . ' For  Owner - ' . $AssocTxt;
                    }
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }
        }
        db_close($mysql_connection);
        break;
    case "SelectAssociates":

        $data = array();
        $mysql_connection = db_open($DATABASE);
        $query2 = "SELECT UserID,AssociateID,FirstName,LastName,Email,Title,Manager,TeamID,Manages from tblcisuser";
        //$query2 = "SELECT UserID,AssociateID,FirstName,LastName,Email,Title,Manager,tblteam.TeamID,tblteam.TeamName,Manages,tblteam.Department FROM `tblcisuser` inner join tblteam on tblcisuser.TeamID = tblteam.TeamID ";
        $result = mysqli_query($mysql_connection, $query2);
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
            //bash_print_r($row);
        }
        //encoded for the datatables plug in.
        echo json_encode($data);

        break;
    case "InsertTypeTitle":
        if ($stmt = mysqli_prepare($mysql_connection, "INSERT INTO tbltypetitle(Title)  VALUES (?)")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 's', $Title);
            $Title = $_POST['title'];

            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Insert Title Type';
                    $DeviceID = Null;
                    $Action = 'User - ' . $User . ' Inserted New Title Into Title table! Title -' . $Title;
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }
        }
        db_close($mysql_connection);
        break;
    case "InsertTypeDevice":
        if ($stmt = mysqli_prepare($mysql_connection, "INSERT INTO  tbltypedevice (DeviceType) VALUES (?)")) ;
        {
            if (!$stmt) {
                die('mysqli error: ' . mysqli_error($mysql_connection));
            }
            mysqli_stmt_bind_param($stmt, 's', $device);
            $device = $_POST['device'];
            if (mysqli_stmt_execute($stmt)) {
                if ($stmt1 = mysqli_prepare($mysql_connection, "INSERT INTO tblauditlog (Actiondate, Username, ActionType, DeviceID, ActionPerformed) VALUES (?,?,?,?,?)")) ;
                {
                    if (!$stmt1) {
                        die('mysqli error: ' . mysqli_error($mysql_connection));
                    }
                    mysqli_stmt_bind_param($stmt1, 'sssss', $Date, $User, $ActionType, $DeviceID, $Action);
                    $Date = date("Y-m-d H:i:s");
                    $ActionType = 'Insert Device Type';
                    $DeviceID = Null;
                    $Action = 'User - ' . $User . ' Inserted New device type Into type table! Device Type -' . $device;
                    //$Action ='User ';
                    mysqli_stmt_execute($stmt1);
                }
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($mysql_connection);
            }
        }
        db_close($mysql_connection);
        break;

}


?>