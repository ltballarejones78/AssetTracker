$( document ).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    $('#UserDeviceAudittable').DataTable(
        {
            ajax: {
                "url": "SelectDeviceAudit.php",
                "dataSrc": "",
                "data": function(d){
                    d.mykey = urlParams.get('Device');
                }
            },
            columns: [

                {"data": "DeviceID"},
                {"data": "Actiondate"},
                {"data": "Username"},
                {"data": "ActionType"},
                {"data": "ActionPerformed"}
            ],
            order: [[1, 'desc']]

        });

    $('#btnEditDevice').on('click', function() {
        $("#btnEditDevice").attr("disabled", "disabled");
        var DeviceType  = $('#DTselectid').val();
        var ATag  = $('#txtEAssetTag').val();
        var Manu  = $('#txtEManufacturer').val();
        var Rdate  = $('#txtEReturnDate').val();
        var AssocSelect = $('#Aselectid').val();
        var Teamselectid  = $('#Teamselectid').val();
        var DID = urlParams.get('Device');
        if(DeviceType != "" && ATag != "" && Manu != ""  && Teamselectid != "" ){
            $.ajax({
                url: "SQLQueries.php?q=UpdateDevice",
                type: "POST",
                data: {
                    DID:DID,
                    DeviceType: DeviceType,
                    ATag: ATag,
                    Manu: Manu,
                    Rdate:Rdate,
                    AssocSelect:AssocSelect,
                    Teamselectid: Teamselectid,
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnEditDevice").removeAttr("disabled");
                        $("#successUDevice").show();
                        $('#successUDevice').html(ATag + ' Updated successfully !');
                        $('#UserIDevicetable').DataTable().ajax.reload();
                    }
                    else if(dataResult.statusCode==202){
                        alert("Error occured !");
                        $("#btnEditDevice").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnEditDevice").removeAttr("disabled");
        }
    });
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