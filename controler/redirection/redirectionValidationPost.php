<?php
    require_once "../../model/Post.php";

    $postToValidate = new Post();
    $postToValidate->setTitle($_POST['newPostTitle']);
    $postToValidate->setContent($_POST['tinymceNewPost']); // note : du coup, si prend les balises, changer code d'affichage : enlever nl2br !
    /*if (!$_POST['oui']) // régler la date si on a pas dit oui a "publier maintenant" sinon laisser la date par défaut
    {
        
    }
    if (!$_POST['jamais']) // régler la date d'expiration si on a pas choisi "ne jamais expirer", sinon laisser par défaut a null
    {
        
    }*/
    $validationPostManager = new PostManager();
    $validationPostManager->insert($postToValidate);
?>