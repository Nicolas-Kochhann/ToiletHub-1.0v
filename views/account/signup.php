<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restroomhub - Sign up</title>
    <link rel="stylesheet" href="../styles/formStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <form class="big-form" action="signup.php">
                <h1 class="form-title">Register</h1>
                <label>Username
                    <input type="text" name="username" id="username">
                </label>
                <label>E-mail
                    <input type="email" name="email" id="email">
                </label>
                <label>Password
                    <input type="password" name="password" id="password">
                </label>
                <button class="submit">Register</button>
                <p>Already have an account? <strong><a href="./login.php">Log in</a></strong></p>
            </form>
        </main>
    </div>
</body>
</html>