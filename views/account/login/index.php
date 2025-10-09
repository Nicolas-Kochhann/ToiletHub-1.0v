<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub - Log in</title>
    <link rel="stylesheet" href="../../styles/formStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <form class="big-form" action="login.php" method="POST">
                <h1 class="form-title">Log in</h1>
                <label>E-mail
                    <input type="email" name="email" id="email" required>
                </label>
                <label>Password
                    <input type="password" name="password" id="password" required>
                </label>
                <button class="submit">Log in</button>
                <p>Don't have an account? <strong><a href="../signup/">Sign up</a></strong></p>
            </form>
        </main>
    </div>
</body>
</html>