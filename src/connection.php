
<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Twitter";


// Tworzernie polaczenia
$conn = new mysqli($servername,$username,$password, $baseName);

if ($conn->connect_error){
    die("Połączenie nieudane. Błąd.".$connect_error);
}
?>
