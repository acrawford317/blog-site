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
        "username" => "anonymous"
    ];
}

// get the post with the correct id from db
if(isset($_GET["article"])){
    $id = $_GET["article"];
    $result = $mysqli->query("select * from post where id = '$id';");

    if ($result === false) {
        die("MySQL database failed");
    }

    $row = $result->fetch_assoc();

    // format the date the post was created 
    $date = date_create($row['created']); 
    $formatedDate = date_format($date, "F jS, Y"); 
} 

// adding comment to db
if (isset($_POST['submit'])){
    $comment = $_POST['new-comment'];
    $insert = $mysqli->prepare("insert into comment (author, content) values (?, ?);");
    $insert->bind_param("ss", $user["username"], $comment);
    $insert->execute();

    //header("Location: post.php");
}

?>

<!doctype html>

<html lang="en">
<head>
    <title>Blog Post</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Ashley Crawford">
    <meta name="description" content="blog page showing a post">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="styles/main.css">
</head>
    
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-xl">
            <a class="navbar-brand" href="index.php">Blog Name</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=food">Food</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=lifestyle">Lifestyle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=travel">Travel</a>
                    </li>
                </ul>
                <!-- show either login or logout button -->
                <?php if($user["username"]==null): ?>
                    <!-- html code to run if user not logged in -->
                    <ul class="nav navbar-nav ml-auto">
                        <li class="login"><a href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                    </ul>
                <?php else: ?>
                    <!-- html code to run if user is logged in -->
                    <ul class="nav navbar-nav ml-auto">
                        <p style="margin-right:10px;"><?php echo $user["username"] ?></p>
                        <li class="logout"><a href="logout.php"><i class="bi bi-box-arrow-left"></i></i> Logout</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-3" style="text-align:center;">
                <h1><i class="bi bi-person-circle"></i></h1>
                <p><?php echo $row['author']?></p>
                <p><?php echo $formatedDate?></p>
            </div>
            <div class="col-6">
                <h1 style="margin-bottom:25px"><?php echo $row['title']?></h1>
                <img class="img-fluid" src="images/<?php echo $row["image_file"]?>" alt="Image Name: <?php echo $row["image_file"]?>"  width="600" height="450" style="margin-bottom:20px;">

                <p><?php echo nl2br($row['content'])?></p>

            </div>
            <div class="col-3">
                <p>Popular Stories</p>
            </div>
        </div>
    </div>

<hr style="width:75%; margin:auto;">

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-12">
                <div class="comment-form">
                    <h1 style="font-size:20px;">Comments (0):</h1>
                    <form method="post" style="display: flex;">
                        <label for="new-comment" class="form-label"></label>
                        <input type="text" class="form-control" id="new-comment" name="new-comment" placeholder="What are your thoughts?" required style="margin-right:20px;"/>
                        <input type="submit" name="submit" value="Post" class="btn btn-primary" style="float: right;">
                    </form>
                </div>

                 <!-- loop through array of comments and display them -->
                <?php
                    $i=0;
                    $result_comments = $mysqli->query("select * from comment;");
                    while ($row_comment = $result_comments->fetch_assoc()){
                ?>
                <div class="comment-box"> 
                    <p> <?php echo $row_comment["author"] . " " . $row_comment["created"] ?> </p>
                    <p> <?php echo $row_comment["content"] ?> </p>
                    <hr style="margin-top:40px;">
                </div>
                <?php 
                        $i=$i+1;
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2022 Company, Inc</p>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="index.php?category=food" class="nav-link px-2 text-muted">Food</a></li>
                <li class="nav-item"><a href="index.php?category=lifestyle" class="nav-link px-2 text-muted">Lifestyle</a></li>
                <li class="nav-item"><a href="index.php?category=travel" class="nav-link px-2 text-muted">Travel</a></li>
            </ul>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>
    
</html>