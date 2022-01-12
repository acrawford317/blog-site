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

if (isset($_POST["username"])) { // validate the username coming in
    $stmt = $mysqli->prepare("select * from user where username = ?;");
    $stmt->bind_param("s", $_POST["username"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
            
        if (!empty($data)) { 
            // user was found!
                
            // validate the user's password
            if (password_verify($_POST["password"], $data[0]["password"])) {
                // Save user information into the session to use later
                $_SESSION["username"] = $data[0]["username"];

                header("Location: index.php");
                exit();
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

            header("Location: index.php");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ashley Crawford">
        <meta name="description" content="page for login/signup">  
        <title>Blog Login/Signup</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>Blog Name</h1>
                <p> To get started, login below or enter a new username and password to create an account</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <p class="alert-danger" id="error_message"></p>
                <form action="login.php" method="post">
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