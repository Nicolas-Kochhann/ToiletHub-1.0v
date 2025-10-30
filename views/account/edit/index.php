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
    <link rel="stylesheet" href="../../styles/createBathroomStyle.css">
</head>
<body>
    <div class="container">

        <header>
            <div class="logo-container"></div>
            <?php

            if (isset($_SESSION["userId"])) {
                echo "<a class='link-create-bathroom' href='../../list-bathrooms'>< Go Back</a>";
            } else {
                header("Location: ../login");
            }

            ?>
            <a class="logout-button" href="">X Sair</a>
        </header>

        <main class="form-container">
            <div class="container-create-bathroom">
                <form class="create-bathroom-form" action="" method="POST" enctype="multipart/form-data">
                    <img class="current-pfp" src="../../resources/images/placeholders/brazilian-bathroom.png" alt=""><br> <!-- A foto de perfil atual do usuário -->
                    <label for="image">Upload New Profile Picture</label><br>
                    <input type="file" id="image" name="image" accept="image/*"><br>
                    <label for="name">Username</label>
                    <input class="create-bathroom-input" type="text" name="name" id="name" value="">
                    <label for="password">Password</label>
                    <input class="create-bathroom-input" type="password" name="name" id="name" value="">
                    <button class="submit">Apply Changes</button>
                </form>
            </div>
        </main>

    </div>
</body>
</html>