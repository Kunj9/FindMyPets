<?php
$dbname = "findmypet";
$dbuser = "kb556";
$dbpass = "password";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

}catch(PDOException $err){
    echo "Database connection problem: ". $err -> getMessage();
    exit();
}
?>