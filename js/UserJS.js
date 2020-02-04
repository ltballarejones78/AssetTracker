$( document ).ready(function() {
    $('#Usertable').DataTable(
        {
            ajax: {
                "url": "QuerySelectAssociates.php",
                "dataSrc": ""
            },
            columns: [
                {"data": null,"defaultContent": '',},
                {"data": "UserID"},
                {"data": "AssociateID"},
                {"data": "FirstName"},
                {"data": "LastName"},
                {"data": "Email"},
                {"data": "Title"},
                {"data": "Manager"},
                {"data": "TeamID"},
                {"data": "Manages"}
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                select:true,
                style: 'os',
                selector: 'td:first-child'
            },
            order: [[1, 'asc']]

        });

    $('#btnInsertUser').on('click', function() {
        $("#btnsavetitle").attr("disabled", "disabled");
        var Team  = $('#Tselectid').val();
        var AssocID  = $('#txtAssociateID').val();
        var AssocFname  = $('#txtAssociateFName').val();
        var AssocLname  = $('#txtAssociateLName').val();
        var AssocEmail  = $('#txtAssociateEmail').val();
        var title  = $('#Titleselectid').val();
        var manager  = $('#Mselectid').val();
        if(title != "" && AssocID != "" && AssocFname != "" && AssocLname != "" && AssocEmail != "" && Team != "" && manager!=""){
            $.ajax({
                url: "SQLQueries.php?q=InsertUser",
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
                        $('#successIuser').html(AssocID + ' added successfully !');
                        $('#Tselectid').val('');
                        $('#txtAssociateID').val('');
                        $('#txtAssociateFName').val('');
                         $('#txtAssociateLName').val('');
                         $('#txtAssociateEmail').val('');
                         $('#Titleselectid').val('');
                        $('#Mselectid').val('');
                        $('#Usertable').DataTable().ajax.reload();
                    }
                    else if(dataResult.statusCode==202){
                        alert("Error occured !");
                        $("#btnInsertUser").removeAttr("disabled");

                    }

                }
            });
        }
        else
        {
            alert('Please fill all the field !');
            $("#btnInsertUser").removeAttr("disabled");
        }
    });
    //this handles the user table select checkbox. We need to get information from the table.
    //Creates a on select function for the checkbox that binds to the Edit buttton.
    var table = $('#Usertable').DataTable();
    table.on( 'select', function ( e, dt, type, indexes ) {
        var rowData = table.rows( indexes ).data().toArray();
        document.getElementById('editbtn').style.visibility ='visible';
        $("#editbtn").attr("href", "EditUser.php?User="+rowData[0].UserID);
    } )

    table.on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = table.rows( indexes ).data().toArray();
        document.getElementById('editbtn').style.visibility ='hidden';
        $("#editbtn").attr("href", "");
    } )


    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }
});