<?php
    echo $_SERVER["PHP_SELF"];

    echo '<br />' . $_SERVER['DOCUMENT_ROOT'] . '/modele/Billet.php';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/modele/Billet.php'))
        echo '<br />existe';

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Billet.php';
    }
    catch (Exception $e)
    {
        echo '<br />erreur : ' . $e->getMessage() ; '<br />';
    }

    echo 'testee';

    $billetManager = new BilletManager();
    $billet = $billetManager->recuperer('chapitre 1');
    echo $billet->getTitre() . '<br />' . $billet.getContenu();

    /*$billet = new Billet('un titre !', , , 'un contenu');
    echo $billet2->getTitre() . '<br />' . $billet2.getContenu();*/
?>