<?php

/** DATABASE SETUP **/
include('db_connection.php');

/** ADD COMMENT TO DB **/
if(isset($_POST["add_comment"])){
    $content = $_POST["content"];
    $id = $_POST["post_id"];

    $insert = $mysqli->prepare("insert into comment (author, content, post_id) values (?, ?, ?);");
    $insert->bind_param("ssi", $user["username"], $content, $id);
    $insert->execute();
}

/** GET COMMENTS FROM DB **/
if(isset($_POST["comment_load_data"])){
    $id = $_POST["post_id"];
    $result = $mysqli->query("select * from comment where post_id = '$id' order by created DESC;");

    $comments_array = [];

    while ($row = $result->fetch_assoc()){
        // format the date the post was created 
        $date = date_create($row['created']); 
        $formattedDate = date_format($date, "F jS, Y"); 

        // check if this comment has replies 
        $has_replies = false;
        $id = $row["id"];
        $replies = $mysqli->query("select * from reply where comment_id = '$id' limit 1;");
        if($replies->fetch_assoc()){
            $has_replies = true;
        }

        array_push($comments_array, ["id"=>$row["id"], "comment"=>$row["content"], "author"=>$row["author"], "date"=>$formattedDate, "has_replies"=>$has_replies]);
    }

    header('Content-type: application/json');
    echo json_encode($comments_array);
}

/** ADD REPLY (OR SUB-REPLY) TO DB **/
if(isset($_POST["add_reply"])){
    $content = $_POST["reply_content"];
    $id = $_POST["comment_id"];

    $insert = $mysqli->prepare("insert into reply (author, content, comment_id) values (?, ?, ?);");
    $insert->bind_param("ssi", $user["username"], $content, $id);
    $insert->execute();
}

/** GET REPLIES FROM DB **/
if(isset($_POST["replies_load_data"])){
    $id = $_POST["comment_id"];
    $result = $mysqli->query("select * from reply where comment_id = '$id' order by created ASC;");

    $replies_array = [];

    while ($row = $result->fetch_assoc()){
        // format the date the reply was created 
        $date = date_create($row['created']); 
        $formattedDate = date_format($date, "F jS, Y"); 

        array_push($replies_array, ["id"=>$row["id"], "reply"=>$row["content"], "author"=>$row["author"], "date"=>$formattedDate]);
    }

    header('Content-type: application/json');
    echo json_encode($replies_array);
}

?>