<?php
session_start();
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    //Requêtes pour avoir les ingrédients et les bagels
    $lesIngredients = $undlg->getTousLesIngredients();
    $lesBag = $undlg->getBagels();

    // Requête pour avoir le dernier id (numéro) de bagel créé dans la table bagel
    $idB = $undlg->getMaxBagels();
    $idBagel = $idB->idmax;
    // on ajoute 1 au dernier id des bagels
    $idBagel = $idBagel + 1;

    // on vérifie s'il existe un nom et un prix - c'est donc qu'on a validé un ajout bagel
    if (isset($_POST['nomB']) && isset($_POST['prixB'])) {
        $nom = $_POST['nomB'];
        $prixBagel = $_POST['prixB'];
        $idBag = $_POST['idBag'];
        $nomimage = $_POST['nomimage'];

        // Ajout du nouveau bagel
        $undlg->ajoutBagel($idBagel, $nom, $prixBagel, $nomimage);

        // Ajout des ingrédients que l'on a coché (variable postée not empty) - on ajoute une ligne dans composition pour chaque ingrédient
        foreach ($lesIngredients as $unIng) {
            if (!empty($_POST[$unIng['id_ing']])) {
                $ok = $undlg->ajoutCompo($idBag, $_POST[$unIng['id_ing']]);
                header("location: accueil.php");  // redirection vers la liste des bagels
            }
        }
    }

} catch (Exception $ex) {
    $erreur = $ex->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Best Bagel | Ajout d'un Bagel </title>
    <link rel="icon" href="../images/logo.jpg" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" media="screen">
</head>
<body>
<?php
if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
    ?>
    <form action="formAjoutBagel.php" method="post">
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
                            <a class="nav-link js-scroll-trigger" href="deconnexion.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <input type="hidden" name="idBag" value="<?php echo "$idBagel"; ?>" required /><br /><br /><br />
                    <h1 style="text-align: center">Ajoutez un Bagel</h1>
                    <div class="col-md-3">
                        <label  for="champNom">Entrez le nom d'un Bagel : </label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="nomB" id="champNom" required>
                    </div>
                    <br /><br />

                    <div class="col-md-2">
                        <label  for="champPrix">Entrez le prix : </label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="prixB" id="champPrix" required>
                    </div>
                    <br /><br />

                    <div class="col-md-3">
                        <label  for="champImg">Entrez le nom de l'image : </label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="nomimage" id="champImg" required>
                    </div>
                    <br /><br />

                    <div class="col-md-4">
                        <label for="champNom">Séléctionnez les ingrédients : </label>
                    </div>
                    <div class="col-md-6">
                        <?php
                        foreach ($lesIngredients as $unIng) {
                            $nomIng = $unIng['nom'];
                            $idIng = $unIng['id_ing'];
                            echo "<input type='checkbox' name=".$unIng['id_ing']." value=$idIng /> $nomIng";
                            echo "<br />";
                        }
                        ?>
                        <br />
                        <div class="bloc2 col-md-5">
                            <input type="submit" value="Ajouter">
                        </div>
                        <?php
                        if (isset($OK) && isset($ok)) {
                            if (($OK) && ($ok))
                                echo "Ajout réussi : le bagel a été ajouté!";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}
?>
</body>
</html>