<?php
    echo $_SERVER["PHP_SELF"];

    require 'modele/Billet.php';

    echo 'testee';

    $billet = new Billet;
    $billet2 = new Billet('un titre !', 'un contenu');
    echo $billet2->getTitre() . '<br />' . $billet2.getContenu();
?>