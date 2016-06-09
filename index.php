<?php

session_start();

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/connection.php';

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
                echo"<li class='active'><a href='index.php'>Home</a></li>";
                echo"<li><a href='all_messages.php'>Message Box</a></li>";
                echo"</ul>";
                echo"<ul class='nav navbar-nav navbar-right'>";
                echo"<li><a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
                echo"</ul>";
                echo"</div>";
                echo"</div>";
                echo"</nav>";
                
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                if (!empty($_POST['tweetContent']) && trim($_POST['tweetContent']) != "" ){
                    $textTweet = $_POST['tweetContent'];
                    $userId = $_SESSION['loggedUserId'];
                    $newTweet = new Tweet();
                    $newTweet->setUserId($userId);
                    $newTweet->setText($textTweet);
                    $newTweet->saveTweetToDB($conn);
                    
                }
                else{
                    echo"<div class='alert alert-warning'>";
                    echo"Cannot add an empty tweet";
                    echo"</div>";
                }
            }
                echo"<div class='row'>";
                $loggedUser = new User();
                $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);

                echo"<br />";
                echo"<p>Logged user:</p>";
                echo $loggedUser->show()."<br />";
                echo"</div>";
                echo"<br>";
                echo"<br>";
                echo"<br>";
            ?>
            <form method="POST">
                <fieldset>
                    <label>
                        New Tweet:
                        <br>
                        <textarea rows="3" cols="40" maxlength="140" name="tweetContent">
                         </textarea>
                    <br />
                    <input type ="submit" class="btn btn-primary" value="Send" />
                </fieldset>
            </form>
            <?php 
                echo"<div class='row'>";
                echo"<h1> All tweets:</h1>";
                $allTweets = User::loadALLTweets($conn,$_SESSION['loggedUserId']);

                echo "<table class='table hover'>";
                echo "<th>Content</th><th>Link</th>";
                if(!empty($allTweets)){
                    for($i = 0;$i < count($allTweets);$i++){
                        echo"<tr><td>{$allTweets[$i][1]}</td><td><a href='Tweet_page.php?id={$allTweets[$i][0]}'>Show</a></td></tr>";
                    }
                }
                echo"</table>";
                
                echo"<br />";
                echo"</div>";
                ?>
         </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </BODY>
</HTML>