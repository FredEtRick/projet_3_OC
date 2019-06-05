<?php
    session_start(); // this way the admin keep beeing connect on all pages when he managed to connect

    echo "avant config";

    require_once('dbConfig.php');

    echo " - après config, avant controlers";

    try
    {
        require_once('controler/visitorControler.php');
        require_once('controler/adminControler.php');
        require_once('controler/connexionControler.php');
        require_once('controler/Router.php');
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    echo " - après controleurs, avant routeur";

    $router = new Router();

    $router->rout();