<?php
require_once 'src/Message.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'src/connection.php';
session_start();
if(!isset($_SESSION['loggedUserId'])) {
        header("Location: login.php");    
}?>
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
                echo"<h2> Inbox: </h2>";
                echo"<table class='table hover'>";
                echo"<th>Author :</th><th>Title</th>";
            //loading received messages
                $userId = $_SESSION['loggedUserId'];
                $messagesReceived = Message::loadMessageReceived($conn, $userId);

                if (!empty($messagesReceived)) {
                    foreach ($messagesReceived as $message) {
                        $messageId = $message->getId();
                        $messageSenderId = $message->getSenderId();
                        $messageTitle = $message->getTitle();
                        $messageText = $message->getText();
                        $messageStatus = $message->getStatus();

                        $sender = new User();
                        $sender->loadFromDB($conn, $messageSenderId);
                        $senderName = $sender->getFullName();

                        echo "<br>";

                        if ($messageStatus == 1) {
                            echo "<tr><td><a href='User_page.php?id={$messageSenderId}'>{$senderName}</a></td><td><a href='message_page.php?message_id={$messageId}&sender_id=$messageSenderId&receiver_id={$userId}'></a></td></tr>";
                        }
                    }
                }
            //loading sent message 
                echo"</table>";
                echo"<hr border= 2px/>";
                echo"<h2>Outbox</h2>";    
                $messageSent = Message::loadMessageSent($conn, $userId);
                echo"<table class ='table hover'>";
                echo"<th>Send to:</th><th>Title</th>";
                if(!empty($messageSent)){
                    foreach($messageSent as $message) {
                        $messageId = $message->getId();
                        $messageReceiverId = $message->getReciverId();
                        $messageTitle = $message->getTitle();
                        $messageText = $message->getText();
                        $messageStatus = $message->getStatus();

                        $receiver = new User();
                        $receiver->loadFromDB($conn, $messageReceiverId);
                        $receiverName = $receiver->getFullName();
                             echo"<tr><td><a href='User_page.php?id={$messageReceiverId}'>{$receiverName}</a></td><td><a href='message_page.php?message_id={$messageId}&receiver_id=$messageReceiverId&sender_id={$userId}'>{$messageTitle}</a></td></tr>";
                        
                     }
                 }
            echo "</TABLE>";
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
