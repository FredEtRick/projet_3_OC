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

    $admin = false;

    $requete = $bdd->query('SELECT mdp FROM Utilisateur WHERE login = "auteur"');

    if (isset ($_SESSION['login']) && isset ($_SESSION['mdp']) && ($_SESSION['login'] == 'auteur') && ($_SESSION['mdp'] == $requete->fetch()['mdp']))
    {
        $admin = true;
    }

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
        $lesUtilisateurs = $utilisateurManager->recupererTous();
        /*création du tout premier compte, avec mdp haché
        $utilisateur = new Utilisateur('auteur', sha1('gzOC@0603'));
        $utilisateurManager->inserer($utilisateur);*/
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/controleur/routeur.php';
        $routeur = new Routeur();
        $routeur->router($lesBillets, $commentaireManager, $lesCommentaires, $lesUtilisateurs, $admin);
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