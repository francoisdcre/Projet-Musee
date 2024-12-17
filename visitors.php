<?php
    require 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiteurs</title>
    <link rel="shortcut icon" href="img/logomusee.png"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="css/notification.css" rel="stylesheet"/>
</head>
<body>
    <nav>
        <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo "<h1>Connecté en tant que : " . $_SESSION['username'] . "</h1><br>";
                echo "<img src='img/p2p.png' alt='Photo de profil de Vendeur'>";
                echo "<a href='dashboard.php'>Dashboard</a>";
                echo "<a href='php/logout.php'>Se déconnecter</a>";
                echo "<script src='./js/notification.js'></script>";
            } else {
                echo "<p>Vous n'êtes pas connecté.</p>";
                echo "<a href='index.php'>Se connecter</a>";
            }
        ?>
    </nav>
    <section id="clients">
        <h1>Visiteurs dans le musée</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Heure d'arrivée</th>
                    <th>Date</th>
                    <th>Exposition</th>
                    <th>Accès</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $bdd = dbconnect();
                $result = getVisitorsMuseum();
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['heurearrive'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['exposition'] . "</td>";
                    echo "<td>" . $row['acces'] . "</td>";
                    echo "<td><form method='POST' action='php/delete_item.php'><input type='hidden' name='id' value='" . $row['id'] . "'><button type='submit' class='delete' id='delete'>X</button></form></td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </section>
</body>
</html>
