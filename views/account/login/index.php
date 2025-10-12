<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub - Log in</title>
    <link rel="stylesheet" href="../../styles/loginFormStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <form class="big-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h1 class="form-title">Log in</h1>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <button class="submit">Log in</button>
                <p>Don't have an account? <strong><a href="../signup/">Sign up</a></strong></p>
            </form>
        </main>
    </div>
    <script src="../../scripts/showPassword.js"></script>
</body>
</html>