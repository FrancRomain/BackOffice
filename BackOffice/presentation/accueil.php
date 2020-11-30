<?php
session_start();
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    //Requêtes pour avoir les ingrédients et les bagels
    $lesIngredients = $undlg->getTousLesIngredients();
    $lesBag = $undlg->getBagels();
} catch (Exception $ex) {
    $erreur = $ex->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Best Bagel | Accueil </title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/logo.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/scrolling-nav.css" rel="stylesheet">
</head>
<body id="page-top">
<?php
if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
?>
<form action="accueil.php" method="post">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Accueil</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">A propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#Liste">Liste Bagel</a>
                    </li>
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

    <header class="text-white" style="background-color: #f7b552">
        <div class="container text-center" >
            <h1>Bienvenue</h1>
            <h2>sur la page d'administration de Best Bagel</h2>
        </div>
    </header>

    <section id="about" class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2>A propos</h2>
                    <p class="lead">Cette page a pour but de permettre au(x) responsable(s) de la société de mettre à jour les informations des bagels comme par exemple :</p>
                    <ul>
                        <li>Ajouter un nouveau bagel</li>
                        <li>Modifier les informations d'un bagel</li>
                        <li>Supprimer un bagel</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="Liste" class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2>Liste des Bagels</h2><br />
                    <table class="table">
                        <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom du bagel</th>
                            <th scope="col">Ingrédients</th>
                            <th scope="col">Prix</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <?php
                        foreach ($lesBag as $ligne) {
                            $id = $ligne['id_bagel'];
                            $desi = $ligne['designation'];
                            $prix = $ligne['prix'];
                            $nb = $undlg->getNbIngredientParBagel($id);
                            $nbing = $nb->NbIng;
                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$desi</td>";
                            echo "<td>$nbing</td>";
                            echo "<td>$prix €</td>";
                            echo "<td><a href='formModifBagel.php?num=$id' <button type='submit' title='Modifier' name='' class=\"btn\"><i class=\"fa fa-edit\"></i></button></a>
                              <a href='formSuppBagel.php?num=$id' <button style='color: red' title='Supprimer' name='' class=\"btn\"><i class=\"fa fa-close\"></i></button></td></a>";
                            echo "</tr>";
                        }
                        echo "</form>";
                        echo "<form action=\"formAjoutBagel.php\" method=\"post\">";
                        echo "<tr>";
                        echo "<td><input href='formAjoutBagel.php' type=\"submit\" value=\"Ajouter un Bagel ?\"></td><td></td><td></td><td></td><td></td>";
                        echo "</tr>";
                        echo "</form>";
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <?php
    }
    ?>
</body>
</html>
