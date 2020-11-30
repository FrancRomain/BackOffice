<?php
session_start();
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    $null = null;
    $commandes = $undlg->getDates();

    if (isset($_POST['date'])) {
        $date = $_POST['date'];
        $info = $undlg->getCommandeViaDate($date);
    }

} catch (Exception $ex) {
    $erreur = $ex->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Best Bagel | Commande </title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/logo.jpg" />
    <link href="../css/scrolling-nav.css" rel="stylesheet">
</head>
<body id="page-top">
<?php
if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
?>
<form action="commande.php" method="post">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="accueil.php">Accueil</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="commande.php">Liste Commande</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="deconnexion.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="container text-center" >

        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Liste des Commandes</h2><br />
                <label for="champDate">Date de commande :</label>
                <select name="date" id="champDate">
                    <option value="">--choisissez une date--</option>
                    <?php
                    foreach ($commandes as $ligne) {
                        $dates = $ligne['date_commande'];
                        echo "<option value=$dates>$dates</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="validé">
                <br />
                <br />
                <?php
                if (isset($_POST['date'])) {
                    echo "<h3>Commande du $date</h3>";
                    echo "<table class='table'>";
                    echo "<thead class='bg-dark text-white'>";
                    echo "<tr>";
                    echo "<th scope='col'>Client</th>";
                    echo "<th scope='col'>Bagel</th>";
                    echo "<th scope='col'>Quantite</th>";
                    echo "<th scope='col'>Prix</th>";
                    echo "</tr>";
                    echo "</thead>";
                    foreach ($info as $ligne) {
                        $idC = $ligne['id_commande'];
                        $client = $undlg->getClientCommande($idC);
                        $nom = $client->nom;
                        $prenom = $client->prenom;
                        $infoC = $undlg->getInfoCommande($idC);
                        $idB = $infoC->id_bagel;
                        $quantite = $infoC->quantite;
                        $infoB = $undlg->getInfoBagelViaId($idB);
                        $desi = $infoB->designation;
                        $prixC = $undlg->getPrixCommande($idC);
                        $prix = $prixC->Prix;
                        echo "<tr>";
                        echo "<td>$nom $prenom</td>";
                        echo "<td>$desi</td>";
                        echo "<td>$quantite</td>";
                        echo "<td>$prix €</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</body>
</html>
