<?php
    session_start(); // this way the admin keep beeing connect on all pages when I managed to connect

    try
    {
        require_once('controler/visitorControler.php');
        require_once('controler/adminControler.php');
        require_once('controler/connexionControler.php');
        require_once('controler/Rooter.php');
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $rooter = new Rooter();

    $rooter->root();