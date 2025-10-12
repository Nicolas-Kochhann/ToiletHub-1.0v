<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub - Sign up</title>
    <link rel="stylesheet" href="../../styles/loginFormStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <form class="big-form" action="signup.php" method="POST">
                <h1 class="form-title">Register</h1>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <button class="submit">Register</button>
                <p>Already have an account? <strong><a href="../login/">Log in</a></strong></p>
            </form>
        </main>
    </div>
    <script src="../../scripts/showPassword.js"></script>
</body>
</html>