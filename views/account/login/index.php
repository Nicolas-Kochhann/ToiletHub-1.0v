<?php
require_once "../../../vendor/autoload.php";
use Src\Models\User;

$error = '';

if(isset($_POST['button'])){
    if(User::authenticate($_POST['email'], $_POST['password'])){
        header("location: ../../list-bathrooms/index.php");
    }else{
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToiletHub</title>
    <link rel="icon" href="../../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../../styles/formStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <img class="fixed-logo" src="../../resources/images/toilethub_logo.png" alt="">
            <form class="big-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h1 class="form-title">Log in</h1>
                <?php
                    if ($error) {
                        echo "<span class='error'>{$error}</span>";
                    }
                ?>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <button class="submit" name="button">Log in</button>
                <p>Don't have an account? <strong><a href="../signup/">Sign up</a></strong></p>
            </form>
        </main>
    </div>
    <script src="../../scripts/showPassword.js"></script>
</body>
</html>