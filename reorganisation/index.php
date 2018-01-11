<?php
    try
    {
        $db = new PDO('mysql:host=localhost:8889;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        require_once('model/Post.php');
        require_once('model/Comment.php');
        require_once('model/User.php');
        require_once('controler/visitorControler.php');
        require_once('controler/adminControler.php');
        require_once('model/Rooter.php');
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $visitorControler = new VisitorControler();
    $adminControler = new AdminControler();
    $rooter = new Rooter();

    $rooter->root();