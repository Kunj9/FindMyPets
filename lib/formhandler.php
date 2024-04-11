<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
    // $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    
    try{
        require_once "db.php";

        $query = "INSERT INTO users(password, email) VALUES($password, $email);";

        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES(:email, :password)");

            $stmt->execute([":email" => $email, ":password" => $password]);
    
    }catch(PDOException $e){
        die("FAILURE because " . $e->getMessage());
    }

} else{
    header("Location: ../frontend/demo.php");
}
?>