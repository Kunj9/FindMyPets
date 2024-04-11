<?php
require_once(__DIR__ . "/../lib/db_config.php");
require(__DIR__ . "/../lib/flash_messages.php");
require(__DIR__ . "/../lib/safe_echo.php");
require(__DIR__ . "/../partials/nav.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an Account</title>
    <style>
         body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .slogan {
            color:#b9b0b0;
            margin-left: 300px;
            font-family: Papyrus, fantasy;
        }
        .container {
        display: flex; 
        justify-content: center; 
        align-items: center; 
        }

        .image-container {
        margin: right;
        }

        .form-container {
        background-color: #FFFAFF;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        border: 2px solid black;
        padding: 20px;
        margin-left: 300px;
        margin-right: 300px;
        flex: 1; 
        }

        .loginlabel{
        font-family: Arial, sans-serif;
        font-size: 20px;

        }
    </style>
</head>
<body style="background-color:#FFFAED;">
<div class="container">
    <div class="image-container">
        <img style="margin-left: 200px; margin-top: 100px;" src="../media/stockimgs/logo.png" height=400 width=500>
        <h1 class=slogan>A place for animal<br>lovers to connect. </h1> 
    </div>
    <div class="form-container">
    <form onsubmit="return validate(this)" method="POST">
    <div>
        <label class="loginlabel" for="email">Email</label>
        <input type="email" name="email" required />
    </div>
    <p></p>
    <div>
            <label class="loginlabel" class="form-label" for="username">Username</label>
            <input class="form-control" type="text" name="username" required maxlength="30"/>
        </div>
        <p></p>
    <div>
        <label class="loginlabel" for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <p></p>
    <div>
        <label class="loginlabel" for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
    </div>
    <p></p>
    <input class="loginlabel" type="submit" value="Register" />
</form>
    </div>
</div>
</body>
</html>


<script>
    function validate(form) {
        //returns false for an error and true for success
        return true;
    }
</script>
<?php
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $username = se($_POST, "username", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $hasError = false;
    if (empty($email)) {
        flashMessage("Email must not be empty", "error");
        $hasError = true;
    }
    //sanitize
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flashMessage("Invalid email", "error");
        $hasError = true;
    }
    if (empty($password)) {
        flashMessage("Password must not be empty", "error");
        $hasError = true;
    }
    if (empty($confirm)) {
        flashMessage("Confirm Password must not be empty", "error");
        $hasError = true;
    }
    if (strlen($password) < 8) {
        flashMessage("Password must be >8 characters", "error");
        $hasError = true;
    }
    if (strlen($password) > 0 && $password !== $confirm) {
        flashMessage("Passwords must match", "error");
        $hasError = true;
    }
    if (!$hasError) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO Users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flashMessage("Successfully registered!", "success");
        } catch (Exception $e) {
            flashMessage("There was a problem registering", "error");
    }
}
}
?>
<?php
require(__DIR__ . "/../partials/flash.php");
?>