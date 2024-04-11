<?php
require_once(__DIR__ . "/../lib/db_config.php");
require(__DIR__ . "/../lib/safe_echo.php");
require(__DIR__ . "/../lib/flash_messages.php");
require(__DIR__ . "/../partials/nav.php");
// Message if you try to access this page and are not logged in
if (!isset($_SESSION['username'])) {
    flashMessage("You need to be logged in to view your history", "info");
    die(header("Location: login.php"));
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['pet_id'])) {
        $pet_id = $_POST['pet_id'];
        // Update the success field to true for the pet post with the given ID
        $stmt = $pdo->prepare("UPDATE pets SET success = 1 WHERE id = :pet_id");
        $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    header("location:userhistory.php");
}
// Preparing query for rows of post made ONLY by the user logged in
$stmt = $pdo->prepare("SELECT name, id, posted_by, breed, species, additional_details, image_id FROM pets WHERE success=0 AND posted_by = :username"); // Selecting specific columns
$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->execute();

// Count pet posts
$numPetPosts = $stmt->rowCount();

// Pet posts
$petPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <title>My Posts</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        .pet-post {
            position: relative;
            border: 2px solid black;;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .pet-post img {
            max-width: 100%;
            height: auto;
        }

        .center-div {
            width: 500px;
            margin: 0 auto;
        }

        .aligncenter {
        text-align: center;
        }

        .edit-btn {
        position: absolute;
        bottom: 10;
        right: 10;
    }

    </style>
<script>
function confirmSubmit()
{   // Show a confirmation dialog
    return confirm("Are you sure you want to mark this pet as found?");
}
</script>
</head>
<body style="background-color:#FFFAED;">
    <div class=center-div  >
        <?php
            if($numPetPosts == 0)
            {
                echo '<p> No active missing pet posts. </p>';
            }
            else{
                foreach ($petPosts as $pet) {
                echo '<br>';
                echo '<div class="pet-post">';
                echo '<p  class="aligncenter"><strong>Name: </strong> ' . $pet["name"];
                if ($pet["image_id"] != NULL)
                { echo '<p  class="aligncenter"> <img src="../media/uploads/' . $pet["image_id"] . '" height=250 width=310 > </p>';}
                echo '<p><strong>Species: </strong>' . $pet["species"];
                echo '<p><strong>Breed: </strong>' . $pet["breed"];
                echo '<p><strong>Posted By: </strong> ' . $pet["posted_by"] ; 
                echo '<p><strong>Additional Details: </strong> ' . $pet["additional_details"] ; 
                echo '<form method="post" action="userhistory.php" onsubmit="return confirmSubmit()">';
                echo '<input type="hidden" name="pet_id" value="' . $pet["id"] . '">';
                echo '<button type="submit" class="edit-btn" id="submitButton">Mark as Found</button>';
                echo '</form>';
                echo '</div>';
            }
            }
        ?>
    </div>
</body>
</html>
<?php
require(__DIR__ . "/../partials/flash.php");
?>