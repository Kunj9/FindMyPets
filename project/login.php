<?php
require_once(__DIR__ . "/../lib/db_config.php");
require(__DIR__ . "/../lib/safe_echo.php");
require(__DIR__ . "/../lib/flash_messages.php");
require(__DIR__ . "/../partials/nav.php");

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);

    $hasError = false;
    if (empty($email)) {
        flashMessage("Email must not be empty", "error");
        $hasError = true;
    }

    if (!$hasError) {
        $stmt = $pdo->prepare("SELECT email, password, username from Users where email = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        $_SESSION['username'] = $user["username"];
                        header("Location: homepage.php");
                        exit();
                    } else {
                       flashMessage("Invalid password", "error");
                    }
                } else {
                    flashMessage("Email not found", "error");
                }
            }
        } catch (Exception $e) {
            flashMessage("Error logging in. Please try again.", "error");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #FFFAED;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: none;
        }

        .form-container {
            background-color: #FFFAFF;
            background-image: url(https://static.vecteezy.com/system/resources/thumbnails/021/599/588/small/abstract-white-and-gray-overlap-circles-background-3d-paper-circle-banner-with-drop-shadows-minimal-simple-design-for-presentation-flyer-brochure-website-book-etc-vector.jpg); 
            background-size: cover;
            background-repeat: no-repeat;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 2px solid black;
            padding: 60px;
            margin-left: 600px;
            margin-right: 600px;
            margin-top: 50px; 
            height: 400px;
            width: 400px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .loginlabel {
            font-family: Arial, sans-serif;
            font-size: 24px; 
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            font-size: 18px;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            font-size: 20px; 
            padding: 10px 20px; 
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        a {
            font-size: 18px; 
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <center>
        <div class="container">
            <div class="form-container">
                <form onsubmit="return validate(this)" method="POST">
                <h3 class=slogan>A place for animal lovers to connect. </h3> 
                    <div>
                        <label class="loginlabel" for="email">Email</label>
                        <p></p>
                        <input type="email" name="email" required placeholder="Enter your email" />
                    </div>
                    <p></p>
                    <div class="password-container">
                        <label class="loginlabel" for="pw">Password</label>
                        <p></p>
                        <div style="position: relative;">
                            <input type="password" id="pw" name="password"  placeholder="Enter your password" />
                            <p></p>
                            <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()" />
                            <label for="showPassword" style="font-size: 14px;">Show Password</label>
                        </div>
                    </div>
                    <p></p>
                    <input class="loginlabel" type="submit" value="Login" />
                    <p></p>
                    <a href="register.php">Register an Account</a> 
                    <P></p>
                    <a href="https://www.instagram.com/" target="blank">
                        <i class="fab fa-instagram" style="margin-right: 20px;"></i>
                        <img src="data:image/jpeg;base64,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" alt="Instagram" style="width: 20px; height: 20px;">
                    </a></t>
                    <a href="https://twitter.com/?lang=en" target="blank">
                        <i class="fab fa-twitter" style="margin-right: 20px;"></i>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ34q30sB4XwODyRS3oUzKBuQcyKFJc8GG7mg&s" alt="Twitter" style="width: 20px; height: 20px;">
                    </a>
                    <a href="https://www.facebook.com/" target="blank">
                        <i class="fab fa-facebook" style="margin-right: 20px;"></i>
                        <img src="data:image/png;base64,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" alt="Facebook" style="width: 20px; height: 20px;">
                    </a>
                </form>
                
            </div>
        </div>
        
    </center>

    <style>
    .visible-password {
        -webkit-text-security: none; /* For Safari */
        text-security: none; /* For other browsers */
    }
</style>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("pw");
        passwordInput.classList.toggle("visible-password");
    }

    function validate(form) {
        return true;
    }
</script>


</body>
</html>

<?php
require(__DIR__ . "/../partials/flash.php");
?>
