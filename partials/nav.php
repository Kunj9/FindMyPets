<?php
require_once(__DIR__ . "/../lib/db_config.php");
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
//include functions here so we can have it on every page that uses the nav bar
//that way we don't need to include so many other files on each page
//nav will pull in functions and functions will pull in db
// require(__DIR__ . "/../lib/functions.php");
session_start();

// Success Counter
// Preparing query for rows of post made ONLY by the user logged in
$stmt = $pdo->prepare("SELECT * FROM pets WHERE success=1");
$stmt->execute();
// Count pet posts
$successCount = $stmt->rowCount();

echo'
<div class="mydiv" style="bottom: 15; right: 15;"> 
  <div class="mydivheader"><img src="../media/stockimgs/counter.gif" width="210" height="65"></div>
  <div><p style="padding: 0px; font-size: 25px;">' . $successCount . '</p></div>
</div>';
if(!isset($_SESSION['username']))
{
    echo'
    <nav>
    <ul >
        <li><img class="homeImg"  src="../media/stockimgs/home.png"></li>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><img class="logoImg" src="../media/stockimgs/logo.png"></li>
    </ul>
</nav>';
}
else
{echo'
<nav>
    <ul >
        <li><img class="homeImg"   src="../media/stockimgs/home.png"></li>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="createpost.php">Report a pet</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><img class="logoImg"    src="../media/stockimgs/logo.png"></li>
    </ul>
</nav>';
require(__DIR__ . "/../partials/sidebar.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="15*60;url=logout.php" /> 

    <style>
/* CSS styles for navbar */
    
nav {
    background-color: #20b2aa;
    height: 75px;
    color: #fff;
    padding: 20px;
    text-align: center;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav li {
    font-size: 35px; 
    padding: 0 10px;
}

nav a {
    color: #fff;
    text-decoration: none;
}

nav a:hover {
    text-decoration: underline;
}

.logoImg {
    height: 80px;
    width: 100px;
}

.homeImg 
{
    height: 40px;
    width: 40px;
}

nav ul li:nth-last-child(2) {
    margin-left: auto;
}

.mydiv {
  position: fixed;
  z-index: 9;
  background-color: #f1f1f1;
  text-align: center;
  border: 1px solid #d3d3d3;
}

.mydivheader {
  padding: 0px;
  cursor: move;
  z-index: 10;
  background-color: #2196F3;
  color: #fff;
}
</style>
</head>
</html>