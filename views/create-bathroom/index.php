<?php

require __DIR__."/../../vendor/autoload.php";

use Src\Models\User;
use Src\Models\Bathroom;

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
    $bathroom->save();

    $savedImages = $bathroom->uploadImage($_FILES);
    Bathroom::saveImage($bathroom->getBathroomId(), $savedImages);
}

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
                <form class="create-bathroom-form" action="index.php" method="POST" enctype="multipart/form-data">
                    <label for="images" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Drop images of the bathroom here</span>
                        or
                        <input type="file" id="images" accept="image/*" multiple required>
                    </label>
                    <label for="description">Description</label>
                    <input class="create-bathroom-input" type="text" name="description" id="description">
                    <div class="container-fields">
                        <input type="checkbox" name="is-paid" id="isPaid">
                        <label for="isPaid">Is it paid?</label>
                        <input class="bathroom-price-input" type="number" name="price" id="price" placeholder="How much?">
                    </div>
                    <label for="lat">Latitude</label><br>
                    <input class="latlon-input" type="text" name="lat" id="lat"><br>
                    <label for="lon">Longitude</label><br>
                    <input class="latlon-input" type="text" name="lon" id="lon"><br>
                    <button type="button" onclick="getLocation()">Use Current Location</button>
                    <button class="submit" name="submit">Create Bathroom</button>
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