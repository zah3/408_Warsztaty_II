<?php
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/connection.php';
require_once 'src/Comment.php';

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
                if($_SERVER['REQUEST_METHOD'] === 'GET') {

                    $tweetId = isset($_GET['id']) ? $_GET['id'] : null;
                    $tweet = new Tweet();
                    $tweet->loadTweetFromDB($conn, $tweetId);
                    $idUserTweet = $tweet->getUserId();

                    $user = new User();
                    $user->loadFromDB($conn, $idUserTweet);


                    echo "<h3>All information about this tweet:</h3>";
                    echo "<p> Author : {$user->getFullName()}</p>";
                    echo "<p> Text :  {$tweet->getText()}</p>";
                    echo "<h3>Comments:</h3>";
                    echo "<br>";
                    echo "<table class='table hover'>";
                    echo "<th>Fullname</th><th>text</th><th>Date and time</th>";

                    //show All commments for tweet
                    $comments = Comment::loadAllComments($conn, $tweetId);
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            $commentText = $comment->getText();
                            $commentDate = $comment->getCreationDate();
                            $commentUserId = $comment->getUserId();

                            $userComment = new User();
                            $userComment->loadFromDB($conn, $commentUserId);
                            $userFullname = $userComment->getFullName();
                            echo "<tr><td><a href='User_page.php?id=$commentUserId'>{$userFullname}</a></td><td>{$commentText}</td><td>{$commentDate}</td></tr>";
                        }
                        echo "</table>";
                    }
                }
                if($_SERVER['REQUEST_METHOD']=== "POST"){
                   if(!empty($_POST['Comment']) &&  trim($_POST['Comment']) != "" ){   
                        
                        $newComment = new Comment();
                        $newComment->setCommentId($_GET['id']);
                        $newComment->setUserId($_SESSION['loggedUserId']);
                        $newComment->setCreationDate(date('Y-m-d G:i'));
                        $newComment->setText(trim($_POST['Comment']));
                        $newComment->saveCommentToDb($conn);
                    }else{
                        echo"<div class='alert alert-warning'>";
                        echo"Cannot add Empty Comment";
                        echo"</div>";
                    }
                }    
            ?>
            <form method="POST">
                   <textarea rows="5" cols="40" maxlength="100" name="Comment">
                   </textarea>
                   <br>
                   <input type="submit" class="btn btn-primary" value="Comment">
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
