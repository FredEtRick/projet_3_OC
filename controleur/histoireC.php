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

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/afficherBillets.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $billetManager = new BilletManager($bdd);

    /*$ch1 = $billetManager->recuperer('chapitre 1');
    $ch2 = $billetManager->recuperer('Second chapitre.');

    afficherBillet($ch1);
    afficherBillet($ch2);*/

    $lesBillets = $billetManager->recupererTous();

    afficherBillets($lesBillets, 0, 5);

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/pied.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }
?>