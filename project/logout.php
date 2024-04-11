<?php
require(__DIR__ . "/../partials/nav.php");
require(__DIR__ . "/../lib/flash_messages.php");
session_unset();
session_destroy();
session_start();
flashMessage("Logged out successfully", "success");
header("Location: login.php");
?>
