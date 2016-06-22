<?php

 
class Tweet {




    public static function loadAllTweets(mysqli $conn, $id)
    {
        $sql = "SELECT * FROM Tweet WHERE user_id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $tweets = [];

            while ($row = $result->fetch_assoc()) {
                $objectTweets = new Tweet ();
                $objectTweets->text = $row['text'];
                $objectTweets->id = $row['id'];

                $tweets[] = $objectTweets;
            }
            return $tweets;
        }
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
    
    public function saveTweetToDB(mysqli $conn)
    { // including update and save to DB
        if ($this->id === -1) {
            $sql = "INSERT INTO Tweet (user_id,text) VALUES ({$this->user_id},'{$this->text}')";
            if ($conn->query($sql)) {
                $this->id = $conn->insert_id;
                echo "Tweet has added succesfull";
                return true;
            } else {
                echo "Cannot add tweet<br>" . $conn->error;
                return false;
            }
        } elseif ($this->id !== -1) {
            $sql = "UPDATE Tweet SET user_id='{$this->id}', text ='{$this->text}' WHERE id='{$this->id}'";
            if ($conn->query($sql)) {
                echo "Tweet has uptodate succesfull.";
                return true;
            } else {
                echo "Cannot uptodate Tweet" . $conn->error;
                return false;
            }
        } else {
            return false;
        }
    }

    public function show(mysqli $conn, $id) {
        $sql = "SELECT * FROM Tweet WHERE id = '$id'";

        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            echo $row['text'];
        }
        else{
            return false;
        }
    }




}