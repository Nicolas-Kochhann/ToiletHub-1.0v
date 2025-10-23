<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToiletHub</title>
    <link rel="icon" href="../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../styles/listStyle.css">
</head>
<body>
    <div class="container">

        <header>
            <img src="../resources/images/toilethub_logo.png" alt="logo">
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href=''>+ Create Bathroom</a>";
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

    </div>
</body>
</html>