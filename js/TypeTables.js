$( document ).ready(function() {
    $('#devicetable').DataTable(
        {
            "ajax": {
                "url": "TypeTableDeviceSQL.php",
                "dataSrc": ""
            },
            "columns": [
                {"data": "TypeID"},
                {"data": "DeviceType"}
            ]
        }
    );

    $('#titletable').DataTable(
        {
            "ajax": {
                "url": "TypeTableTitleSQL.php",
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Title"}
            ]
        }
    );

    $('#btnsavetitle').on('click', function() {
        $("#btnsavetitle").attr("disabled", "disabled");
        var title  = $('#txttitleInput').val();
        if(title != ""){
            $.ajax({
                url: "SQLQueries.php?q=InsertTypeTitle",
                type: "POST",
                data: {
                    title: title
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnsavetitle").removeAttr("disabled");
                        $("#success").show();
                        $('#success').html(title + ' added successfully !');
                        $('#txttitleInput').val('');
                        $('#titletable').DataTable().ajax.reload();
                    }
                    else if(dataResult.statusCode==202){
                        alert("Error occured !");
                        $("#btnsavetitle").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnsavetitle").removeAttr("disabled");
        }
    });

    $('#btnsavedevice').on('click', function() {
        $("#btnsavedevice").attr("disabled", "disabled");
        var device  = $('#txtdeviceInput').val();
        if(device != ""){
            $.ajax({
                url: "SQLQueries.php?q=InsertTypeDevice",
                type: "POST",
                data: {
                    device: device
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#btnsavedevice").removeAttr("disabled");
                        $("#successDevice").show();
                        $('#successDevice').html(device + ' added successfully !');
                        $('#txtdeviceInput').val('');
                        $('#devicetable').DataTable().ajax.reload();
                    }
                    else if(dataResult.statusCode==202){
                        alert("Error occured !");
                        $("#btnsavedevice").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill device the field !');
            $("#btnsavedevice").removeAttr("disabled");
        }
    });
});

