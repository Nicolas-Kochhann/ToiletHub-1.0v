<?php
require_once "../../../vendor/autoload.php";
use Src\Exceptions\Domain\EmailAlreadyExistsException;
use Src\Exceptions\Domain\InvalidEmailException;
use Src\Exceptions\Domain\InvalidPasswordException;
use Src\Models\User;

$error = '';

if(isset($_POST['button'])){
    $u = new User($_POST['email'], $_POST['username']);
    $u->setPassword($_POST['password']);

        try{
            $u->save();
            header("location: ../login/index.php");
        } catch(InvalidEmailException $e) {
            $error = 'Invalid email!';
        } catch(InvalidPasswordException $e) {
            $error = 'Invalid password!';
        } catch(EmailAlreadyExistsException $e) {
            $error = 'This email is already registered. <a href="../login/">Log in</a>.';
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bathroomhub - Sign up</title>
    <link rel="icon" href="../../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../../styles/loginStyle.css">
</head>
<body>
    <div class="container">
        <main class="form-container">
            <form class="big-form" action="index.php" method="POST">
                <h1 class="form-title">Register</h1>
                <div class="error"><?php echo $error; ?></div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <button class="submit" name="button">Register</button>
                <p>Already have an account? <strong><a href="../login/">Log in</a></strong></p>
            </form>
        </main>
    </div>
    <script src="../../scripts/showPassword.js"></script>
</body>
</html>