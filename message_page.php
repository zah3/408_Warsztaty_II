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
                if($_SERVER['REQUEST_METHOD'] === "GET"){

                    if(isset($_GET['sender_id'])){
                        $sender = new User();
                        $sender->loadFromDB($conn, $_GET['sender_id']);
                                
//                        $sender = User::getUserById($conn, $_GET['sender_id']);
                        echo"<p>Receiver : {$sender->getFullName()}</p>";
                    }
                    if(isset($_GET['receiver_id'])){
                        $receiver = new User();
                        $receiver->loadFromDB($conn, $_GET['receiver_id']);
//                        $receiver = User::getUserById($conn, $_GET['receiver_id']);
                        echo"<h2>Author: {$receiver->getFullName()}</h2>";
                    }
                    if(isset($_GET['message_id'])){
                        $message1 = new Message ();
                        $message1->loadMessageFromDB($conn, $_GET['message_id']);
                        $message1Text = $message1->getText();
                        
                        echo"<h2>Title:<br> <strong>{$message1->getTitle()}</strong></h2>";
                        echo"<h3>Content:<br><strong> {$message1Text}</strong></h3>";

                    }
                    if($_GET['receiver_id'] !== $_SESSION['loggedUserId']) {
                        $sql = "UPDATE Message SET status=1 WHERE id={$_GET['message_id']} ";
                        $conn->query($sql);
                        
                    }
                }
             ?>
         </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </BODY>
</HTML>
<?php
$conn->close();
$conn = null;
?>