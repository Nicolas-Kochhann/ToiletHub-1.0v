<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub</title>
    <link rel="icon" href="../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../styles/listBathroomStyle.css">
</head>
<body>
    <div class="container">

        <header>
            <img src="" alt="logo">
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href=''>+ Create Bathroom</a>";
                } else {
                    echo "<span></span>";
                }

            ?>
            <div class="profile-container">
                <a class="link-profile" href="">
                    <img class="image-profile" src="../resources/images/pfp-default.svg" alt="pfp">
                </a>
            </div>
        </header>

        <main>
            <div class="list-grid">
                <div class="bathroom-list-container">
                    <img class="card-image" src="../resources/images/placeholders/japanese-shitroom.png">
                    <div class="card-info">
                        <h3>Banheiro TangKuan</h3>
                    </div>
                </div>
            </div>
        </main>

    </div>
</body>
</html>