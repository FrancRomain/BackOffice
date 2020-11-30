<?php
session_start();
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    $idBagel = $_GET['num'];
    $bagel = $undlg->getInfoBagelViaId1($idBagel);

    foreach ($bagel as $ligne) {
        $id = $ligne['id_bagel'];
        $desi = $ligne['designation'];
        $prix = $ligne['prix'];
    }
    if (isset($_POST['prixB'])) {
        $prixBagel = $_POST['prixB'];
        $idBagel = $_POST['idB'];
        $desiBagel = $_POST['desiB'];

        $OK = $undlg->updateBagel($desiBagel, $prixBagel, $idBagel);
        header("location: accueil.php");
    }
} catch (Exception $ex) {
    $erreur = $ex->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Best Bagel | Modification d'un Bagel </title>
    <link rel="icon" href="../images/logo.jpg" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
    ?>
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
    <br />
    <form action="formModifBagel.php" method="post">
        <br />
        <section id="Liste" class="bg-light">
            <br />
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h1>Modification du Bagel | <?php echo"$desi"?></h1>
                        <table class="table">
                            <thead class="bg-dark text-white">
                            <tr>
                                <th scope="col">Nom du bagel</th>
                                <th scope="col">Prix</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <?php
                            echo "<tr>";
                            echo "<td><input type='text' name='desiB' placeholder='$desi'></td>";
                            echo "<input type='hidden' name='idB' value='$idBagel'>";
                            echo "<td><input type=\"text\" name=\"prixB\" id=\"champPrix\" placeholder='$prix' required></td>";
                            echo "<td><button type='submit' title='Modifier' name='' class=\"btn\"><i class=\"fa fa-edit\"></i></button></td>";
                            echo "</tr>";
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <?php
        if (isset($OK)) {
            if (($OK))
                echo "Ajout réussi : le prix a été modifié!";
        }
        ?>
        </div><br />
    </form>
    <?php
}
?>
</body>
</html>
