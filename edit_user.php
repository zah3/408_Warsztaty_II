<?php

session_start();

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/connection.php';

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php");
    
}
$userId = $_SESSION['loggedUserId'];
if($_SERVER['REQUEST_METHOD'] === "POST"){
   
    $user = new User();
    $user->loadFromDB($conn,$userId );
    switch($_POST['submit']){
        case 'newEmailSubmit':
            $emailNew = strlen(trim($_POST['newEmail'])) > 0 ? trim($_POST['newEmail']) : null;
            if($emailNew){
                if(filter_var("$emailNew", FILTER_VALIDATE_EMAIL) == $emailNew){
                    if(!empty($_POST['newEmail'])){
                        $user->setEmail($emailNew);
                        $user->saveToDB($conn);
                        echo"<div class='alert alert-info'>";
                        echo"Email has changed";
                        echo"</div>";
                    }
                    else{
                        echo"<div class='alert alert-warning'>";
                        echo"cannot Change on empty Email";
                        echo"</div>";
                        }
                }
                 else{
                        echo"<div class='alert alert-warning'>";
                        echo"Sorry, this is not an e-mail addres.";
                        echo"</div>";
                        }
                    
            }
    
            break;
         case 'fullNameSubmit':
            $fullNameNew = strlen(trim($_POST['newFullName'])) > 0 ? trim($_POST['newFullName']) : null;
            if($fullNameNew){
                if(!empty($_POST['newFullName'])){
                    $user->setFullName($fullNameNew);
                    $user->saveToDB($conn);
                    echo"<div class='alert alert-info'>";
                    echo"Full name has changed";
                    echo"</div>";
                }
            }
            else{
                    echo"<div class='alert alert-warning'>";
                    echo"Cannot change on empty full name";
                    echo"</div>";
            }
            break;
         case 'passwordSubmit':
            $password = strlen(trim($_POST['newPassword'])) > 0 ? trim($_POST['newPassword']) : null;
            $retypePassword = strlen(trim($_POST['retypePassword'])) > 0 ? trim($_POST['retypePassword']) : null;
            if($password && $retypePassword && $password === $retypePassword){
                if(!empty($_POST['newPassword']) && isset($_POST['newPassword']) && !empty($_POST['retypePassword']) && isset($_POST['retypePassword'])){
                    $user->setPassword($password, $retypePassword);
                    $user->saveToDB($conn);
                    echo"<div class='alert alert-info'>";
                    echo"Password has changed.";
                    echo"</div>";
                }
                else{
                    echo"<div class='alert alert-warning'>";
                    echo"Cannot change on empty password.";
                    echo"</div>";
                }
            }
            else{
                echo"<div class='alert alert-warning'>";
                echo"Wrong values in 'password' and 'retype password'.";
                echo"</div>";
            }
            break;  
    }
}
    echo"<div class='container'>";
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
    echo"</div>";    
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
        <div class="container-fluid">
            <FORM method="POST">
                <fieldset>
                    <label>
                        New Email:
                        <input type="text" name ="newEmail" />
                        <br />
                        <button type="submit" class="btn btn-primary" name="submit" value="newEmailSubmit">Change</button>
                     </label>
                     <br />
                     <LABEL>
                        New Password:
                        <input type="password" name="newPassword" />
                     <br/>
                        Retype Password:
                        <input type="password" name="retypePassword" />
                        <br />
                        <button type="submit" class="btn btn-primary" name="submit" value="passwordSubmit">Change</button>
                    </LABEL>
                    <br />
                    <LABEL>
                          New full name:
                         <input type="text" name="newFullName" />
                         <br/>
                         <button type="submit" class="btn btn-primary" name="submit" value="fullNameSubmit">Change</button>    
                     </LABEL>
                     <br />
                </FIELDSET>
            </FORM>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>