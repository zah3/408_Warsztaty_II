<?php

session_start();

require_once 'src/User.php';
require_once 'src/connection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = strlen(trim($_POST['email'])) ? trim($_POST['email']) : null;
   $password = strlen(trim($_POST['password'])) ? trim($_POST['password']) : null;
   
   if ($email && $password){
       var_dump(password_hash($password, PASSWORD_BCRYPT));
       if($loggedUserId = User::login($conn, $email, $password)){
           $_SESSION['loggedUserId'] = $loggedUserId;
           header("Location:index.php");
       }else{
           echo"<div class='alert alert-info'>";
           echo"Incorrect email or password <br />";
           echo"</div>";
       }
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
    <body>
        <form method="POST">
            <fieldset>
                <label>
                    Email:
                    <input type="text" name="email" />
                </label>
                <br />
                <label>
                    Password:
                    <input type="password" name="password" />
                </label>
                <br />
                <input type ="submit" class="btn btn-primary" value="Login" />
            </fieldset>
        </form>
        <a href="Register.php"> Registration</a>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     </body>
</html>