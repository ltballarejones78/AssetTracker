<?php
require_once("includes/globalphp.php");
if(isset($_COOKIE['ID_my_site']) and isset($_COOKIE['Key_my_site']))
//if there is, it logs you in and directes you to the members page
{

}
else
{
    $past = time() - 100;
//this makes the time in the past to destroy the cookie
    setcookie(ID_my_site, gone, $past);
    setcookie(Key_my_site, gone, $past);
    header("Location: login.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 400px;
            overflow-x: hidden;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>

    <script src="js/Bootstrap.js"></script>
    <script src="js/DashboardJS.js"></script>


</head>
<!-- Start of NavBar in Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="Dashboard.php"> <img src="includes/Images/Cerner color logo vertical.png" width="80"
                                                  height="50" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="Dashboard.php">Home <span class="sr-only"></span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Teams
                </a>
                <div class="dropdown-menu scrollable-menu" aria-labelledby="navbarDropdown">
                    <?php
                    $mysql_connection = db_open($DATABASE);
                    $query2 = "select TeamID,TeamName from tblteam";
                    $result = mysqli_query($mysql_connection, $query2);
                    while ($row = mysqli_fetch_array($result)) {
                        echo  "<a class='dropdown-item' href='Teams.php?TeamID=".$row["TeamID"]."'> ".$row['TeamName']."</a>";
                    }

                    ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Users
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="User.php">User Maintainence <span class="sr-only"></span></a>
                    <a class="dropdown-item"  href="User.php#Home">Insert User <span class="sr-only"></span></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    System Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="TypeTables.php">Type Tables <span class="sr-only"></span></a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Device.php">Device</a>
            </li>
        </ul>
    </div>
    <span class="navbar-text">
       <a class="nav-link" href="Logout.php">Logout</a>
    </span>
</nav>
<!-- Start of NavBar in Header -->
<body>
