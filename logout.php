<?php

/** DATABASE SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli("localhost", "root", "", "blog");

$error_msg = "";

// logout component
session_start();
session_destroy();

header("Location: index.php");
exit();

?>