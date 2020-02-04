<?php
require_once("Header.php");
?>
<script src="js/TypeTables.js"></script>
<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#title" data-toggle="tab">Titles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#Device" data-toggle="tab">Devices</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#Team" data-toggle="tab">Disabled</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="title">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <br/>
                        <table id="titletable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <br/>
                        <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        </div>

                        <div class="form-group">
                            <label style="color:red" id="txttitleError"></label>
                            <label for="txttitleInput">Title</label>
                            <input type="text" class="form-control" id="txttitleInput" placeholder="Enter a New Title">
                        </div>
                        <button type="submit" class="btn-primary" id="btnsavetitle"
                        " >Submit</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show" id="device">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <br/>
                        <table id="devicetable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Device Type</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <br/>
                        <div class="alert alert-success alert-dismissible" id="successDevice" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        </div>

                        <div class="form-group">
                            <label style="color:red" id="txtDeviceError"></label>
                            <label for="txtDeviceInput">Device</label>
                            <input type="text" class="form-control" id="txtdeviceInput"
                                   placeholder="Enter a New Device Type">
                        </div>
                        <button type="submit" class="btn-primary" id="btnsavedevice"
                        " >Submit</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>