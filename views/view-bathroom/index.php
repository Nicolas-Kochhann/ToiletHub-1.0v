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
    <link rel="preload" href="../resources/images/toilethub_logo.gif" as="image">
</head>
<body>
    <div class="container">

        <header>
            <div class="logo-container"></div>
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href='../list-bathrooms'>< Go Back</a>";
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

        <main class="fill">
            <div class="centered-box">

                <div class="slideshow-container">
                    
                    <div class="mySlides">
                        <img src="../resources/images/placeholders/turkish-man.png" style="width:100%">
                    </div>

                    <div class="mySlides">
                        <img src="../resources/images/placeholders/japanese-shitroom.png" style="width:100%">
                    </div>

                    <div class="mySlides">
                        <img src="../resources/images/placeholders/brazilian-bathroom.png" style="width:100%">
                    </div>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>

            </div>

        </main>

    </div>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        } 
    </script>
</body>
</html>