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

                <div class="data-container">
                    <h1 class="bathroom-title">Cagatron 3000</h1>
                    <hr>
                    <div class="container-paid-info">
                        <p class="paid-text">Paid</p> <!-- Se for pago, classe unpaid-text e texto "Free" -->
                        <p class="price-text">$3.00</p> <!-- Se for pago, coloca o preço, se não, não coloca o p -->
                    </div>
                    <a href="">
                        <div class="maps-link">Go To Location (Maps)</div>
                    </a>
                    <div class="comment-container">
                        <h2 class="comment-header">Comments</h2>
                        <div class="post-comment-container">
                            <input class="comment-input" type="text" name="comment" id="comment" placeholder="Add a comment...">
                            <button disabled class="comment-submit" id="submitComment">Comment</button>
                        </div>
                        <div class="posted-comment">
                            <strong class="commenter">Cagador da Silva</strong>
                            <p class="comment-body">Caguei aqui e foi uma delícia!</p>
                        </div>
                    </div>
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
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
        } 

        const buttonComment = document.getElementById("submitComment");
        const commentField = document.getElementById("comment");

        commentField.addEventListener("input", () => {
            buttonComment.disabled = commentField.value.trim() === "";
        })
    </script>
</body>
</html>