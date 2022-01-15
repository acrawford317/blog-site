<?php

/** DATABASE SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli("localhost", "root", "", "blog");

$error_msg = "";

// logout component
session_start();
session_destroy();

if(isset($_GET['location'])) {
    $redirect = htmlspecialchars($_GET['location']);
    $redirect = str_replace("/blog-site/", "", $redirect);

    header("Location:" . $redirect);
    exit();}

header("Location: index.php");
exit();

?>