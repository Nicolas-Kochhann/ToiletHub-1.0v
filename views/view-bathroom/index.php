<?php

require __DIR__."/../../vendor/autoload.php";

use Src\Models\User;
use Src\Models\Bathroom;
use Src\Models\Review;

session_start();

if(isset($_POST['submitComment'])){
    $review = new Review($_POST['comment'], $_POST['bathroomId'], User::find($_POST['loggedUserId']));
    $review->save();
    $_GET['bathroomId'] = $_POST['bathroomId'];
}

$bathroom = Bathroom::find((int)$_GET['bathroomId']);
$reviews = Review::listAll();
$images = $bathroom->findBathroomImages($bathroom->getBathroomId());
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
                <a class='link-create-bathroom' href='../list-bathrooms'>< Go Back</a>
            <div class="profile-container">
            <?php
            if(isset($_SESSION['userId'])){
                $profilePicture = $_SESSION['profilePicture'] ? "../../resources/users/{$_SESSION['profilePicture']}" : '../resources/images/pfp-default.svg';

                echo "<a class='link-profile' href=''>
                <img class='image-profile' src='{$profilePicture}' alt='pfp'>
                </a>";

            }    
            ?>      
            </div>
        </header>

        <main class="fill">
            <div class="centered-box">

                <div class="slideshow-container">
                    
                    <?php
                    
                    foreach($images as $image){
                        echo "
                            <div class='mySlides'>
                                <img src='../../resources/bathrooms/{$image}' style='width:100%'>
                            </div>  
                        ";
                    }
                    if(count($images) > 1){
                        echo '
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        ';
                    }
                    ?>
                    
                </div>

                <div class="data-container">
                    <h1 class="bathroom-title"><?= $bathroom->getDescription() ?></h1>
                    <hr>
                    <div class="container-paid-info">
                        <p class="<?= $bathroom->getIsPaid() ? "paid-text" : "unpaid-text" ?>"><?= $bathroom->getIsPaid() ? "Paid" : "Free"?></p> <!-- Se for pago, classe unpaid-text e texto "Free" -->
                        <p class="price-text"><?= $bathroom->getIsPaid() ? "$" . $bathroom->getPrice() : "" ?></p> <!-- Se for pago, coloca o preço, se não, não coloca o p -->
                    </div>
                    <a target="_blank" href='<?= "https://www.google.com/maps?q=".$bathroom->getLat().",".$bathroom->getLon() ?>'>
                        <div class="maps-link">Go To Location (Maps)</div>
                    </a>

                    <!-- !!!!!!!!!!!!! OS DOIS BOTOES ABAIXO SO APARECEM SE FOR A PESSOA QUE CRIOU O BANHEIRO !!!!!!!!!!!!! -->
                    <?php
                        if($_SESSION['userId'] === $bathroom->getOwner()->getUserId()){
                            echo '
                                <a href="../edit-bathroom/?bathroomId='.$bathroom->getBathroomId().'">
                                    <div class="edit-bathroom">Edit Toilet</div>
                                </a>
                                <a href="../../commands/deleteBathroom.php?bathroomId='.$bathroom->getBathroomId().'">
                                    <div class="delete-bathroom">Delete Toilet</div>
                                </a>
                            ';
                        }
                    ?>
                    

                    <div class="comment-container" id="comment-container">
                        <h2 class="comment-header">Comments</h2>
                        <?php

                        if(isset($_SESSION['userId'])){
                            echo '<div class="post-comment-container">
                                        <form action="index.php" method="post">
                                        <input hidden type="text" id="bathroomId" name="bathroomId" value="'. $bathroom->getBathroomId() .'">
                                        <input hidden type="text" id="loggedUserId" name="loggedUserId" value="'. $_SESSION['userId'] .'">                            
                                        <input class="comment-input" type="text" name="comment" id="comment" placeholder="Add a comment..." required>
                                        <button class="comment-submit" id="submitComment" name="submitComment">Comment</button>
                                    </form>
                                </div>';
                        }

                        ?>
                        

                        <?php
                        
                        foreach($reviews as $review){
                            if($review->getBathroomId() == $bathroom->getBathroomId()){
                                echo '
                                    <div class="posted-comment">
                                        <strong class="commenter">'.$review->getUser()->getUsername().'</strong>
                                        <p class="comment-body">'.$review->getComment().'</p>
                                    </div>
                                ';
                            }
                        }
                        
                        ?>
                        
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