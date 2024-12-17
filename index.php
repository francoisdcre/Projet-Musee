<?php
    require 'php/login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Musée d'Annecy</title>
    <link rel="shortcut icon" href="img/logomusee.png"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="css/notification.css" rel="stylesheet"/>
</head>
<body>
    <script src='./js/notification.js'></script>
    <?php
        if (isset($_SESSION['username'])) {
            echo "Vous êtes connecté en tant que " . $_SESSION['username'] . ".<br>";
            echo "<a href='php/logout.php'>Se déconnecter</a>";
        } else {
            echo "  <section id='connexion'>
                        <div class='hero'>
                            <img src='img/login.jpg' alt='image pour le login'>
                            <form action='php/login.php' method='post' class='login'>
                                <h1>Connexion vendeurs</h1>
                                <input type='text' name='username' id='login' placeholder='Identifiant' required>
                                <input type='password' name='password' id='password' placeholder='Mot de passe' required>
                                <input type='submit' value='CONNEXION' id='button'>
                            </form>
                        </div>
                    </section>";
        }
        if(isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            echo $message;
            exit();
        }
    ?>
</body>
</html>
