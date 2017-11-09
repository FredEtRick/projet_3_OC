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

    $leBillet = null;
    if(isset($_GET['titre']))
    {
        foreach($lesBillets as $billet)
        {
            if (strip_tags($_GET['titre']) == str_replace(' ', '_', $billet->getTitre()))
            {
                $leBillet = $billet;
            }
        }
    }

    if(isset($_GET['titre']) AND ($leBillet != null))
    {
        try
        {
            require $_SERVER['DOCUMENT_ROOT'] . '/vue/billetVue.php';
        }
        catch (Exception $e)
        {
            echo '<p>erreur : ' . $e->getMessage() ; '</p>';
        } 
        afficherBilletComplet($leBillet);
    }
    
    elseif(isset($_GET['page']) AND is_numeric($_GET['page']) AND $_GET['page'] <= (ceil(count($lesBillets) / 5)))
    {
        try
        {
            require $_SERVER['DOCUMENT_ROOT'] . '/vue/afficherBillets.php';
        }
        catch (Exception $e)
        {
            echo '<p>erreur : ' . $e->getMessage() ; '</p>';
        }
        afficherBillets($lesBillets, (5 * ((int) strip_tags($_GET['page']) - 1)), 5);
    }

    else
    {
        try
        {
            require $_SERVER['DOCUMENT_ROOT'] . '/vue/afficherBillets.php';
        }
        catch (Exception $e)
        {
            echo '<p>erreur : ' . $e->getMessage() ; '</p>';
        }
        afficherBillets($lesBillets, 0, 5);
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