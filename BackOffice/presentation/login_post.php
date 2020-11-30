<?php
session_start();  // démarrage d'une session
require_once '../persistance/DialogueBD.php';
try {
    // on crée un objet référant la classe DialogueBD
    $undlg = new DialogueBD();
    // on vérifie que les données reçues du formulaire sont presents (connexion)
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $login = $_POST['user'];
        $mdp = $_POST['pass'];
        // on appelle la fonction getCountUtilisateur($login, $mdp) pour vérifier que cet utilisateur existe dans la BD
        $result = $undlg->getCountUtilisateur($login, $mdp);
        $nb = $result->nombre;
        if ($nb == 1) {
            // l'utilisateur existe dans la table, et on va le chercher pour nos variables de session
            $util = $undlg->getUtilisateur($login, $mdp);
            $nom = $util->NomUtil;
            $prenom = $util->PrenomUtil;
            // on mémorise le login et mdp dans 2 variables de session
            $_SESSION['user'] = $login;
            $_SESSION['pass'] = $mdp;

            // cette variable drapeau indiquera que l'authentification a réussi
            $authOK = true;
        }
    }
} catch (Exception $e) {
    $erreur = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/yes.css" />
    <link rel="icon" href="../images/logo.jpg" />
    <title>Best Bagel | Résultat authentification</title>
</head>
<body>
<h1>Résultat de l'authentification</h1>
<h2>
    <?php
    if (isset($authOK)) {
        echo "Vous avez été reconnu(e) $prenom  $nom<br />";
        echo '<a class="btn-1-2" href="accueil.php">Bienvenue</a>';
    } else {
        echo "Vous n'avez pas été reconnu(e)<br />";
        echo '<a class="btn-1-2" href="../index.html">Réessayer</a>';
    }
    ?></h2>
</body>
</html>
