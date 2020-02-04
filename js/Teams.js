$( document ).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    $('#Teamstable').DataTable(
        {
            ajax: {
                "url": "SelectTeamUsers.php",
                "dataSrc": "",
                "data": function (d) {
                    d.mykey = urlParams.get('TeamID');
                }
            },
            columns: [
                {"data": null,"defaultContent": '',},
                {"data": "AssociateID"},
                {"data": "FirstName"},
                {"data": "LastName"},
                {"data": "Email"}
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                select: true,
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]

        });

    $('#UserTDevicetable').DataTable(
        {
            ajax: {
                "url": "SelectTeamDevices.php",
                "dataSrc": "",
                "data": function (d) {
                    d.mykey = urlParams.get('TeamID');
                }
            },
            columns: [
                {"data": null, "defaultContent": '',},
                {"data": "DeviceID"},
                {"data": "DeviceType"},
                {"data": "AssetTag"},
                {"data": "Manufacturer"},
                {"data": "CheckoutBy"},
                {"data": "ReturnDate"},
                {"data": "TeamID"}
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            },
                {
                    "targets": [ 1 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 7 ],
                    "visible": false,
                    "searchable": false
                }],

            select: {
                select: true,
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]

        });

    var table = $('#Teamstable').DataTable();
    table.on( 'select', function ( e, dt, type, indexes ) {
        var rowData = table.rows( indexes ).data().toArray();
        document.getElementById('editUserbtn').style.visibility ='visible';
        $("#editUserbtn").attr("href", "EditUser.php?User="+rowData[0].UserID);
    } )

    table.on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = table.rows( indexes ).data().toArray();
        document.getElementById('editUserbtn').style.visibility ='hidden';
        $("#editUserbtn").attr("href", "");
    } )

    var Dtable = $('#UserTDevicetable').DataTable();
    Dtable.on( 'select', function ( e, dt, type, indexes ) {
        var rowData = Dtable.rows( indexes ).data().toArray();
        var Checkedout = rowData[0].CheckoutBy;
        if(Checkedout == null)
        {
            document.getElementById('ChckOutDbtn').style.display = "block";
            $("#Teamselectid").val(rowData[0].TeamID)
            $("#DeviceOutID").val(rowData[0].DeviceID)
            $("#Teamselectid").trigger("change");
            $("#ModalCheckOut").find('.modal-title').text('Check out - ' +  rowData[0].AssetTag)
        }
        else
        {
            document.getElementById('ChckInDbtn').style.display = "block";
            $("#ModalCheckIn").find('.modal-title').text('Return - ' +  rowData[0].AssetTag)
            $("#ChckInDbtn").attr("value", rowData[0].DeviceID);
            $("#TeamInID").val(rowData[0].TeamID)
            $("#DeviceInID").val(rowData[0].DeviceID)
            if(rowData[0].TeamID != null)
            {
                $("#mBody").html("The Device - <b>"+ rowData[0].AssetTag + "</b> will be returned to the Team - <b>" + rowData[0].TeamName + "</b> For the User - <b>" + rowData[0].CheckoutBy + "</b>")
            }
            else{
                $("#mBody").html("The Device <b>"+ rowData[0].AssetTag + "</b> will be returned for the User - <b>" + rowData[0].CheckoutBy +"</b>")
            }

        }
        document.getElementById('editDevicebtn').style.display = "block";
        $("#editDevicebtn").attr("href", "EditDevice.php?Device="+ rowData[0].DeviceID);
    } );

    Dtable.on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = Dtable.rows( indexes ).data().toArray();
        document.getElementById('editDevicebtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDevicebtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
    } );

    $('#ChckInDbtn').click(function (e, dt, type, indexes ) {
        document.getElementById('editDevicebtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDevicebtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
        $('#UserTDevicetable').DataTable().ajax.reload();
        $("#ModalCheckIn").modal();
    })

    // Did this because the table needs to reset after we select a device to check out. The forced reload after the submit.
    //Removing the button to keep it cleaner looking.
    $('#ChckOutDbtn').click(function (e, dt, type, indexes ) {
        document.getElementById('editDevicebtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDevicebtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
        $('#UserTDevicetable').DataTable().ajax.reload();
        $("#ModalCheckOut").modal();
    })

    $('#Teamselectid').on('change', function() {
        //Grab team id from dropdown
        var Teamselectid  = $('#Teamselectid').val();

        //Get information from Ajax.
        $.ajax({
            url: "SelectTeamUsersJQ.php",
            type: "POST",
            data: {
                Teamselectid: Teamselectid,
            },
            cache: false,
            success: function(dataResult){
                // insert HTML into original drop down
                $("#Aselectid").html(dataResult);

            }
        });
    });

    $('#btnCheckoutDevice').on('click', function() {
        $("#btnCheckoutDevice").attr("disabled", "disabled");
        var Rdate =$('#txtEReturnDate').val();
        var Device  = $('#DeviceOutID').val();
        var AssocSelect  = $('#Aselectid').val();
        var Teamselectid  = $('#Teamselectid').val();
        if(Device != "" && Teamselectid != "" && AssocSelect != ""){
            $.ajax({
                url: "SQLQueries.php?q=UpdateDeviceOwner",
                type: "POST",
                data: {
                    DID: Device,
                    AssocSelect: AssocSelect,
                    Teamselectid: Teamselectid,
                    Rdate: Rdate
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnCheckoutDevice").removeAttr("disabled");
                        // $("#successIuser").show();
                        //$('#successIuser').html(AssetTag + ' added successfully !');
                        $('#ModalCheckOut').modal('toggle');
                        $('#UserTDevicetable').DataTable().ajax.reload();
                    }
                    else {
                        alert("Error occured !");
                        $("#btnCheckoutDevice").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnCheckoutDevice").removeAttr("disabled");
        }
    });
    $('#btnCheckInDevice').on('click', function() {
        $("#btnCheckInDevice").attr("disabled", "disabled");
        var Rdate = null;
        var Device  = $('#DeviceInID').val();
        var AssocSelect  = null;
        var Teamselectid  = $('#TeamInID').val();
        if(Device != ""){
            $.ajax({
                url: "SQLQueries.php?q=UpdateDeviceOwner",
                type: "POST",
                data: {
                    DID: Device,
                    AssocSelect: AssocSelect,
                    Teamselectid: Teamselectid,
                    Rdate: Rdate
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnCheckInDevice").removeAttr("disabled");
                        $('#ModalCheckIn').modal('toggle');
                        // $("#successIuser").show();
                        //$('#successIuser').html(AssetTag + ' added successfully !');
                        $('#UserTDevicetable').DataTable().ajax.reload();
                    }
                    else {
                        alert("Error occured !");
                        $("#btnCheckInDevice").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnCheckInDevice").removeAttr("disabled");
        }
    });
});