<?php
session_start();
require_once '../persistance/dialogueBD.php';
try {
    $undlg = new DialogueBD();
    $idBagel = $_GET['num'];
    $suppCompo = $undlg->suppCompo($idBagel);
    $suppBagel = $undlg->suppBagel($idBagel);
    header("location: accueil.php");
} catch (Exception $ex) {
    $erreur = $ex->getMessage();
}
?>
