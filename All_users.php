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
                echo"<li><a href='User_page.php?id={$_SESSION['loggedUserId']}'>My page</a></li>";
                echo"<li class='active'><a href='All_users.php'>All users</a></li>";
                echo"<li><a href='index.php'>Home</a></li>";
                echo"<li><a href='all_messages.php'>Message Box</a></li>";
                echo"</ul>";
                echo"<ul class='nav navbar-nav navbar-right'>";
                echo"<li><a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
                echo"</ul>";
                echo"</div>";
                echo"</div>";
                echo"</nav>";
                echo"<div class='container'>";
                echo"<h2>All Users:</h2>";
                $sql = "SELECT * FROM User WHERE active=1";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    
                    while($row = $result->fetch_assoc()){
                        echo"<a href='User_page.php?id={$row['id']}'><button type='button' class='btn btn-primary btn-block'>User: {$row['fullName']} <br> E-mail: {$row['email']}</button></a>";
                        echo"<br>";
                    }
                }
                echo"</div>";
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
