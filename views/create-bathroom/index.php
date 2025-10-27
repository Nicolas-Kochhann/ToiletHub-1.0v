<?php

session_start();

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
</head>
<body>
    <div class="container">

        <header>
            <div class="logo-container"></div>
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href=''>< Go Back</a>";
                } else {
                    header("Location: ../account/login");
                }

            ?>
            <div class="profile-container">
            <?php
            if(isset($_SESSION['userId'])){
                echo '<a class="link-profile" href="">
                <img class="image-profile" src="../resources/images/pfp-default.svg" alt="pfp">
                </a>';
            }    
            ?>      
            </div>
        </header>

        <main class="form-container">

            <div class="container-create-bathroom">
                <form class="create-bathroom-form" action="index.php" method="POST" enctype="multipart/form-data">
                    <label for="images" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Drop images of the bathroom here</span>
                        or
                        <input type="file" id="images" accept="image/*" required>
                    </label>
                    <label for="description">Description</label>
                    <input class="create-bathroom-input" type="text" name="description" id="description">
                    <div class="container-paid">
                        <label for="is-paid">Is it paid?</label>
                        <input type="checkbox" name="is-paid" id="isPaid">
                        <input class="create-bathroom-input" type="number" name="price" id="price" placeholder="How much?">
                    </div>
                </form>
            </div>

        </main>

    </div>
</body>
</html>