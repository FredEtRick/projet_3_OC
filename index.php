<?php
    session_start(); // this way the admin keep beeing connect on all pages when he managed to connect
    //unset($_SESSION['action']);

    try // mettre les require dans le router !!!!
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

    $router = new Router();

    $router->rout();