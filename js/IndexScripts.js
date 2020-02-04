function ModalOpen()
{
    $("#ModalInsertUser").modal();
}
function ModalOpenDevice()
{
    $("#ModalInsertDevice").modal();
}

function ExecuteModalRequest()
{
    var teamID = document.getElementById('Tselectid').value;
    var associateID = document.getElementById('txtAssociateID').value;
    var associateFName = document.getElementById('txtAssociateFName').value;
    var associateLName= document.getElementById('txtAssociateLName').value;
    var associateEmail = document.getElementById('txtAssociateEmail').value;
    var associateTitle = document.getElementById('txtTitle').value;
    var associateManager = document.getElementById('Mselectid').value;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("txtModalUserSuccess").innerHTML = "We did it Logan, User Added";
                document.getElementById('Tselectid').value = "";
                 document.getElementById('txtAssociateID').value = "";
                 document.getElementById('txtAssociateFName').value = "";
                 document.getElementById('txtAssociateLName').value = "";
                 document.getElementById('txtAssociateEmail').value = "";
                 document.getElementById('txtTitle').value = "";
                document.getElementById('Mselectid').value = "";
            }
        };
        xmlhttp.open("GET", "SqlQueries.php?q=InsertUser&TID="+teamID+"&AID="+associateID+"&FName="+associateFName+"&LName="+associateLName+"&Email="+associateEmail+"&Title="+associateTitle+"&Manager="+associateManager, true);
        xmlhttp.send();

}
function RemoveDevicefromUser(UserID)
{
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            xmlhttp.open("GET", "ModalManageUserBody.php?q=" + UserID, true);
            xmlhttp.send();
        }
    };
    xmlhttp.open("GET", "SqlQueries.php?q=RemoveUserDevice&DID="+UserID, true);
    xmlhttp.send();
    location.reload(true);

}
function ExecuteModalDeviceRequest()
{
    var DeviceTypeID = document.getElementById('Dselectid').value;
    var AssetTag = document.getElementById('txtAssetTag').value;
    var Manufacturer = document.getElementById('txtManufacturer').value;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("txtModalDeviceSuccess").innerHTML = "We did it Logan, Device Added";
            document.getElementById("Dselectid").value = "";
            document.getElementById('txtAssetTag').value = "";
            document.getElementById('txtManufacturer').value = "";
        }
        else{

        }
    };
    xmlhttp.open("GET", "SqlQueries.php?q=InsertDevice&DTID="+DeviceTypeID+"&ATag="+AssetTag+"&Manu="+Manufacturer, true);
    xmlhttp.send();
}

function ManageUserDevices(UserID){
    if (UserID === "") {
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("ModalDeviceBody").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ModalManageUserBody.php?q=" + UserID, true);
        xmlhttp.send();
    }
    $("#ModalManageUser").modal();
}
function CheckoutUserDevices(DeviceID){
    if (DeviceID === "") {
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("ModalDeviceBody").innerHTML = this.responseText;

            }
        };
        xmlhttp.open("GET", "ModalCheckoutDeviceBody.php?q=" + DeviceID, true);
        xmlhttp.send();
    }
    $("#UserTitle").text("Assign Device");
    $("#ModalManageUser").modal();
}

function RentDevices(DeviceID){
    var AssociateID = document.getElementById('Uselectid').value;
    var RentalDateRange = document.getElementById('dSelectRange').value;
    if (DeviceID === "") {
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("ModalDeviceBody").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "SqlQueries.php?q=UpdateDeviceOwner&DID=" + DeviceID +"&AID="+AssociateID+"&RDR="+RentalDateRange, true);
        xmlhttp.send();
        location.reload(true);
    }
}