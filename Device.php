<?php
require_once("Header.php");
?>
<script src="js/Device.js"></script>
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#profile" data-toggle="tab">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#Home" data-toggle="tab">Insert Device</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="profile">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a id="ChckOutDbtn" data-toggle="modal"  class="btn-lg btn-warning float-Right" style="display:none">Check-Out</a>
                            <a id="ChckInDbtn" data-toggle="modal"  class="btn-lg btn-danger float-Right" style="display:none">Check-In</a>
                            <a id="editDbtn" href="" class="btn-lg btn-success float-Right" style="display:none">Edit Device/Audit Trail</a>
                            <h3>Device Table</h3>
                        </div>
                        <div class="card-body" style="display: block;">
                            <table id="DeviceTable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>DeviceID</th>
                                    <th>DeviceType</th>
                                    <th>AssetTag</th>
                                    <th>Manufacturer</th>
                                    <th>CheckoutBy</th>
                                    <th>ReturnDate</th>
                                    <th>Team</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="Home">
            <div class="container">
                </br>
                <div class="card">
                    <div class="card-header ">Insert Device</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="Dselectid" class="control-label">Device Type:</label>
                                <?php
                                $mysql_connection = db_open($DATABASE);
                                $query1 = "select * from tbltypedevice";
                                $result = mysqli_query($mysql_connection, $query1);

                                echo "<select name='PcID' id='Dselectid' class ='form-control '>"
                                    . "<option value=''>Select a Device Type:</option> ";

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['TypeID'] . "'>" . $row['DeviceType'] . "</option>";
                                }
                                echo "</select> ";
                                ?>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="txtDAssettag">Asset Tag</label>
                                <input type="text" class="form-control" id="txtDAssettag" placeholder="AssetTag">
                            </div>
                            <div class="form-group col-sm-12 col-lg-6">
                                <label for="txtDManufacturer">Manufacturer</label>
                                <input type="text" class="form-control" id="txtDManufacturer" placeholder="Manufacturer">
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="alert alert-success alert-dismissible" id="successIuser" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            </div>
                            <div class="form-group col-sm-12 col-lg-12">
                                <label style="color:red" id="txtInsertDeviceError"></label>
                                <button type="submit" class="btn btn-success pull-right" id="btnInsertDeviceUser">Insert
                                </button>
                            </div>
                        </div>
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
