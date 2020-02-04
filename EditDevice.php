<?php
require_once("Header.php");
require_once("includes/globalphp.php");
$q = filter_input(INPUT_GET, 'Device', FILTER_SANITIZE_NUMBER_INT);
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$data = array();
$query2 = "SELECT ttd.TypeID,ttd.DeviceType, td.AssetTag, td.Manufacturer, td.CheckoutBy, td.ReturnDate, td.TeamOwnedID from tbldevice td
inner join tbltypedevice ttd on td.devicetype = ttd.TypeID
where DeviceID  =" . $q;
$result = mysqli_query($mysql_connection, $query2);
while ($row3 = mysqli_fetch_array($result)) {
    $data[] = $row3;
    //bash_print_r($row3);
}
//encoded for the datatables plug in.
db_close($mysql_connection);
?>
</br>
<script src="js/EditDevice.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header ">Edit Device
                    - <?php echo strval($data[0]['DeviceType']) . ' - ' . strval($data[0]['AssetTag']) ?></div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="DTypeselectid" class="control-label">Device Type:</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            $query1 = "select TypeID,DeviceType from tbltypedevice";
                            $result = mysqli_query($mysql_connection, $query1);

                            echo "<select name='PcID' id='DTselectid' class ='form-control' >"
                                . "<option value=''>Select a Team:</option> ";
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['TypeID'] == $data[0]['TypeID']) {
                                    echo "<option value='" . $row['TypeID'] . "' selected ='selected'>" . $row['DeviceType'] . " </option>";
                                } else {
                                    echo "<option value='" . $row['TypeID'] . "' >" . $row['DeviceType'] . "</option>";
                                }

                            }
                            echo "</select> ";
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtEAssetTag">Asset Tag </label>
                            <input type="text" class="form-control" id="txtEAssetTag"
                                   value="<?php echo strval($data[0]['AssetTag']) ?>" placeholder="Asset Tag">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtEManufacturer">Manufacturer</label>
                            <input type="text" class="form-control" id="txtEManufacturer"
                                   value="<?php echo strval($data[0]['Manufacturer']) ?>" placeholder="Manufacturer"
                                   required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtEReturnDate">Return Date</label>
                            <input type="date" class="form-control" id="txtEReturnDate"
                                   value="<?php echo strval($data[0]['ReturnDate']) ?>" placeholder="mm/dd/yyyy">
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="Dselectid" class="control-label">Associate:</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            if(isset($data[0]['TeamOwnedID']) )
                            {
                                $query2 = "select UserID ,FirstName,LastName from tblcisuser Where TeamID =".$data[0]['TeamOwnedID'];
                                $result2 = mysqli_query($mysql_connection, $query2);
                            }
                            else{
                                $query3 = "select UserID ,FirstName,LastName from tblcisuser ";
                                $result2 = mysqli_query($mysql_connection, $query3);
                            }


                            echo "<select name='PcID' id='Aselectid' class ='form-control' >"
                                . "<option value=''>Select a Associate:</option> ";
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if ($row2['UserID'] == $data[0]['CheckoutBy']) {
                                    echo "<option value='" . $row2['UserID'] . "' selected ='selected'>" . $row2['FirstName'] ."  ". $row2['LastName']. " </option>";
                                } else {
                                    echo "<option value='" . $row2['UserID'] . "' >" . $row2['FirstName'] ."  ". $row2['LastName']. "</option>";
                                }

                            }
                            echo "</select> ";
                            ?>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="Dselectid" class="control-label">Team:</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            $query2 = "select TeamID,TeamName from tblteam";
                            $result2 = mysqli_query($mysql_connection, $query2);

                            echo "<select name='PcID' id='Teamselectid' class ='form-control'>"
                                . "<option value=''>Select a Team:</option> ";
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if ($row2['TeamID'] == $data[0]['TeamOwnedID']) {
                                    echo "<option value='" . $row2['TeamID'] . "' selected ='selected'>" . $row2['TeamName'] . " </option>";
                                } else {
                                    echo "<option value='" . $row2['TeamID'] . "' >" . $row2['TeamName'] . "</option>";
                                }

                            }
                            echo "</select> ";
                            ?>
                        </div>
                    </div>


                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="alert alert-success alert-dismissible" id="successUDevice" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <label style="color:red" id="txtEditUserError"></label>
                            <button type="submit" class="btn btn-success pull-right" id="btnEditDevice">Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header ">DeviceAuditTable</div>
                <div class="card-body">
                    <table id="UserDeviceAudittable" class="table table-striped table-bordered">
                        <thead>
                        <tr>

                            <th>Device ID</th>
                            <th>Device Type</th>
                            <th>AssetTag</th>
                            <th>Manufacturer</th>
                            <th>Return Date</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
