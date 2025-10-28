<?php

require __DIR__."/../../vendor/autoload.php";

use Src\Models\Bathroom;

session_start();

$bathrooms = Bathroom::listAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub</title>
    <link rel="icon" href="../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../styles/listStyle.css">
    <link rel="preload" href="../resources/images/toilethub_logo.gif" as="image">
</head>
<body>
    <div class="container">

        <header>
            <div class="logo-container"></div>
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href='../create-bathroom'>+ Create Bathroom</a>";
                } else {
                    echo "<a class='link-create-bathroom' href='../account/login'>+ Log in or Create Account</a>";
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

        <main>

            <div class="list-grid">
                <?php
                if(count($bathrooms) > 0){
                    foreach($bathrooms as $bathroom){
                        $images = Bathroom::findBathroomImages($bathroom->getBathroomId());
                        echo "<div class='bathroom-card-container'>
                                <img src='../../resources/bathrooms/{$bathroom->getBathroomId()}/{$images[0]}' alt='' class='bathroom-card-image'>
                                <span class='bathroom-text-container'>
                                <strong>{$bathroom->getDescription()}</strong>
                                </span>
                            </div>";
                    }
                } else {
                    echo "<h1>No registered toilets yet. Be you the first ;)";
                }

                ?>
                
                <div class="bathroom-card-container">
                    <img src="../resources/images/placeholders/japanese-shitroom.png" alt="" class="bathroom-card-image">
                    <span class="bathroom-text-container">
                        <strong>MacuDunoradus Batirumo</strong>
                    </span>
                </div>
                
            </div>
        </main>

    </div>
</body>
</html>