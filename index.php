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

// get the posts with the correct category from db
if(isset($_GET["category"])){
    $category = $_GET["category"];
    $result = $mysqli->query("select * from post where category = '$category';");

    if ($result === false) {
        die("MySQL database failed");
    }
} else{
    $result = $mysqli->query("select * from post");

    if ($result === false) {
        die("MySQL database failed");
    }
}

?>


<!doctype html>

<html lang="en">
<head>
    <title>Blog</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Ashley Crawford">
    <meta name="description" content="blog home page">
    
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

    <div class="container">
        <div class="row">


            <div class="d-flex flex-wrap">
                <!-- loop through array of posts and display them -->
                <?php
                    $i=0;
                    while ($row = $result->fetch_assoc()){
                ?>
                <div class="flex-shrink-1 post-box"> 
                    <div class="post">
                        <a href="post.php?article=<?php echo $row["id"] ?>">
                            <img class="img-fluid" src="images/<?php echo $row["image_file"]?>" alt="<?php echo $row["image_file"]?>" style="margin-bottom:20px;">
                            <h1> <?php echo $row["title"] ?> </h1>
                            <p> <?php echo substr($row["content"], 0, 250) . "..." ?> </p>
                            <hr style="width:85%; margin: auto; margin-top:30px; margin-bottom: 15px;">
                        </a>
                    </div>
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