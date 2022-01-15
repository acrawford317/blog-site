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

// add comment to db
if(isset($_POST["add_comment"])){
    $content = $_POST["content"];
    $id = $_POST["post_id"];

    $insert = $mysqli->prepare("insert into comment (author, content, post_id) values (?, ?, ?);");
    $insert->bind_param("ssi", $user["username"], $content, $id);
    $insert->execute();
}

// get comments from db
if(isset($_POST["comment_load_data"])){
    $id = $_POST["post_id"];
    $result = $mysqli->query("select * from comment where post_id = '$id' order by created DESC;");

    $comments_array = [];

    while ($row = $result->fetch_assoc()){
        // format the date the post was created 
        $date = date_create($row['created']); 
        $formattedDate = date_format($date, "F jS, Y"); 

        array_push($comments_array, ["comment"=>$row["content"], "author"=>$row["author"], "date"=>$formattedDate]);
    }

    header('Content-type: application/json');
    echo json_encode($comments_array);

}

?>