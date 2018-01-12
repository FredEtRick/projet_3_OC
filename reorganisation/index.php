<?php
    try
    {
        require_once('controler/visitorControler.php');
        require_once('controler/adminControler.php');
        require_once('model/Rooter.php');
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $rooter = new Rooter();

    $rooter->root();