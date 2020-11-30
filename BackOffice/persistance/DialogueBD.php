<?php

require_once 'Connexion.php';

class DialogueBD
{
    public function getCountUtilisateur($log, $pas) {

        try
        {
            $conn = Connexion::getConnexion();
            $sql = 'SELECT COUNT(*) as "nombre" FROM admin WHERE LoginUtil=? AND PassUtil=?';
            $sth = $conn->prepare($sql);
            $sth->execute(array($log, $pas));
            $nb = $sth->fetchObject();
            return $nb;
        }
        catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getUtilisateur($log, $pas) {

        try
        {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM admin WHERE LoginUtil=? AND PassUtil=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($log, $pas));
            $utilisateur = $sth->fetchObject();
            return $utilisateur;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function ajoutBagel($id, $designation, $prix, $nomimage) {
        $ajoutOk = false;
        try {
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO bagel (id_bagel, designation, prix, nomimage) VALUE (?, ?, ?, ?)";
            $sthAjoutBagel = $conn->prepare($sql);
            $sthAjoutBagel->execute(array($id, $designation, $prix, $nomimage));

            // Variable drapeau indiquant le succès de l'ajout (indicateur booléen)
            $ajoutOk = true;
        } catch (Exception $e) {
            $msgErreur = $e->getMessage().'('.$e->getFile().',ligne'.$e->getLine().')';
        }
        return $ajoutOk;
    }
    public function getTousLesIngredients()
    {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM ingredient ORDER By id_ing";
            $sth = $conn->prepare($sql);
            $sth->execute();
            $ingredient = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $ingredient;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getBagels()
    {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM bagel ORDER By id_bagel";
            $sth = $conn->prepare($sql);
            $sth->execute();
            $ingredient = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $ingredient;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getMaxBagels()
    {
        try
        {
            $conn = Connexion::getConnexion();
            $sql = "SELECT MAX(id_bagel)as idmax FROM bagel";
            $sth = $conn->prepare($sql);
            $sth->execute();
            $max = $sth->fetchObject();
            return $max;
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
        }
    }
    public function ajoutCompo($idBag, $idIng) {
        $ajoutOk = false;
        try {
            $conn = Connexion::getConnexion();
            $sql = "INSERT INTO composition (id_bagel, id_ing) VALUE (?, ?)";
            $sthAjoutBagel = $conn->prepare($sql);
            $sthAjoutBagel->execute(array($idBag, $idIng));

            // Variable drapeau indiquant le succès de l'ajout (indicateur booléen)
            $ajoutOk = true;
        } catch (Exception $e) {
            $msgErreur = $e->getMessage().'('.$e->getFile().',ligne'.$e->getLine().')';
        }
        return $ajoutOk;
    }
    public function getNbIngredientParBagel($id)
    {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT COUNT(id_ing) AS NbIng FROM composition WHERE id_bagel=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
            $nb = $sth->fetchObject();
            return $nb;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function updateBagel($desiBagel, $prixBagel, $idBagel) {
        $ajoutOk = false;
        try {
            $conn = Connexion::getConnexion();
            $sql = "UPDATE bagel SET designation=?, prix=? WHERE id_bagel=?";
            $sthAjoutBagel = $conn->prepare($sql);
            $sthAjoutBagel->execute(array($desiBagel, $prixBagel, $idBagel));

            // Variable drapeau indiquant le succès de l'ajout (indicateur booléen)
            $ajoutOk = true;
        } catch (Exception $e) {
            $msgErreur = $e->getMessage().'('.$e->getFile().',ligne'.$e->getLine().')';
        }
        return $ajoutOk;
    }
    public function getInfoBagelViaId($idBag)
    {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM bagel WHERE id_bagel=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idBag));
            $info = $sth->fetchObject();
            return $info;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getInfoBagelViaId1($idBag)
    {
        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM bagel WHERE id_bagel=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($idBag));
            $info = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $info;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function suppCompo($suppCompo)
    {
        $suppOk = false;
        try {
            $conn = Connexion::getConnexion();
            $sql = "DELETE FROM composition WHERE id_bagel=?";
            $sthSuppCompo = $conn->prepare($sql);
            $sthSuppCompo->execute(array($suppCompo));

            // Variable drapeau indiquant le succès de l'ajout (indicateur booléen)
            $ajoutOk = true;
        } catch (Exception $e) {
            $msgErreur = $e->getMessage() . '(' . $e->getFile() . ',ligne' . $e->getLine() . ')';
        }
        return $suppOk;
    }
    public function suppBagel($suppBagel)
    {
        $suppOk = false;
        try {
            $conn = Connexion::getConnexion();
            $sql = "DELETE FROM bagel WHERE id_bagel=?";
            $sthSuppCompo = $conn->prepare($sql);
            $sthSuppCompo->execute(array($suppBagel));

            // Variable drapeau indiquant le succès de l'ajout (indicateur booléen)
            $ajoutOk = true;
        } catch (Exception $e) {
            $msgErreur = $e->getMessage() . '(' . $e->getFile() . ',ligne' . $e->getLine() . ')';
        }
        return $suppOk;
    }
    public function getDates() {

        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT DISTINCT date_commande FROM commande";
            $sth = $conn->prepare($sql);
            $sth->execute();
            $dates = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $dates;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getCommandeViaDate($date) {

        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM commande WHERE date_commande=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($date));
            $id = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $id;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getClientCommande($id) {

        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT nom, prenom FROM client CL join commande C on CL.id_client = C.id_client WHERE c.id_commande=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
            $client = $sth->fetchObject();
            return $client;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getInfoCommande($id) {

        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT * FROM ligne_de_commande WHERE id_commande=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
            $idB = $sth->fetchObject();
            return $idB;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    public function getPrixCommande($id) {

        try {
            $conn = Connexion::getConnexion();
            $sql = "SELECT SUM(prix*quantite) AS Prix FROM ligne_de_commande LC join bagel B on LC.id_bagel = B.id_bagel WHERE LC.id_commande=?";
            $sth = $conn->prepare($sql);
            $sth->execute(array($id));
            $prix = $sth->fetchObject();
            return $prix;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
}
