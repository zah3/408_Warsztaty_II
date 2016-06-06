<?php

class Comment {
    
    static function show(mysqli $conn, $id) {
        $sql = "SELECT * FROM Comment WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row; 
        }
        else{
            return false;
        }
    }
    
    private $id;
    private $user_id;
    private $post_id;
    private $creation_date;
    private $text;

    public function __construct() {
        $this->id = -1;
        $this->user_id = "";
        $this->post_id="";
        $this->creation_date = "";
        $this->text = "";
    }

    public function getId(){
        return $this->id;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function setUserId($newUserId){
        $this->user_id = is_numeric($newUserId) ? trim($newUserId) : $this->user_id;
    }
    
    public function getCommentId(){
        return $this->post_id;
    }
    
    public function setCommentId($newCommentId){
         $this->post_id = is_numeric($newCommentId) ? trim($newCommentId) : $this->post_id;
    }
    
    public function getCreationDate(){
        return $this->creation_date;
    }
    
    public function setCreationDate($newDate){
        $this->creation_date = $newDate;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function setText($newText){
          $this->text = is_string($newText) ? trim($newText) : $this->text;
    }

    public function loadFromDB(mysqli $conn, $id){

        $sql = "SELECT * FROM Comment WHERE id= $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $rowComment = $result->fetch_assoc();
            $this->id = $rowComment['id'];
            $this->user_id = $rowComment['user_id'];
            $this->post_id = $rowComment['post_id'];
            $this->creation_date = $rowComment['creation_date'];
            $this->text = $rowComment['text'];
        }
        return null;
    }
    
    public function saveCommentToDb(mysqli $conn){ // zawiera w sobie funkcje create i update.
        if($this->id === -1){
            $sql = "INSERT INTO Comment (user_id,post_id,creation_date,text) VALUES ({$this->user_id}, {$this->post_id}, '{$this->creation_date}','{$this->text}' )";
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                echo "Comment has added succesfull<br>";
                return true;
            }
            else{
                echo "Cannot add comment <br>".$conn->error;
                return false;
            }
        }elseif($this->id !== -1){
            $sql = "UPDATE Comment SET user_id='{$this->user_id}', post_id='{$this->post_id}', creation_date='{$this->creation_date}', text ='{$this->text}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                echo"Comment has uptodate succesfull.";
                return true;
            }
            else{
                echo"Cannot uptodate Comment".$conn->error;
                return false;
            }
        }
    } 
    
    
}
?>