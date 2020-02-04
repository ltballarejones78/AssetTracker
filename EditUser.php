<?php
require_once("Header.php");
require_once("includes/globalphp.php");
$q = filter_input(INPUT_GET, 'User', FILTER_SANITIZE_NUMBER_INT);
global $DATABASE;
//open connection string.
$mysql_connection = db_open($DATABASE);
// Check connection
if ($mysql_connection->connect_error) {
    die("Connection failed: " . $mysql_connection->connect_error);
}
$data = array();
$query2 = "SELECT UserID,AssociateID,FirstName,LastName,Email,Title,Manager,TeamID,Manages from tblcisuser where UserID =" . $q;
$result = mysqli_query($mysql_connection, $query2);
while ($row3 = mysqli_fetch_array($result)) {
    $data[] = $row3;
    //bash_print_r($row3);
}
//encoded for the datatables plug in.
db_close($mysql_connection);
?>
</br>
<script src="js/EditUser.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header ">Edit User - <?php echo strval($data[0]['FirstName']) .'  '. strval($data[0]['LastName'])?></div>
                <div class="card-body">

                    <div class="row">

                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="sEelectid" class="control-label">Team:</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            $query1 = "select TeamID,TeamName from tblteam";
                            $result = mysqli_query($mysql_connection, $query1);

                            echo "<select name='PcID' id='Eselectid' class ='form-control' >"
                                . "<option value=''>Select a Team:</option> ";
                            while ($row = mysqli_fetch_array($result)) {
                                if($row['TeamID'] == $data[0]['TeamID'])
                                {
                                    echo "<option value='" . $row['TeamID'] . "' selected ='selected'>" . $row['TeamName'] . " </option>";
                                }
                                else
                                {
                                    echo "<option value='" . $row['TeamID'] . "' >" . $row['TeamName'] . "</option>";
                                }

                            }
                            echo "</select> ";
                            ?>
                        </div>

                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtAssociateID">Associate ID </label>
                            <input type="text" class="form-control" id="txtEAssociateID"  value="<?php echo strval($data[0]['AssociateID'])?>" placeholder="Associate ID">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtAssociateName">First Name</label>
                            <input type="text" class="form-control" id="txtEAssociateFName" value="<?php echo strval($data[0]['FirstName'])?>" placeholder="First name"
                                   required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtAssociateName">Last Name</label>
                            <input type="text" class="form-control" id="txtEAssociateLName" value="<?php echo strval($data[0]['LastName'])?>" placeholder="Last name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="txtAssociateName">Email</label>
                            <input type="text" class="form-control" id="txtEAssociateEmail" value="<?php echo strval($data[0]['Email'])?>" placeholder="Email">
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="selectManager">Title</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            $query2 = "select * from tbltypetitle order by Title ";
                            $result2 = mysqli_query($mysql_connection, $query2);

                            echo "<select name='Titleselect' id='TitleEselectid'   class ='form-control' >"
                                . "<option value=''>Select a Title:</option> ";

                            while ($row1 = mysqli_fetch_array($result2)) {
                                if($row1['id'] == $data[0]['Title'])
                                {
                                    echo "<option value='" . $row1['id'] . "' selected ='selected'>" . $row1['Title'] . " </option>";
                                }
                                else
                                {
                                    echo "<option value='" . $row1['id'] . "' >" . $row1['Title'] . "</option>";
                                }
                            }
                            echo "</select> ";
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="selectManager">Manager</label>
                            <?php
                            $mysql_connection = db_open($DATABASE);
                            $query2 = "select * from tblcisuser where Manages = 1 order by LastName asc ";
                            $result2 = mysqli_query($mysql_connection, $query2);

                            echo "<select name='Managerselect' id='MEselectid'   class ='form-control' onchange='changeTeamindex(this.value)'>"
                                . "<option value=''>Select a Manager:</option> ";

                            while ($row1 = mysqli_fetch_array($result2)) {
                            if($row1['AssociateID'] == $data[0]['Manager'])
                            {
                                echo "<option style='height: 100px' value='" . $row1['AssociateID'] . "' selected ='selected'>" . $row1['FirstName'] . "," . $row1['LastName'] . "</option>";
                            }
                            else
                            {
                                echo "<option style='height: 100px' value='" . $row1['AssociateID'] . "'>" . $row1['FirstName'] . "," . $row1['LastName'] . "</option>";
                            }
                            }
                            echo "</select>";
                            ?>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="alert alert-success alert-dismissible" id="successIuser" style="display:none;">
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
        <div class=col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header ">Current Checked out devices
                    <a id="editDbtn" href="" class="btn-lg btn-success float-Right" style="display:none">Edit Device/Audit Trail</a>
                    <a id="ChckInDbtn" data-toggle="modal"  class="btn-lg btn-danger float-Right" style="display:none">Check-In</a>
                </div>
                <div class="card-body">
                    <div class="col-sm-12">
                    <table id="UserIDevicetable" class="table table-striped table-bordered dataTable" style="width:100%;">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Device ID</th>
                            <th>Device Type</th>
                            <th>AssetTag</th>
                            <th>Manufacturer</th>
                            <th>Return Date</th>
                            <th>Return Date</th>
                            <th>Return Date</th>
                            <th>Return Date</th>
                        </tr>
                        </thead>

                    </table>
                    </div>
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
                <input type="hidden" id="DeviceAssetTag" name="DeviceID" value="">
                <input type="hidden" id="TeamInID" name="TeamID" value="">
                <input type="hidden" id="TeamInTxt" name="TeamID" value="">
                <input type="hidden" id="AssociateIDtxt" name="DeviceID" value="">
                <p id="mBody"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCheckInDevice" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
