<?php

/** DATABASE SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli("localhost", "root", "", "blog");

$error_msg = "";

// logout component
session_start();
session_destroy();

// Join the session or start a new one
session_start();

// get previous location to redirect to 
$redirect = null;
if(isset($_GET['location'])) {
    $redirect = htmlspecialchars($_GET['location']);
    $redirect = str_replace("/blog-site/", "", $redirect);
}

/** VALIDATE USER **/
if (isset($_POST["username"])) { 
    $stmt = $mysqli->prepare("select * from user where username = ?;");
    $stmt->bind_param("s", $_POST["username"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
            
        if (!empty($data)) { 
            // user was found! validate the user's password
            if (password_verify($_POST["password"], $data[0]["password"])) {
                // Save user information into the session to use later
                $_SESSION["username"] = $data[0]["username"];

                if(isset($redirect)){
                    header("Location: " . $redirect);
                    exit();
                } else{
                    header("Location: index.php");
                    exit();
                }
            } else {
                // User was found, but entered an invalid password
                $error_msg = "Invalid Password";
            }
        } else {
            // user was not found, create an account
            // use a secure hash to store passwords into db
            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $insert = $mysqli->prepare("insert into user (username, password) values (?, ?);");
            $insert->bind_param("ss", $_POST["username"], $hash);
            if (!$insert->execute()) {
                $error_msg = "Error creating new user";
            } 
                
            // Save user information into the session to use later
            $_SESSION["username"] = $_POST["username"];

            if(isset($redirect)){
                header("Location: " . $redirect);
                exit();
            } else{
                header("Location: index.php");
                exit();
            }
        }
    }
}

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ashley Crawford">
    <meta name="description" content="page for login/signup">  
    <title>Venture Hut - Login/Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <!---- NAVBAR ---->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-xl">
            <a class="navbar-brand" href="index.php">Venture Hut</a>
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
            </div>
        </div>
    </nav>

    <!---- LOGIN CONTAINER ---->
    <div class="container" style="margin-top: 15px;">
        <div class="row d-flex justify-content-center">
            <div class="col-4 login-box">
                <h1>Venture Hut</h1>
                <p> To get started, login below or enter a new username and password to create an account.</p>
                <hr style='margin-top:20px;'>
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <p class="alert-danger" id="error_message"></p>
                <?php if(isset($redirect)): ?>
                <form action="login.php?location=<?php echo $redirect ?>" method="post">
                <?php else: ?>
                <form action="login.php" method="post">
                <?php endif ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required/>
                        <div id="password_message" class="form-text"></div>
                    </div>
                    <div class="text-center">                
                        <button type="submit" class="btn btn-primary" id="submit">Log in / Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!---- FOOTER ---->
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


    <script type="text/javascript">
        
    // check if entered password is long enough
    var passwordCheck = (num) => {
        var pw = document.getElementById("password");
        var password_message = document.getElementById("password_message");
        var submit = document.getElementById("submit");
            
        if (pw.value.length < num) {
            password_message.textContent = "Password must be " + num + " characters or longer";
            pw.classList.add("is-invalid");
            submit.disabled = true;
        } else {
            password_message.textContent = "";
            pw.classList.remove("is-invalid");
            submit.disabled = false;
        }
    }
        
    // event listener for password input
    document.getElementById("password").addEventListener("keyup", function() {
        passwordCheck(10); 
    });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>