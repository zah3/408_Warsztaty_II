<?php

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/connection.php';
session_start();
if(!isset($_SESSION['loggedUserId'])) {
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
                echo"<li class='active'><a href='User_page.php?id={$_SESSION['loggedUserId']}'>My page</a></li>";
                echo"<li><a href='All_users.php'>All users</a></li>";
                echo"<li><a href='index.php'>Home</a></li>";
                echo"<li><a href='all_messages.php'>Message Box</a></li>";
                echo"</ul>";
                echo"<ul class='nav navbar-nav navbar-right'>";
                echo"<li><a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
                echo"</ul>";
                echo"</div>";
                echo"</div>";
                echo"</nav>";
                if($_SERVER['REQUEST_METHOD'] === 'GET'){
                    $userId = isset($_GET['id']) ? $_GET['id'] : null;{
                        
                        $user = new User();
                        $user->loadFromDB($conn, $userId);
                        echo"<h2>{$user->getFullName()}</h2>";
                        echo"<h3>{$user->getEmail()}</h3>";
                        if($userId === $_SESSION['loggedUserId']) {
                            echo"<a class='btn btn-info' href='edit_user.php?id={$_SESSION['loggedUserId']}'>Edit info</a>";
                            echo"    ";
                            echo"<a class='btn btn-info' href='delete_user.php?id={$_SESSION['loggedUserId']}'>Delete account</a>";
                        }
                        else {
                            echo"<a class='btn btn-info' href='create_mesage.php?id={$user->getId()}'>Send message</a>";
                        }

                        $allTweets = Tweet::loadAllTweets($conn, $userId);

                        echo"<div class='row'>";
                        echo"<h1> All tweets of user: {$user->getFullName()}</h1>";

                        echo "<table class='table hover'>";
                        echo "<th>Contents</th><th>Link</th>";
                        if(!empty($allTweets)){
                            foreach($allTweets as $tweet ){
                                $tweetId = $tweet->getId();
                                $tweetText = $tweet->getText();

                                echo"<tr><td>$tweetText</td><td><a href='Tweet_page.php?id=$tweetId'>Show</a></td></tr>";
                            }
                        }
                        echo"</table>";
                        echo"<br />";
                        echo"</div>";
                }
            }?>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </BODY>
</HTML>
