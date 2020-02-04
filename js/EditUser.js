$( document ).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    $('#UserIDevicetable').DataTable(
        {
            ajax: {
                "url": "SelectUserDevice.php",
                "dataSrc": "",
                "data": function(d){
                    d.mykey = urlParams.get('User');
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
                {"data": "TeamName"},
                {"data": "TeamID"}


            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                "targets": [ 5,7,8 ],
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

    $('#btnEditUser').on('click', function() {
        $("#btnEditUser").attr("disabled", "disabled");
        var Team  = $('#Eselectid').val();
        var AssocID  = $('#txtEAssociateID').val();
        var AssocFname  = $('#txtEAssociateFName').val();
        var AssocLname  = $('#txtEAssociateLName').val();
        var AssocEmail  = $('#txtEAssociateEmail').val();
        var title  = $('#TitleEselectid').val();
        var manager  = $('#MEselectid').val();
        if(title != "" && AssocID != "" && AssocFname != "" && AssocLname != "" && AssocEmail != "" && Team != "" && manager!=""){
            $.ajax({
                url: "SQLQueries.php?q=UpdateUser",
                type: "POST",
                data: {
                    TID: Team,
                    AID: AssocID,
                    AFname:AssocFname,
                    ALname:AssocLname,
                    AEmail: AssocEmail,
                    Atitle: title,
                    Amanager:manager
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnInsertUser").removeAttr("disabled");
                        $("#successIuser").show();
                        $('#successIuser').html(AssocID + ' Updated successfully !');
                        $('#Eselectid').val('');
                        $('#txtEAssociateID').val('');
                        $('#txtEAssociateFName').val('');
                        $('#txtEAssociateLName').val('');
                        $('#txtEAssociateEmail').val('');
                        $('#TitleEselectid').val('');
                        $('#MEselectid').val('');
                        $('#UserIDevicetable').DataTable().ajax.reload();
                    }
                    else if(dataResult.statusCode==202){
                        alert("Error occured !");
                        $("#btnEditUser").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnEditUser").removeAttr("disabled");
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
                        $('#UserIDevicetable').DataTable().ajax.reload();
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

    var Dtable = $('#UserIDevicetable').DataTable();
    Dtable.on( 'select', function ( e, dt, type, indexes ) {
        var rowData = Dtable.rows( indexes ).data().toArray();
        var Checkedout = true ;
        if(Checkedout == null)
        {
            //document.getElementById('ChckOutDbtn').style.display = "block";
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
        $("#editDbtn").attr("href", "EditDevice.php?Device="+ rowData[0].DeviceID);
    } );
    Dtable.on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = Dtable.rows( indexes ).data().toArray();
        document.getElementById('editDbtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        //document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDbtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#btnCheckInDevice").attr("value", "");
    } );

    $('#ChckInDbtn').click(function (e, dt, type, indexes ) {
        document.getElementById('editDbtn').style.display = "none";
        document.getElementById('ChckInDbtn').style.display = "none";
        //document.getElementById('ChckOutDbtn').style.display = "none";
        $("#editDbtn").attr("href", "");
        $("#ChckOutDbtn").attr("value","");
        $("#ChckInDbtn").attr("value", "");
        $('#DeviceTable').DataTable().ajax.reload();
        $("#ModalCheckIn").modal();
    })


});
