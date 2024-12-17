<?php
require 'functions.php';
session_start();

if (isset($_POST['username'], $_POST['password'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)) {
        $bdd = dbconnect();
        $query = "SELECT * FROM employee WHERE username = :username";
        $result = $bdd->prepare($query);
        $result->execute(array(':username' => $username));
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['message'] = "<script>const popup = Notification();popup.success({title: 'Succès',message: 'Connexion réussie.',});</script>";
                header("Location: ../dashboard.php");
                exit();
            } else {
                $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Utilisateur ou mot de passe incorrect.',});</script>";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Utilisateur ou mot de passe incorrect.',});</script>";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Veuillez saisir tous les champs.',});</script>";
        header("Location: ../index.php");
        exit();
    }
}