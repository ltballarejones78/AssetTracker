<?php
require_once("Header.php");
require_once("includes/globalphp.php");
$q = filter_input(INPUT_GET, 'TeamID', FILTER_SANITIZE_NUMBER_INT);
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$data = array();
$query2 = "SELECT * from tblteam where TeamID =" . $q;
$result = mysqli_query($mysql_connection, $query2);
while ($row3 = mysqli_fetch_array($result)) {
    $data[] = $row3;
    //bash_print_r($row3);
}
//encoded for the datatables plug in.
db_close($mysql_connection);
?>
<script src="js/Teams.js"></script>
</br>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header ">
                    Team Users - <?php echo strval($data[0]['TeamName']);?>
                    <a id="editUserbtn" href="" class="btn-lg btn-success float-Right" style="visibility: hidden">Edit</a>
                </div>
                <div class="card-body">
                    <table id="Teamstable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>AssociateID</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Email</th>
                        </tr>
                        </thead>

                    </table>

                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="alert alert-success alert-dismissible" id="successIuser" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header ">Current Checked out devices
                    <a id="ChckInDbtn" data-toggle="modal"  class="btn-lg btn-danger float-Right" style="display:none">Check-In</a>
                    <a id="ChckOutDbtn" data-toggle="modal"  class="btn-lg btn-warning float-Right" style="display:none">Check-Out</a>
                    <a id="editDevicebtn" href="" class="btn-lg btn-success float-Right" style="display:none">Edit</a>
                </div>
                <div class="card-body">
                    <table id="UserTDevicetable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th >Device ID</th>
                            <th>Device Type</th>
                            <th>AssetTag</th>
                            <th>Manufacturer</th>
                            <th>Checked out By</th>
                            <th>Return Date</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCheckIn" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="DeviceInID" name="DeviceID" value="">
                <input type="hidden" id="TeamInID" name="TeamID" value="">
                <p id="mBody"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCheckInDevice" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCheckOut" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="DeviceOutID" name="DeviceID" value="">
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
            <div class="modal-footer">
                <button type="button" id="btnCheckoutDevice" class="btn btn-primary">Check out Device</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>