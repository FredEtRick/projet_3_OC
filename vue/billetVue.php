<?php
    function afficherBilletComplet($billet)
    {
        echo '<section class="row">';
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            $longueurTexte = mb_strlen($billet->getContenu());
            //$pages = array(); // TODO : créer des blocs de (3000 ?) caractères par pages puis afficher les pages avec les classes ci dessous !!! créer un système de pages comme a la page d'accueil ? Ou mettre les pages les unes sous les autres ? Autre idée : ajouter <span> au debut, </span><span class="mobile"> tous les 750, </span>. ou alors js
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p id="contenu"></p>';
            // pagination
            echo '<p id="reduire"></p><p id="rallonger"></p>';
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
    /*function afficherCommentaires($billet)
    {
        // TODO : ramasser tous les commentaires relatif au billet dans un tableau
        echo '<section class="row">';
        // TODO : afficher les commentaires (avec appel d'une autre fonction peut être)
        echo '</section>';
    }*/
?>