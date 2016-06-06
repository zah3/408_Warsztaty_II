<?php

require_once 'src/User.php';
require_once 'src/connection';

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

if($userId) {
    $user = new User();
    $user->loadFromDB ($conn, $userId);
}
?>
