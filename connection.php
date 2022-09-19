<?php 

session_start();

$link = mysqli_connect("127.0.0.1", "root", "dont4get", "twitter", 3307);

if (mysqli_connect_error()) {
    die("Database connection error");
}

?>