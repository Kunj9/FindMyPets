<?php
require_once(__DIR__ . "/../lib/db_config.php");
require(__DIR__ . "/../lib/safe_echo.php");
require(__DIR__ . "/../partials/nav.php");
require(__DIR__ . "/../lib/flash_messages.php");


if(!(isset($_SESSION['access_method']) && $_SESSION['access_method'] === "redirected"))
{
    flashMessage("You need to first create a post", "info");
    die(header("location:createpost.php"));
}
else
    unset($_SESSION['access_method']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Successful</title>
<style>
    body {
        font-family: "Lato", sans-serif;
        background-color: #FFFAED;
    }

    .container {
        text-align: center;
    }

    .check-image {
        background-color: transparent;
        width: 300px;
        height: auto;
        margin-bottom: 20px;
    }
</style>
</head>
<body>

<div class="container">
    <img class="check-image" src="../media/stockimgs/greencheck.png"  alt="Check Image">
    <p style="font-size: 30px;">Upload successful</p>
    <p style="font-size: 15px;">Your post has been submitted and will be available to all users.</p>
</div>
</body>
</html>
<?php
require(__DIR__ . "/../partials/flash.php");
?>