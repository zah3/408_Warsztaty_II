<?php

class Message{
    

    public static function getMessageById(mysqli $conn, $id) {
        $sql="SELECT * FROM Message WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return false;
        }
    }
    private $id;
    private $sender_id;
    private $receiver_id;
    private $title; 
    private $text;
    private $status;
    
    public function __construct() {
        $this->id = -1;
        $this->sender_id = 0;
        $this->receiver_id = 0;
        $this->title = "";
        $this->text = "";
        $this->status = 0;
    }
    public function getId(){
        return $this->id;
    }
    public function getSenderId(){
        return $this->sender_id;
    }
    public function setSenderId($newSenderId){
        $this->sender_id = $newSenderId;
    }
    public function getReciverId(){
        return $this->receiver_id;
    }
    public function setReciverId($newReciverId){
        $this->receiver_id = $newReciverId;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($newTitle){
        $this->title = $newTitle;
    }
    public function getText(){
        return $this->text;
    }
    public function setText($newText){
        $this->text = is_string($newText) ? trim($newText) : $this->text;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($newStatus){
        $this->status = $newStatus;
    }
    public function statusToRead(){
        $this->status = 1;
        return $this->status;
    }
    public function saveMessageToDBP(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Message (sender_id, receiver_id, title, text, status) VALUE('{$this->sender_id}', '{$this->receiver_id}', '{$this->title}', '{$this->text}', '{$this->status}' )";
            if($conn->query($sql)){
                echo"<div class='alert alert-info'>";
                echo"Your Messege sended succesfull";
                echo"</div>";
            }else{
                echo"<div class='alert alert-alert'>";
                echo"There was problem to send message".$this->error;
                echo"</div>";
            }
            
       }elseif($this->id !== -1){
            $sql = "UPDATE Message SET sender_id='{$this->sender_id}', receiver_id=''{$this->receiver_id}', title='{$this->tittle}', text ='{$this->text}', status='{$this->status}'  WHERE id='{$this->id}')";
            if($conn->query($sql)){
                
                echo"<div class='alert alert-info'>";
                echo"Message has uptodate succesfull.";
                echo"</div>";
                return true;
            }
            else{
                echo"<div class='alert alert-info'>";
                echo"Cannot uptodate Message".$conn->error;
                echo"</div>";
                return false;
            }
        }
    }
    public function loadMessageFromDB(mysqli $conn,$messageId){
        $sql = "SELECT * FROM Message WHERE id= $messageId";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $rowMessage = $result->fetch_assoc();
            $this->id = $rowMessage['id'];
            $this->sender_id = $rowMessage['sender_id'];
            $this->receiver_id = $rowMessage['receiver_id'];
            $this->title = $rowMessage['title'];
            $this->text = $rowMessage['text'];
            $this->status = $$rowMessage['status'];
        }
        return null;
    }
}
