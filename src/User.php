<?php

require_once 'Message.php';

class User {
    

//    public static function getUserById(mysqli $conn, $id){
//        $sql = "SELECT * FROM User WHERE id = $id";
//        $result = $conn->query($sql);
//        if($result->num_rows == 1){
//            return $result->fetch_assoc();
//        }else{
//            return false;
//        }
//    }
    public static function getUserByEmail(mysqli $conn, $email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }
    
    public static function login(mysqli $conn, $email, $password) {
        $sql = "SELECT * FROM User WHERE email = '$email' ";
        $result = $conn->query($sql);
        if($result->num_rows == 1 ) {
            $rowUser = $result->fetch_assoc();
            if (password_verify($password, $rowUser['password']) && $rowUser['active'] == 1){
                return $rowUser['id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    
    private $id;
    private $email;
    private $fullName;
    private $active;
    
    public function __construct() {
        $this->id = -1;
        $this->email = '';
        $this->password = '';
        $this->fullName = 0;
        $this->active =0;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setEmail($email){
        $this->email = is_string($email) ? trim($email) : $this->email;
    }
    
    public function getEmail (){
        return $this->email;
    }
    
    public function setPassword($password, $retypePassword){
        if($password != $retypePassword) {
            return false;
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return true;
    }
    
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? trim($fullName) : $this->fullName;
    }
    
    public function getFullName(){
        return $this->fullName;
    }
    public function activate(){
        $this->active = 1;
    }
    
    public function deactivate(){
        $this->active = 0;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function saveToDB(mysqli $conn){
        if ($this->id == -1){
            $sql="INSERT INTO User (email, password, fullName, active) Values ('{$this->email}', '{$this->password}', '{$this->fullName}', '{$this->active}')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;// wartosc ostatniego id do bazy danych
                return true;
            }else{
                echo $conn->error;
                return false;
            }
        }else {
            $sql = "UPDATE User SET email = '{$this->email}', password='{$this->password}', fullName = '{$this->fullName}', active =  '{$this->active}' WHERE id = '{$this->id}'";
        }
        if($conn->query($sql)){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function loadFromDB(mysqli $conn, $id) {
        $sql = "SELECT * FROM User WHERE id=$id";
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->email = $rowUser['email'];
            $this->password = $rowUser['password'];
            $this->fullName = $rowUser['fullName'];
            $this->active = $rowUser['active'];
            return $this;
        }
        else {
            return null;
        }
    }
    

    public function show(){
        echo $this->email. ' '. $this->fullName;
    }
    
}
    