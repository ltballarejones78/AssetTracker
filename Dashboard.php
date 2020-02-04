<?php
require_once("Header.php");
?>
</br>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Add, Edit and Delete Users.</p>
                    <a href="User.php" class="btn btn-primary">Go To Users Page</a>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card bg-info mb-3">
                <div class="card-body text-right">
                    <h5 class="card-title ">Devices</h5>
                    <p class="card-text">Add, Edit, Checkout and Delete devices</p>
                    <?php
                    //global $DATABASE;
                    //$mysql_connection = db_open($DATABASE);
                    //$query1 = "select count(DeviceID) as Dcount from tbldevice";
                    //$result = mysqli_query($mysql_connection, $query1);
                    //while ($row = mysqli_fetch_array($result)) {
                     //echo "<p class=card-text text-left'>" . $row['Dcount'] . "</p>";
                    //}
                    ?>
                    <a href="Device.php" class="btn btn-primary">Go To Device Page</a>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                </div>
                <div class="card-body" style="display: block;">
                    <table id="table_id1" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>AuditID</th>
                            <th>ActionDate</th>
                            <th>UserName</th>
                            <th>ActionType</th>
                            <th>DeviceID</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
