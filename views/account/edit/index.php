<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../../../vendor/autoload.php";
use Src\Exceptions\Infrastructure\UploadException;
use Src\Exceptions\Domain\EmailAlreadyExistsException;
use Src\Exceptions\Domain\InvalidEmailException;
use Src\Exceptions\Domain\InvalidPasswordException;
use Src\Models\User;
use Src\Models\Uploader;

$error = '';

$user = User::find($_SESSION['userId']);

if(isset($_SESSION['userId'])){
    $profilePicture = $_SESSION['profilePicture'] == null ? '../../resources/images/pfp-default.svg' : "../../../resources/users/{$_SESSION['profilePicture']}";
} else {
    header('Location: ../login/');
}  


if(isset($_POST['submit'])){
    $user->setEmail($_POST['email']);
    $user->setUsername(username: $_POST['name']);

    if(!empty($_FILES['image']['tmp_name'])){
        try{
            $savedImage = Uploader::uploadImage($_FILES['image']);
            if($user->getProfilePicture() != null){
                Uploader::deleteImage($user->getProfilePicture());
            }
            $user->setProfilePicture($savedImage);
            $user->save();

            $_SESSION['profilePicture'] = $user->getProfilePicture();
            header("Location: ../../list-bathrooms/");
        } catch(UploadException $e){
            $error = $e->getMessage();
        } catch(PDOException $e){
            $error = 'Sorry, it seems that one of the parameters passed is invalid.';
        } catch(InvalidEmailException $e) {
            $error = 'Invalid email!';
        } catch(InvalidPasswordException $e) {
            $error = 'Invalid password!';
        } catch(EmailAlreadyExistsException $e) {
            $error = 'This email is already registered. <a href="../login/">Log in</a>.';
        }
        
    } else {
        try{
            $user->save();

            //header("location: ../../list-bathrooms/");
        } catch(InvalidEmailException $e) {
            $error = 'Invalid email!';
        } catch(InvalidPasswordException $e) {
            $error = 'Invalid password!';
        } catch(EmailAlreadyExistsException $e) {
            $error = 'This email is already registered. <a href="../login/">Log in</a>.';
        }
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
            <a class="logout-button" href="../../../commands/logout.php">X Sair</a>
        </header>

        <main class="form-container">
            <div class="container-create-bathroom">
                <form class="create-bathroom-form" action="index.php" method="POST" enctype="multipart/form-data">
                    <img class="current-pfp" src="<?= $profilePicture ?>" alt="Profile picture"><br> <!-- A foto de perfil atual do usuário -->
                    <label for="image">Upload New Profile Picture</label><br>
                    <input type="file" id="image" name="image" accept="image/*"><br>
                    <?php
                    if ($error) {
                        echo "<span class='error'>{$error}</span>";
                    }
                    ?>
                    <label for="name">Username</label>
                    <input class="create-bathroom-input" type="text" name="name" id="name" value="<?= $user->getUsername() ?>" required>
                    <label for="password">E-mail</label>
                    <input class="create-bathroom-input" type="email" name="email" id="email" value="<?= $user->getEmail() ?>" required>
                    <button class="submit" name="submit">Apply Changes</button>
                </form>
            </div>
        </main>

    </div>
</body>
</html>