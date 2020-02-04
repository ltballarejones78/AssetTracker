<?php
    Define('DB_USER','ltballarejones78');
    Define('DB_PASSWORD','Grizzly3237');
    Define('DB_HOST','localhost');
    Define('DB_NAME','querotation');
    $dbc = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
    or dies('Could not connect to MYSQL: '.mysql_connect_error());



