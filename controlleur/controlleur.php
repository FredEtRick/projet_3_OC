<?php
    $bdd = new PDO('mysql:host=localhost:8889;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Billet.php';
    }
    catch (Exception $e)
    {
        echo '<br />erreur : ' . $e->getMessage() ; '<br />';
    }

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/test.php';
    }
    catch (Exception $e)
    {
        echo '<br />erreur : ' . $e->getMessage() ; '<br />';
    }

    $billetManager = new BilletManager($bdd);

    /*$ch1 = $billetManager->recuperer('chapitre 1');
    $ch2 = $billetManager->recuperer('Second chapitre.');

    afficherBillet($ch1);
    afficherBillet($ch2);*/

    $lesBillets = $billetManager->recupererTous();

    afficherTousBillets($lesBillets);
?>