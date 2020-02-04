$( document ).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    $('#DeviceTable').DataTable(
        {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                "url": "SelectDevice.php",
                "dataSrc": "",
                //"data": function (d) {
                   // d.mykey = urlParams.get('User');
               // }
            },
            columns: [
                {"data": null, "defaultContent": '',},
                {"data": "DeviceID"},
                {"data": "DeviceType"},
                {"data": "AssetTag"},
                {"data": "Manufacturer"},
                {"data": "CheckoutBy"},
                {"data": "ReturnDate"},
                {"data": "TeamName"},
                {"data": "TeamID"}
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
            "targets": [ 8 ],
            "visible": false,
            "searchable": false
        }],
            select: {
                select: true,
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[5, 'desc']]

        });
    $('#btnInsertDeviceUser').on('click', function() {
        $("#btnInsertDeviceUser").attr("disabled", "disabled");
        var Device  = $('#Dselectid').val();
        var AssetTag  = $('#txtDAssettag').val();
        var Manufacturer  = $('#txtDManufacturer').val();
        if(Device != "" && AssetTag != "" && Manufacturer != ""){
            $.ajax({
                url: "SQLQueries.php?q=InsertDevice",
                type: "POST",
                data: {
                    DID: Device,
                    ATag: AssetTag,
                    Manu: Manufacturer,
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnInsertDeviceUser").removeAttr("disabled");
                        $("#successIuser").show();
                        $('#successIuser').html(AssetTag + ' added successfully !');
                        $('#modal').modal('toggle');
                        $('#DeviceTable').DataTable().ajax.reload();
                    }
                    else {
                        alert("Error occured !");
                        $("#btnInsertDeviceUser").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnInsertDeviceUser").removeAttr("disabled");
        }
    });

    $('#btnCheckoutDevice').on('click', function() {
        $("#btnCheckoutDevice").attr("disabled", "disabled");
        var Rdate =$('#txtEReturnDate').val();
        var Device  = $('#DeviceOutID').val();
        var AssocSelect  = $('#Aselectid').val();
        var AssocSelecttxt  = $("#Aselectid option:selected").text();
        var Teamselectid  = $('#Teamselectid').val();
        var DeviceAssetTag  = $('#DeviceAssetTag').val();
        var Cout = 'Check Out';
        if(Device != "" && Teamselectid != ""){
            $.ajax({
                url: "SQLQueries.php?q=UpdateDeviceOwner",
                type: "POST",
                data: {
                    DID: Device,
                    AssocSelect: AssocSelect,
                    Teamselectid: Teamselectid,
                    Rdate: Rdate,
                    Cout: Cout,
                    AssocSelecttxt: AssocSelecttxt,
                    DeviceAssetTag: DeviceAssetTag

                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnCheckoutDevice").removeAttr("disabled");
                       // $("#successIuser").show();
                        //$('#successIuser').html(AssetTag + ' added successfully !');
                        $('#ModalCheckOut').modal('toggle');
                        $('#DeviceTable').DataTable().ajax.reload();
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
        var Teamselecttxt  = $('#TeamInTxt').val();
        var DeviceAssetTag = $('#DeviceAssetTag').val();
        var CIN = 'Check In'
        if(Device != ""){
            $.ajax({
                url: "SQLQueries.php?q=UpdateDeviceOwner",
                type: "POST",
                data: {
                    DID: Device,
                    AssocSelect: AssocSelect,
                    Teamselectid: Teamselectid,
                    Rdate: Rdate,
                    CIN: CIN,
                    Teamselecttxt:Teamselecttxt,
                    DeviceAssetTag:DeviceAssetTag
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnCheckInDevice").removeAttr("disabled");
                        $('#ModalCheckIn').modal('toggle');
                        // $("#successIuser").show();
                        //$('#successIuser').html(AssetTag + ' added successfully !');
                        $('#DeviceTable').DataTable().ajax.reload();
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

    //this handles the user table select checkbox. We need to get information from the table.
    //Creates a on select function for the checkbox that binds to the Edit buttton.
    var Dtable = $('#DeviceTable').DataTable();
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
            $("#DeviceAssetTag").val(rowData[0].AssetTag)
    }
        else
        {
            document.getElementById('ChckInDbtn').style.display = "block";
            $("#ModalCheckIn").find('.modal-title').text('Return - ' +  rowData[0].AssetTag)
            $("#ChckInDbtn").attr("value", rowData[0].DeviceID);
            $("#TeamInID").val(rowData[0].TeamID)
            $("#TeamInTxt").val(rowData[0].TeamName)
            $("#DeviceInID").val(rowData[0].DeviceID)
            $("#DeviceAssetTag").val(rowData[0].AssetTag)
            $("#AssociateIDtxt").val(rowData[0].CheckoutBy)
            if(rowData[0].TeamID != null)
            {
                $("#mBody").html("The Device - <b>"+ rowData[0].AssetTag + "</b> will be returned to the Team - <b>" + rowData[0].TeamName + "</b> For the User - <b>" + rowData[0].CheckoutBy + "</b>")
            }
            else{
                $("#mBody").html("The Device <b>"+ rowData[0].AssetTag + "</b> will be returned for the User - <b>" + rowData[0].CheckoutBy +"</b>")
            }

        }
        document.getElementById('editDbtn').style.display = "block";
        $("#editDbtn").attr("href", "EditDevice.php?Device="+rowData[0].DeviceID);
    } );

    Dtable.on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = Dtable.rows( indexes ).data().toArray();
        document.getElementById('editDbtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDbtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
    } );

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $('#ChckInDbtn').click(function (e, dt, type, indexes ) {
        document.getElementById('editDbtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDbtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
        $('#DeviceTable').DataTable().ajax.reload();
        $("#ModalCheckIn").modal();
    })

    // Did this because the table needs to reset after we select a device to check out. The forced reload after the submit.
    //Removing the button to keep it cleaner looking.
    $('#ChckOutDbtn').click(function (e, dt, type, indexes ) {
        document.getElementById('editDbtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDbtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
        $('#DeviceTable').DataTable().ajax.reload();
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
});