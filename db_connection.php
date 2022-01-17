<?php

/** DATABASE SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli("localhost", "root", "", "blog"); // XAMPP

$user = null;

// Join session or start one
session_start();

// set user info for the page if logged in 
if (isset($_SESSION["username"])) {
    $user = [
        "username" => $_SESSION["username"]
    ];
} else {
    $user = [
        "username" => null
    ];
}