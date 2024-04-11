<?php
require_once(__DIR__ . "/../lib/db_config.php");
require(__DIR__ . "/../lib/safe_echo.php");
require(__DIR__ . "/../partials/nav.php");
if (!isset($_SESSION['username'])) {
    // Sets message for login page
    flashMessage("You need to be logged in to create a post.", "info");
    die(header("Location: login.php"));
}
?>

<?php

    $hasError = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = se($_POST, "name", " ", false);
    $postedBy = se($_POST, "postedBy", " ", false);
    $breed = se($_POST, "breed", " ", false);
    $species = se($_POST, "species", " ", false);
    $gender = se($_POST, "gender", " ", false);
    $status = se($_POST, "status", " ", false);
    
    $imageID = '';
    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] == UPLOAD_ERR_OK) {
        $imgFile = $_FILES['petImage'];
        $fileName = $_FILES['petImage']['name'];
        $extension = explode( '.', $fileName );
        $imgExtension = strtolower(end($extension));
        $imageID = uniqid('', true).".".$imgExtension;
        $imageFinalLocation = '../media/uploads/' . $imageID;
        move_uploaded_file($_FILES['petImage']['tmp_name'], $imageFinalLocation);
    }


    $additionalDetails = se($_POST, "additionalDetails", " ", false);

    if(!$hasError)
    { 
        $stmt = $pdo->prepare("INSERT INTO pets (name, posted_by, breed, species, gender, status, found_datetime, lost_datetime, additional_details, image_id) 
        VALUES (:name, :postedBy, :breed, :species, :gender, :status, :foundDatetime, :lostDatetime, :additionalDetails, :imageID)");
   
   if ($status == "found") {
    $foundDatetime = se($_POST, "dateTime", " ", false);
    $lostDatetime = se($_POST, NULL, " ", false);
    $stmt->bindParam(":foundDatetime", $foundDatetime, PDO::PARAM_STR);
    $stmt->bindValue(":lostDatetime", null, PDO::PARAM_NULL);
    $stmt->bindValue(":imageID", $imageID, PDO::PARAM_STR);

} elseif ($status == "lost") {
    $lostDatetime = se($_POST, "dateTime", " ", false);
    $foundDatetime = se($_POST, NULL, " ", false);
    $stmt->bindParam(":lostDatetime", $lostDatetime, PDO::PARAM_STR);
    $stmt->bindValue(":foundDatetime", null, PDO::PARAM_NULL);
    $stmt->bindValue(":imageID", $imageID, PDO::PARAM_STR);

}
   try {
        $stmt->execute([
            ":name" => $name,
            ":postedBy" => $postedBy,
            ":breed" => $breed,
            ":species" => $species,
            ":gender" => $gender,
            ":status" => $status,
            ":foundDatetime" => $foundDatetime,
            ":lostDatetime" => $lostDatetime,
            ":additionalDetails" => $additionalDetails,
            ":imageID" => $imageID
        ]);
        echo "Your post has been uploaded!";
    } catch (Exception $e) {
        echo "There was a problem registering the pet";
        echo "<pre>" . var_export($e, true) . "</pre>";
    }
}

// Set the session variable so postcreated only accessed if it was redirected
$_SESSION['access_method'] = "redirected";
die(header("location:postcreated.php"));
}
?>

<script>

    function validate(form) {
  if(document.getElementById('reportPetForm').submit()){
      ;
      return(true);
   }else{
      return(false);
    } 
    }
    

    function showAllFields() {
        var foundFields = document.getElementById('foundFields');
        var lostFields = document.getElementById('lostFields');
        var elements = document.getElementsByClassName('otherFields')

        if (document.getElementById('foundRadio').checked) {
            foundFields.style.display = 'block';
            lostFields.style.display = 'none';
            for (var i = 0; i < elements.length; i++) {
                
                    elements[i].style.display = 'block';
                
            }
        } else if (document.getElementById('lostRadio').checked) {
            foundFields.style.display = 'none';
            lostFields.style.display = 'block';
            
            for (var i = 0; i < elements.length; i++) {

                    elements[i].style.display = 'block';
                
            }

        } 
}
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Missing Pet </title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }


        form {
            max-width: 400px;
            margin: 0 auto;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .radio-group {
           width: 10px;
            white-space: nowrap;
        }
        .hidden {
            display: none;
        }
        .otherFields {
            display: none;
        }

        .statusLabel
        {
            font-size: 20px;
            margin-top: 80px;
            display: inline-block;
        }


        
    </style>
</head>
<body style="background-color:#FFFAED;">


<form id="reportPetForm" method="POST" enctype="multipart/form-data">
    <div class="radio-group">  

    <label for="status" class="statusLabel"> Status of Pet: </label> 

          <p><input type="radio" name="status" value="found" id="foundRadio"  required onclick="showAllFields()" />
            Found 
            <input type="radio" name="status" value="lost" id="lostRadio"  required onclick="showAllFields()"  />
            Lost
    
    </div>


    <div class="otherFields">
        <label class="form-label" for="postedBy">Posted By</label>
        <input class="form-control"  style="background-color: #d8d8d8;" type="text" name="postedBy" value="<?php echo $_SESSION['username']; ?>" readonly required maxlength="30"/>
    </div>


    <div class="otherFields">
        <label for="name">Pet Name</label>
        <input type="text" name="name" required />
    </div>


    <div class="otherFields">
        <label for="breed">Breed</label>
        <input type="text" name="breed" required />
    </div>

    <div class="otherFields">
        <label for="gender">Gender</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Unknow">Unknown</option>
        </select>
        </div>


    <div class="otherFields">
        <label for="species">Species</label>
        <select name="species" required>
                <option value="Apes">Apes</option>
                <option value="Arachnids">Arachnids</option>
                <option value="Bird">Bird</option>
                <option value="Cat">Cat</option>
                <option value="Dog">Dog</option>
                <option value="Mustelidae">Mustelidae</option>
                <option value="Rabbits">Rabbits</option>
                <option value="Reptiles">Reptiles</option>
                <option value="Rodents">Rodents</option>
                <option value="Snake">Snake</option>
                <option value="Other">Other</option>
    </select>
    </div>



    

 <div id="foundFields" class="hidden">
        <label for="dateTime">Found Date and Time</label>
        <input type="datetime-local" name="dateTime" required />
    </div> 

       <div id="lostFields" class="hidden">
        <label for="lostDatetime">Lost Date and Time</label>
        <input type="datetime-local" name="lostDatetime" required />
    </div>
    
    <div id="petImage" class="otherFields">
        <label for="petImage">Upload Image</label>
        <input type="file" name="petImage" accept="image/*" required>
    </div>

    <div class="otherFields">
        <label for="additionalDetails">Additional Details</label>
        <textarea name="additionalDetails"></textarea>
    </div>
 
    
    <div class="otherFields">
    <input type="button" value="Submit" onclick="JavaScript:return validate();" />

    </div>
</form>

</body>
</html>