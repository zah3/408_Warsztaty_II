
<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Twittee";


// Tworzernie polaczenia
$conn = new mysqli($servername,$username,$password, $baseName);

if ($conn->connect_error){
    die("Połączenie nieudane. Błąd.".$connect_error);
}else {
    echo "Połączenie udane";
    
}


?>
