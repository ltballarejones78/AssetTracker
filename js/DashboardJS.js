$( document ).ready(function() {
    $('#table_id1').DataTable(
        {
            "ajax": {
               "url": "SelectAudit.php",
               "dataSrc": ""
            },
            "columns": [
                {"data": "AuditID"},
                {"data": "Actiondate"},
                {"data": "Username"},
                {"data": "ActionType"},
                {"data": "DeviceID", "defaultContent": '',},
                { "data": "ActionPerformed" }
            ],
            order: [[1, 'desc']]
        }
    );
});