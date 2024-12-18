<?php
function connecter($host, $username, $password, $dbname) {

    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
    
    return $conn;
}

$host="localhost";
$username="root";
$password="";
$dbname="keedi";

$connexion=connecter($host,$username,$password,$dbname);

?>