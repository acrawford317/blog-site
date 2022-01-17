<?php

/** DATABASE SETUP **/
include('db_connection.php');

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
    $formattedDate = date_format($date, "F jS, Y"); 
} 

?>

<!doctype html>

<html lang="en">
<head>
    <title>Venture Hut</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Ashley Crawford">
    <meta name="description" content="blog page showing a post">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
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
                <!-- show either login or logout button -->
                <?php if($user["username"]==null): ?>
                    <!-- html code to run if user not logged in -->
                    <ul class="nav navbar-nav ml-auto">
                        <?php ?>
                        <li class="login"><a id="login-logout" href="<?php echo "login.php?location=" . urlencode($_SERVER['REQUEST_URI']) ?>"><i class="bi bi-box-arrow-in-right"></i> Login / Signup</a></li>
                    </ul>
                <?php else: ?>
                    <!-- html code to run if user is logged in -->
                    <ul class="nav navbar-nav ml-auto">
                        <p style="margin-right:10px;"><?php echo $user["username"] ?></p>
                        <li class="logout"><a id="login-logout" href="<?php echo "logout.php?location=" . urlencode($_SERVER['REQUEST_URI']) ?>"><i class="bi bi-box-arrow-left"></i></i> Logout</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </nav>

    <!---- AUTHOR, POST CONTENT, POPULAR POSTS ---->
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <!-- author -->
            <div class="col-2 author-box" style="text-align:center;">
                <h1><i class="bi bi-person-circle"></i></h1>
                <p><?php echo $row['author']?></p>
                <p><?php echo $formattedDate?></p>
                <hr style='margin-top:40px; width:85%; margin:auto; margin-bottom: 17px;'>
                <div>
                    <button class="social-media-button"><i class="bi bi-facebook"></i></button>
                    <button class="social-media-button"><i class="bi bi-instagram"></i></button>
                    <button class="social-media-button"><i class="bi bi-twitter"></i></button>
                </div>
            </div>
            <!-- post title, image, content -->
            <div class="col-6 post-column">
                <h1 style="margin-bottom:25px"><?php echo $row['title']?></h1>
                <hr style="width:100%; margin: auto; margin-bottom: 30px;">
                <img class="img-fluid" src="images/<?php echo $row["image_file"]?>" alt="Image Name: <?php echo $row["image_file"]?>"  width="600" height="450" style="margin-bottom:20px;">
                <p><?php echo nl2br($row['content'])?></p>
            </div>
            <div class="col-3" style="margin-left:5%;">
                <p style="margin-top:35px;">Popular Stories</p>
                <hr style="width:100%; margin: auto; margin-top:15px; margin-bottom: 30px;">

                <!-- loop through array of popular posts and display them -->
                <?php
                    $i=0;
                    $result_popular = $mysqli->query("select * from post where popular = 1 and id != '$id';");
                    while ($row_popular = $result_popular->fetch_assoc()){
                ?>
                <div class="popular-post-box"> 
                    <div class="popular-post">
                        <a href="post.php?article=<?php echo $row_popular["id"] ?>">
                            <img class="img-fluid" src="images/<?php echo $row_popular["image_file"]?>" alt="<?php echo $row_popular["image_file"]?>" style="margin-bottom:20px;">
                            <h1> <?php echo $row_popular["title"] ?> </h1>
                            <p> <?php echo substr($row_popular["content"], 0, 150) . "..." ?> </p>
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

<hr style="width:70%; margin:auto; margin-bottom:20px; margin-top:30px;">

    <!---- COMMENT SECTION ---->
    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <div class="col-12 comment-column">
                <div class="comment-form">
                    <h1 style="font-size:20px; margin-bottom:25px;"><i class="bi bi-chat-right-text"></i> Comments:</h1>
                    <form style="display: flex;">
                        <!-- if not logged in, submit button disabled  -->
                        <?php if($user["username"]==null): ?>
                            <label for="comment-text-box" class="form-label"></label>
                            <input type="text" class="form-control" id="comment-text-box" name="comment-text-box" placeholder="Login to comment" required style="margin-right:20px;" disabled/>
                            <button type="button" name="add-comment-btn" id="add-comment-btn" class="btn btn-primary add-comment-btn" style="float: right;" disabled>Post</button>
                        <?php else: ?>
                            <label for="comment-text-box" class="form-label"></label>
                            <input type="text" class="form-control comment-text-box" id="comment-text-box" name="comment-text-box" placeholder="What are your thoughts?" required style="margin-right:20px;"/> 
                            <button type="button" name="add-comment-btn" id="add-comment-btn" class="btn btn-primary add-comment-btn" style="float: right;" onclick="addComment()">Post</button>
                        <?php endif ?>
                    </form>
                    <div id="error" class="error-msg"></div>
                </div>

                 <!-- comments displayed here -->
                <div class="comment-container" style="margin-top:40px;"></div>
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

    <!---- JAVASCRIPT --->
    <script type="text/javascript">

        /** FUNCTION TO ADD COMMENT TO DB **/ 
        function addComment() {

            // get article id from url
            var content = document.getElementById("comment-text-box").value;
            var queryString = window.location.search;
            var id_url = new URLSearchParams(queryString);
            const pattern = /article=/g;
            var id = id_url.toString().replace(pattern, "");

            // check that comment content is not empty
            if(content.length == 0){
                error_msg = "Enter comment to submit.";
                $('#error').text(error_msg);
            } else{ 
                error_msg = "";
                $('#error').text(error_msg);
            }

            // if content filled out, ajax -> add to db 
            if(error_msg != ""){
                return false;
            } else{
                var data = {
                    'content': content,
                    'add_comment': true,
                    'post_id': id
                };
                $.ajax({
                    type: "POST",
                    url: "comments.php",
                    data: data,
                    success: function(response){
                        document.getElementById("comment-text-box").value = "";
                    }
                });

                // display all comments 
                getComments();
            }
        }

        /** FUNCTION TO GET COMMENTS FROM DB **/ 
        function getComments(){

            // get article id from url 
            var queryString = window.location.search;
            var id_url = new URLSearchParams(queryString);
            const pattern = /article=/g;
            var id = id_url.toString().replace(pattern, "");

            $.ajax({
                    type: "POST",
                    url: "comments.php",
                    data: {
                        "comment_load_data": true,
                        'post_id': id
                    },
                    success: function(response){
                        $(".comment-container").html("");

                        // loop through comments and add to html to display 
                        for(var i=0; i<response.length; i++){
                            html = "";

                            html += "<div class='comment-box' style='margin-left:10px;'>" +
                            "<div style='display: flex;'>" +
                                "<p><i class='bi bi-person-circle'></i> " + response[i].author + "</p>" +
                                "<span style='color:gray; margin-left:10px; font-size:14px;'> &#8226;</span>" + 
                                "<p style='color:gray; margin-left:10px; font-size:14px;'>" + response[i].date + "</p>" +
                            "</div>" +
                            "<p style='margin-left:20px;'>" + response[i].comment + "</p>" +
                            "<div class='comment-buttons' style='display: flex;'>" +
                            "<button type='button' <?php echo ($user['username']==null) ? "hidden" : "" ?> value='" + response[i].id + "'class='btn btn-outline-secondary reply-btn' style='margin-left:20px;' > Reply </button>";

                            // if comment has no replies, make view view replies button hidden
                            if(response[i].has_replies==true){
                                html += "<button type='button' id='view-reply-btn-id-" + response[i].id + "' value='" + response[i].id + "'class='btn btn-outline-secondary btn-sm view-reply-btn' style='margin-left:20px;'> View Replies <i class='bi bi-arrow-down'></i></button>";
                            } else{
                                html += "<button type='button' hidden id='view-reply-btn-id-" + response[i].id + "' value='" + response[i].id + "'class='btn btn-outline-secondary btn-sm view-reply-btn' style='margin-left:20px;'></button>";
                            }

                            html += "</div>" + "<div class='reply-box' id='reply-box'>" + "</div>" + "<hr style='margin-top:40px;'> " + "</div>";

                            $(".comment-container").append(html);
                        }
                    }
                });
        }

        // display comments 
        getComments();

        /** EVENT LISTENER FOR ENTER BUTTON **/ 
        document.getElementById('comment-text-box').onkeypress=function(e){
            if(e.keyCode==13){
                event.preventDefault();
                document.getElementById('add-comment-btn').click();
                getComments();
            }
        }

        $(document).ready(function() {

            /** CLICK REPLY BUTTON **/ 
            $(document).on('click', '.reply-btn', function() { 
                var thisClicked = $(this);
                var comment_id = thisClicked;
                $('.reply-box').html("");

                thisClicked.closest('.comment-box').find('.reply-box').html('\
                    <input type="text" id="reply-text-box" class="reply-msg form-control my-2" placeholder="Reply">\
                        <div class="text-end">\
                        <button class="btn btn-sm btn-primary reply-add-btn">Reply</button>\
                        <button class="btn btn-sm btn-danger reply-cancel-btn">Cancel</button>\
                    </div>');
            });

            /** CLICK CANCEL REPLY BUTTON **/ 
            $(document).on('click', '.reply-cancel-btn', function() { 
                $('.reply-box').html("");
            });

            /** CLICK ADD REPLY BUTTON **/ 
            $(document).on('click', '.reply-add-btn', function(e) { 
                e.preventDefault();

                var thisClicked = $(this);
                var comment_id = thisClicked.closest('.comment-box').find('.reply-btn').val();
                var reply = thisClicked.closest('.comment-box').find('.reply-msg').val();
                var view_reply_btn_id = 'view-reply-btn-id-' + comment_id;

                if(reply==""){
                    return false;
                }
            
                var data = {
                    'comment_id': comment_id,
                    'reply_content': reply,
                    'add_reply': true
                };
                $.ajax({
                    type: "POST",
                    url: "comments.php",
                    data: data,
                    success: function(response){
                        // click view replies button that was hidden to show replies 
                        document.getElementById("reply-text-box").value = "";
                        document.getElementById(view_reply_btn_id).innerHTML = ' View Replies <i class="bi bi-arrow-down"></i>';
                        document.getElementById(view_reply_btn_id).hidden = false;
                        document.getElementById(view_reply_btn_id).click();
                    }
                }); 
            });

            /** CLICK VIEW REPLY BUTTON **/  
            $(document).on('click', '.view-reply-btn', function(e) { 
                e.preventDefault();

                $('.reply-box').html("");
                
                var thisClicked = $(this);
                var comment_id = thisClicked.val();
                var view_reply_btn_id = 'view-reply-btn-id-' + comment_id;
                var button_val = document.getElementById(view_reply_btn_id);

                if(button_val.innerHTML==' Hide Replies <i class="bi bi-arrow-up"></i>'){
                    $('.reply-box').html("");
                    button_val.innerHTML=' View Replies <i class="bi bi-arrow-down"></i>';
                } else{
                    // ajax -> get replies from db
                    var data = {
                        'comment_id': comment_id,
                        'replies_load_data': true
                    };
                    $.ajax({
                        type: "POST",
                        url: "comments.php",
                        data: data,
                        success: function(response){
                            // loop through comments and add to html to display 
                            for(var i=0; i<response.length; i++){
                                thisClicked.closest('.comment-box').find('.reply-box').append("<div class='sub-reply-box' style='margin-left:80px; margin-top:30px;'>" +
                                "<div style='display: flex;'>" +
                                    "<input type='hidden' class='get-reply-username' value='" + response[i].author + "'></input>" + 
                                    "<p><i class='bi bi-person-circle'></i> " + response[i].author + "</p>" +
                                    "<span style='color:gray; margin-left:10px; font-size:14px;'> &#8226;</span>" + 
                                    "<p style='color:gray; margin-left:10px; font-size:14px;'>" + response[i].date + "</p>" +
                                "</div>" +
                                "<p style='margin-left:20px;'>" + response[i].reply + "</p>" +
                                "<div style='display: flex;' class='sub-reply-btns'>" +
                                "<button type='button' <?php echo ($user['username']==null) ? "hidden" : "" ?> value='" + response[i].id + "'class='btn btn-outline-secondary sub-reply-btn' style='margin-left:20px;'> Reply </button>" +
                                "</div>" +
                                "<div class='sub-reply-section' id='sub-reply-section'>" + "</div>" +
                                "<hr style='margin-top:40px;'> " +
                            "</div>");
                            }

                            // toggle button to hide/view replies 
                            if(button_val.innerHTML==' View Replies <i class="bi bi-arrow-down"></i>'){
                                button_val.innerHTML=' Hide Replies <i class="bi bi-arrow-up"></i>';
                            }else if(button_val.innerHTML==' Hide Replies <i class="bi bi-arrow-up"></i>'){
                                button_val.innerHTML=' View Replies <i class="bi bi-arrow-down"></i>';
                            }
                        }
                    }); 
                }
            });

            /** CLICK SUB-REPLY BUTTON **/  
            $(document).on('click', '.sub-reply-btn', function(e) { 
                e.preventDefault();

                var thisClicked = $(this);
                var comment_id = thisClicked;
                var reply_username = thisClicked.closest('.sub-reply-box').find('.get-reply-username').val();

                $('.sub-reply-section').html("");

                thisClicked.closest('.sub-reply-box').find('.sub-reply-section').html('\
                <input type="text" id="sub-reply-text-box" class="sub-reply-msg form-control my-2" value="@' + reply_username + ' " placeholder="Reply">\
                    <div class="text-end">\
                    <button class="btn btn-sm btn-primary sub-reply-add-btn">Reply</button>\
                    <button class="btn btn-sm btn-danger sub-reply-cancel-btn">Cancel</button>\
                </div>');
            });

             /** CLICK CANCEL-SUB-REPLY BUTTON **/ 
            $(document).on('click', '.sub-reply-cancel-btn', function(e) { 
                e.preventDefault();

                $('.sub-reply-section').html("");
            });

            /** CLICK ADD-SUB-REPLY BUTTON **/  
            $(document).on('click', '.sub-reply-add-btn', function(e) { 
                e.preventDefault();

                var thisClicked = $(this);
                var comment_id = thisClicked.closest('.comment-box').find('.reply-btn').val();
                var reply = thisClicked.closest('.sub-reply-box').find('.sub-reply-msg').val();
                var view_reply_btn_id = 'view-reply-btn-id-' + comment_id;
            
                var data = {
                    'comment_id': comment_id,
                    'reply_content': reply,
                    'add_reply': true
                };
                $.ajax({
                    type: "POST",
                    url: "comments.php",
                    data: data,
                    success: function(response){
                        // click view replies button that was hidden to show replies 
                        document.getElementById("sub-reply-text-box").value = "";
                        document.getElementById(view_reply_btn_id).innerHTML = ' View Replies <i class="bi bi-arrow-down"></i>';
                        document.getElementById(view_reply_btn_id).hidden = false;
                        document.getElementById(view_reply_btn_id).click();
                    }
                }); 
            });
        });

    </script> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>
    
</html>