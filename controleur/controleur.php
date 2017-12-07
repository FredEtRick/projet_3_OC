<?php
    $bdd = new PDO('mysql:host=localhost:8889;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/enTete.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    enTete('Billet simple pour l\'Alaska');

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Billet.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $billetManager = new BilletManager($bdd);
    $lesBillets = $billetManager->recupererTousSaufExp();

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Commentaire.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $commentaireManager = new CommentaireManager($bdd);
    $lesCommentaires = [];

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Utilisateur.php';
        $utilisateurManager = new UtilisateurManager($bdd);
        $lesBillets = $billetManager->recupererTous();
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/controleur/routeur.php';
        $routeur = new Routeur();
        $routeur->router($lesBillets, $commentaireManager, $lesCommentaires);
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/pied.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }
?>