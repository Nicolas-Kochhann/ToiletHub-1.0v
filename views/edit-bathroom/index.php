<?php

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require __DIR__."/../../vendor/autoload.php";

use Src\Models\User;
use Src\Models\Bathroom;
use Src\Models\Uploader;
use Src\Exceptions\Infrastructure\UploadException;

session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: ../account/login");
}

if (isset($_POST['submit'])){

    $description = htmlspecialchars($_POST['description']);
    $isPaid = (bool)htmlspecialchars($_POST['is-paid']);
    $price = (int)htmlspecialchars($_POST['price']) ?? null;
    $lat = htmlspecialchars($_POST['lat']);
    $lon = htmlspecialchars($_POST['lon']);
    $loggedUser = User::find($_SESSION['userId']);

    $bathroom = new Bathroom($description, $isPaid, $price, $lat, $lon, $loggedUser);
    $bathroom->setBathroomId((int)$_GET['bathroomId']);

    if(!empty($_FILES['images']['tmp_name'][0])){
        try{
            $bathroom->save();
            $images = Bathroom::findBathroomImages($bathroom->getBathroomId());
            Uploader::deleteImages($images);
            Bathroom::deleteImage($bathroom->getBathroomId(), $images);

            $savedImages = Uploader::uploadImages($_FILES['images']);
            Bathroom::saveImage($bathroom->getBathroomId(), $savedImages);

            header("Location: ../list-bathrooms/");
            
        } catch(UploadException $e){
            $error = $e->getMessage();
        } catch(PDOException $e){
            $error = 'Sorry, it seems that one of the parameters passed is invalid.';
        }
        
    }else{
        try{
            $bathroom->save();
            header("Location: ../list-bathrooms/");
        } catch (PDOException $e){
            $error = 'Sorry, it seems that one of the parameters passed is invalid.';
        }
    }
}

$bathroom = Bathroom::find((int)$_GET['bathroomId']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToiletHub</title>
    <link rel="icon" href="../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../styles/listStyle.css">
    <link rel="stylesheet" href="../styles/createBathroomStyle.css">
    <script src="../scripts/geolocation.js" defer></script>
</head>
<body>
    <div class="container">

        <header>
            <div class="logo-container"></div>
                    <a class='link-create-bathroom' href='../list-bathrooms/'>< Go Back</a>
            <div class="profile-container">
            <?php
            $profilePicture = $_SESSION['profilePicture'] ?? '../resources/images/pfp-default.svg';
        
            echo "<a class='link-profile' href=''>
                <img class='image-profile' src='{$profilePicture}' alt='pfp'>
                </a>";
            ?>   
            </div>
        </header>

        <main class="form-container">

            <div class="container-create-bathroom">
                <form class="create-bathroom-form" action="index.php?bathroomId=<?=$bathroom->getBathroomId()?>" method="POST" enctype="multipart/form-data">
                    <label for="images" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Drop the new images here</span>*This will replace the previous ones
                        <input type="file" id="images" name="images[]" accept="image/*" multiple>
                    </label>
                    <label for="description">Description</label>
                    <input class="create-bathroom-input" type="text" name="description" id="description" value="<?= $bathroom->getDescription()?>">
                    <div class="container-fields">
                        <input type="checkbox" name="is-paid" id="isPaid">
                        <label for="isPaid">Is it paid?</label>
                        <input class="bathroom-price-input" type="number" name="price" id="price" placeholder="How much?" value="<?= $bathroom->getPrice() ?>">
                    </div>
                    <label for="lat">Latitude</label><br>
                    <input class="latlon-input" type="text" name="lat" id="lat" value="<?= $bathroom->getLat()?>"><br>
                    <label for="lon">Longitude</label><br>
                    <input class="latlon-input" type="text" name="lon" id="lon" value="<?= $bathroom->getLon()?>"><br>
                    <button type="button" onclick="getLocation()">Use Current Location</button>
                    <button class="submit" name="submit">Save Changes</button>
                </form>
            </div>

        </main>

    </div>
    <script>
        const checkbox = document.getElementById('isPaid');
        const priceInput = document.getElementById('price');
        priceInput.disabled = true;

        checkbox.addEventListener('change', function() {
            priceInput.disabled = this.checked ? false : true;
        });

        const dropContainer = document.getElementById("dropcontainer")
        const fileInput = document.getElementById("images")

        dropContainer.addEventListener("dragover", (e) => {
            // prevent default to allow drop
            e.preventDefault()
        }, false)

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drag-active")
        })

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drag-active")
        })

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault()
            dropContainer.classList.remove("drag-active")
            fileInput.files = e.dataTransfer.files
        })

    </script>
</body>
</html>