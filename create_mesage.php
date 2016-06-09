<?php

session_start();

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/connection.php';
require_once 'src/Message.php';

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php");
    
}
?>
<!DOCTYPE html>
<html>
     <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
     </head>
     <body>
        <div class='container'>
            <?php
                echo"<nav class='navbar navbar-inverse'>";
                echo"<div class='container-fluid'>";
                echo"<div class='navbar-header'>";
                echo"<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>";
                echo"<span class='icon-bar'></span>";
                echo"<span class='icon-bar'></span>";
                echo"<span class='icon-bar'></span>";                       
                echo"</button>";
                echo"</div>";
                echo"<div class='collapse navbar-collapse' id='myNavbar'>";
                echo"<ul class='nav navbar-nav'>";
                echo"<li><a href='User_page.php?id={$_SESSION['loggedUserId']}'>My page</a></li>";
                echo"<li><a href='All_users.php'>All users</a></li>";
                echo"<li><a href='index.php'>Home</a></li>";
                echo"<li class='active'><a href='all_messages.php'>Message Box</a></li>";
                echo"</ul>";
                echo"<ul class='nav navbar-nav navbar-right'>";
                echo"<li><a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
                echo"</ul>";
                echo"</div>";
                echo"</div>";
                echo"</nav>";
            if(isset($_GET['id'])) {
                $receiverId = $_GET['id'];
            }
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                if(!empty($_POST['text']) && !empty($_POST['title'])){
                    $title = $_POST['title'];
                    $text = $_POST['text']; 
                    $newMessage = new Message();
                    $newMessage->setSenderId($_SESSION['loggedUserId']);
                    $newMessage->setReciverId($receiverId);
                    $newMessage->setTitle($title);
                    $newMessage->setText($text);
                    $newMessage->saveMessageToDBP($conn);
                }
                else{
                    echo"<div class='alert alert-warning'>";
                    echo"Cannot Add empty message";
                    echo"</div>";
                }
            }
            ?>
            <form method="POST">
                <label>Title:
                    <input type="text" maxlength="50" name="title"/>
                </label>
                <br>
                <label> Content:
                    <br>
                    <textarea rows="3" cols="40" maxlength="140" name="text"></textarea>
                </label>
                <br>
                <input type='submit' class="btn btn-primary" value='Send'></input>
            </form>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </BODY>
</HTML>
<?php
$conn->close();
$conn = null;
?>


