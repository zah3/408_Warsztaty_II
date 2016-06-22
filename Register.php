<?php

require_once 'src/User.php';
require_once 'src/connection.php';
session_start();

if(isset($_SESSION['loggedUserId'])){
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] === "POST" ){
    $email = strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']) : null;
    $password = strlen(trim($_POST['password'])) > 0 ? trim($_POST['password']) : null;
    $retypePassword = strlen(trim($_POST['retypePassword'])) > 0 ? trim($_POST['retypePassword']) : null;
    $fullName = strlen(trim($_POST['fullName'])) > 0 ? trim($_POST['fullName']) : null;
    
    $user = User::getUserByEmail($conn, $email);
    
    
    if($email && $password 
            && $retypePassword && $fullName 
            && $password == $retypePassword
            && !$user){
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPassword($password, $retypePassword);
        $newUser->setFullName($fullName);
        $newUser->activate();
        if($newUser->saveToDB($conn)) {
            echo"<div class='alert alert-info'>";
            echo 'Registration successfull<br />';
            echo"</div>";
        }else {
            echo"<div class='alert alert-warning'>";
            echo "Error during the registraion <br />";
            echo"</div>";
        }
        
    }else 
        if(!$email || filter_var("$email", FILTER_VALIDATE_EMAIL == false)){
            echo"<div class='alert alert-warning'>";
            echo "Incorrect email <br />";
            echo"</div>";
        }
        if(!$password){
            echo"<div class='alert alert-warning'>";
            echo "Incorrect password <br />";
            echo"</div>";
        }
        if(!$retypePassword || $password != $retypePassword){
            echo"<div class='alert alert-warning'>";
            echo "Incorrect password<br />";
            echo"</div>";
        }
        if(!$fullName){
            echo"<div class='alert alert-warning'>";
            echo"Inccorect Full Name";
            echo"</div>";
        }
        if($user){
            echo"<div class='alert alert-warning'>";
            echo "User email exists <br />";
            echo"</div>";
        }
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
    <BODY>
        <FORM method="POST">
            <fieldset>
                <label>
                    Email:
                    <input type="text" name ="email" />
                 </label>
                 <br />
                 <LABEL>
                     Password:
                     <input type="password" name="password" />
                 </LABEL>
                 <br/>
                 <LABEL>
                     Retype Password:
                     <input type="password" name="retypePassword" />
                 </LABEL>
                 <br />
                 <LABEL>
                     Full name:
                     <input type="text" name="fullName" />
                 </LABEL>
                 <br />
                 <input type="submit" class="btn btn-primary" value="Register" />
            </FIELDSET>
        </FORM>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </BODY>
</HTML>
<?php
$conn->close();
$conn = null;
?>