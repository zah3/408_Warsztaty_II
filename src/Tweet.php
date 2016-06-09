<?php
/*
 CREATE TABLE Tweet(
    id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    text CHAR(200),
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES User(id)
 */
 
class Tweet {
    
    static function show(mysqli $conn, $id) {
        $sql = "SELECT * FROM Tweet WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row; 
        }
        else{
            return false;
        }
    }
    
    public static function loadAllComments(mysqli $conn, $id){
        $sql = "SELECT Comment.text, User.fullName, Comment.creation_date, Comment.user_id FROM Comment JOIN User ON Comment.user_id = User.id WHERE post_id = $id ORDER BY Comment.creation_date DESC";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $comments = [];
            while($row = $result -> fetch_assoc()){
                   $comments[] = [$row['fullName'],$row['creation_date'],$row['text'],$row['user_id']];

            }
            return $comments;
        }
        return false;
    }
    
    private $id;
    private $user_id;
    private $text;
    
    public function __construct(){
        $this->id = -1;
        $this->user_id = '';
        $this->text = '';
     }
    
    public function getId(){
        return $this->id;
    }
    
    public function setUserId($id){
        $this->user_id = is_numeric($id) ? trim($id) : $this->user_id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function setText($text){
        $this->text = is_string($text) ? trim($text) : $this->text;
    }
    
    public function loadTweetFromDB(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Tweet WHERE id= $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $rowTweet = $result->fetch_assoc();
            $this->id = $rowTweet['id'];
            $this->user_id = $rowTweet['user_id'];
            $this->text = $rowTweet['text'];
        }
        return null;
    }
    
    public function saveTweetToDB(mysqli $conn){ // Zawiera w sobie funkcje create i update.
        if($this->id === -1){
            $sql = "INSERT INTO Tweet (user_id,text) VALUES ({$this->user_id},'{$this->text}')";
           if($conn->query($sql)) {
               $this->id = $conn->insert_id;
               echo "Tweet has added succesfull";
               return true;
            }
            else{
                echo "Cannot add tweet<br>".$conn->error;
                return false;
            }
        }elseif($this->id !== -1){
            $sql = "UPDATE Tweet SET user_id='{$this->id}', text ='{$this->text}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                echo"Tweet has uptodate succesfull.";
                return true;
            }
            else{
                echo"Cannot uptodate Tweet".$conn->error;
                return false;
            }
        }else{
            return false;
        }
   }


}