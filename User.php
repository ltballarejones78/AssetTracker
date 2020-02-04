<?php
require_once("Header.php");
?>
<script src="js/UserJS.js"></script>
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#profile" data-toggle="tab">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#Home" data-toggle="tab">Insert User</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="profile">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a id="editbtn" href="" class="btn-lg btn-success float-Right" style="visibility: hidden">Edit User</a>
                            <h3>Recent Activity</h3>
                        </div>
                        <div class="card-body" style="display: block;">

                            <table id="Usertable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>UserID</th>
                                    <th>AssociateID</th>
                                    <th>FirstName</th>
                                    <th>LastName</th>
                                    <th>Email</th>
                                    <th>Title</th>
                                    <th>Manager</th>
                                    <th>TeamID</th>
                                    <th>Manages</th>
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
                    <div class="card-header ">Insert User</div>
                    <div class="card-body">

                        <div class="row">

                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="selectid" class="control-label">Team:</label>
                                <?php
                                $mysql_connection = db_open($DATABASE);
                                $query1 = "select TeamID,TeamName from tblteam";
                                $result = mysqli_query($mysql_connection, $query1);

                                echo "<select name='PcID' id='Tselectid' class ='form-control' >"
                                    . "<option value=''>Select a Team:</option> ";

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['TeamID'] . "' required>" . $row['TeamName'] . "</option>";
                                }
                                echo "</select> ";
                                ?>
                            </div>

                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="txtAssociateID">Associate ID </label>
                                <input type="text" class="form-control" id="txtAssociateID" placeholder="Associate ID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="txtAssociateName">First Name</label>
                                <input type="text" class="form-control" id="txtAssociateFName" placeholder="First name"
                                       required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="txtAssociateName">Last Name</label>
                                <input type="text" class="form-control" id="txtAssociateLName" placeholder="Last name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="txtAssociateName">Email</label>
                                <input type="text" class="form-control" id="txtAssociateEmail" placeholder="Email">
                            </div>
                            <div class="form-group col-sm-12 col-lg-12">
                                <label for="selectManager">Title</label>
                                <?php
                                $mysql_connection = db_open($DATABASE);
                                $query2 = "select * from tbltypetitle order by Title ";
                                $result2 = mysqli_query($mysql_connection, $query2);

                                echo "<select name='Titleselect' id='Titleselectid'   class ='form-control' onchange='changeTeamindex(this.value)'>"
                                    . "<option value=''>Select a Title:</option> ";

                                while ($row1 = mysqli_fetch_array($result2)) {
                                    echo "<option style='height: 100px' value='" . $row1['id'] . "'>" . $row1['Title'] . "</option>";
                                }
                                echo "</select> </br>";
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

                                echo "<select name='Managerselect' id='Mselectid'   class ='form-control' onchange='changeTeamindex(this.value)'>"
                                    . "<option value=''>Select a Manager:</option> ";

                                while ($row1 = mysqli_fetch_array($result2)) {
                                    echo "<option style='height: 100px' value='" . $row1['AssociateID'] . "'>" . $row1['FirstName'] . "," . $row1['LastName'] . "</option>";
                                }
                                echo "</select> </br>";
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
                                <label style="color:red" id="txtInsertUserError"></label>
                                <button type="submit" class="btn btn-success pull-right" id="btnInsertUser">Insert
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

