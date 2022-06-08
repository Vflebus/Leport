<?php

$db_host = "mysql-vflebus.alwaysdata.net";
$db_name = "vflebus_leport";
$db_user = "vflebus";
$db_pass = "coontry1";

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit;
}