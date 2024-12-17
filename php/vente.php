<?php
require 'functions.php';
session_start();

if (compteur() == "50/50") {
    $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Le nombre maximal de visiteur est atteint.',});</script>";
    header("Location: ../dashboard.php");
    exit();
}

if (isset($_POST['sexe'], $_POST['age'], $_POST['postal'], $_POST['pays'], $_POST['access'], $_POST['exposition'])) {
    $sexe = $_POST['sexe'];
    $age = $_POST['age'];
    $postal = $_POST['postal'];
    $pays = $_POST['pays'];
    $heurearrive = date("H:i:s", strtotime('+2 hours'));
    $date = date("Y-m-d");
    $access = $_POST['access'];
    $exposition = $_POST['exposition'];

    if (!empty($sexe) && !empty($age) && !empty($postal) && !empty($pays) && !empty($access) && !empty($exposition)){
        try {
            $bdd = new PDO('mysql:host=localhost; dbname=MUSEE; charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
            $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Erreur de connexion à la base de donnée.',});</script>";
            header("Location: ../dashboard.php");
            exit();
        }

        $query = "INSERT INTO visitors (sexe, age, postal, pays, heurearrive, date, exposition, acces) VALUES (:sexe, :age, :postal, :pays, :heurearrive, :date, :exposition, :access)";
        $result = $bdd->prepare($query);
        $result->execute(array(':sexe' => $sexe, ':age' => $age, ':postal' => $postal, ':pays' => $pays, ':heurearrive' => $heurearrive, ':date' => $date, ':access' => $access, ':exposition' => $exposition));

        $querry2 = "SELECT id FROM visitors WHERE heurearrive = :heurearrive AND date = :date AND age = :age AND sexe = :sexe AND exposition = :exposition AND acces = :access";
        $result2 = $bdd->prepare($querry2);
        $result2->execute(array(':heurearrive' => $heurearrive, ':date' => $date, ':age' => $age, ':sexe' => $sexe, ':exposition' => $exposition, ':access' => $access));
        foreach ($result2 as $row2) {
            $visitor_id = $row2['id'];
        }

        $querry = "SELECT id FROM typeacces where type = :access";
        $result3 = $bdd->prepare($querry);
        $result3->execute(array(':access' => $access));
        foreach ($result3 as $row3) {
            $idAcces = $row3['id'];
        }


        if ($idAcces == 3) {
            $querry = "SELECT * FROM expositions";
            $result3 = $bdd->prepare($querry);
            $result3->execute();
            foreach ($result3 as $row3) {
                $exposition_id = $row3['id'];
                $query2 = "INSERT INTO visitorsmuseum (visitor_id, exposition_id) VALUES (:visitor_id, :exposition_id)";
                $result2 = $bdd->prepare($query2);
                $result2->execute(array(':visitor_id' => $visitor_id, ':exposition_id' => $exposition_id));
            }
            header("Location: ../dashboard.php");
            exit();
        } else {
            $exposition_id = getExpoId();
            $query2 = "INSERT INTO visitorsmuseum (visitor_id, exposition_id) VALUES (:visitor_id, :exposition_id)";
            $result2 = $bdd->prepare($query2);
            $result2->execute(array(':visitor_id' => $visitor_id, ':exposition_id' => $exposition_id));
            $_SESSION['message'] = "<script>const popup = Notification();popup.success({title: 'Succès',message: 'Visiteur entré avec succès.',});</script>";
            header("Location: ../dashboard.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Veuillez remplir tous les champs.';
        $_SESSION['message'] = "<script>const popup = Notification();popup.error({title: 'Erreur',message: 'Veuillez remplir tous les champs.',});</scrip>";
        header("Location: ../dashboard.php");
        exit();
    }
}