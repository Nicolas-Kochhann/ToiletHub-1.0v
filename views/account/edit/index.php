<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../../../vendor/autoload.php";
use Src\Exceptions\Domain\EmailAlreadyExistsException;
use Src\Exceptions\Domain\InvalidEmailException;
use Src\Exceptions\Domain\InvalidPasswordException;
use Src\Models\User;

$error = '';

$user = User::find($_SESSION['userId']);

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
    <title>ToiletHub</title>
    <link rel="icon" href="../resources/images/shiba_icon.ico">
    <link rel="stylesheet" href="../../styles/listStyle.css">
</head>
<body>
    <div class="container">

        <header>
            <img src="" alt="logo">
            <?php

                if (isset($_SESSION["userId"])) {
                    echo "<a class='link-create-bathroom' href=''>+ Create Bathroom</a>";
                } else {
                    echo "<a class='link-create-bathroom' href='../account/login'>+ Log in or Create Account</a>";
                }

            ?>
            <div class="profile-container">
                <a class="link-profile" href="">
                    <img class="image-profile" src="../../resources/images/pfp-default.svg" alt="pfp">
                </a>
            </div>
        </header>

        <main>
            <div class="edit-account-form-container">
                <form class="big-form" action="index.php" method="POST">
                    <h1 class="form-title">Register</h1>
                    <div class="error"><?php echo $error; ?></div>
                    <label for="profilePicture"><img class="edit-account-form-profile-picture" src="<?php echo $user->getProfilePicture() ?? '../../resources/images/pfp-default.svg' ?>" alt="profile picture"></label>
                    <input type="file" name="profilePicture" id="profilePicture" hidden>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>
                    <button class="submit" name="button">Save Changes</button>
                    <p>Already have an account? <strong><a href="../login/">Log in</a></strong></p>
                </form>
            </div>
        </main>

    </div>
</body>
</html>