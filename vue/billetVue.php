<?php
    function afficherBilletComplet($billet)
    {
        echo '<section class="row">';
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            $longueurTexte = mb_strlen($billet->getContenu());
            //$pages = array(); // TODO : créer des blocs de (3000 ?) caractères par pages puis afficher les pages avec les classes ci dessous !!! créer un système de pages comme a la page d'accueil ? Ou mettre les pages les unes sous les autres ? Autre idée : ajouter <span> au debut, </span><span class="mobile"> tous les 750, </span>. ou alors js
            echo '<article class="col-xxl-12 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<div class="row" id="parent">';
            echo '<div class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p id="contenu"></p>';
            // pagination
            echo '<p id="reduire"></p><p id="rallonger"></p>';
            echo '</div>';
            echo '</div>';
            echo '</article>';
        }
        else
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>Billet expiré</p>';
            echo '</article>';
        }
        echo '</section>';
        $avecSauts = htmlspecialchars($billet->getContenu());
        $avecSauts = nl2br($avecSauts);
        $avecSauts = str_replace(array("\r", "\n"), array('', ''), $avecSauts);
        //afficherCommentaires($billet);
        try
        {
            require $_SERVER['DOCUMENT_ROOT'] . '/vue/adaptationFenetre.php';
        }
        catch (Exception $e)
        {
            echo '<p>erreur : ' . $e->getMessage() ; '</p>';
        }
    }
    function afficherCommentaires($lesCommentaires)
    {
        echo '<section class="row">';
        foreach($lesCommentaires as $commentaire)
        {
            echo '<div class="hidden-xl-down col-xxl-3"></div>';
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12 bulle">';
            echo '<p>' . $commentaire->getPseudoVisiteur() . '<span class="float-right">Le ' . str_replace(' ', ', à ', $commentaire->getDateHeure()) . '</span></p>';
            echo '<p class="dernier">' . $commentaire->getContenu() . '</p>';
            echo '</article>';
        }
        echo '</section>';
    }
?>