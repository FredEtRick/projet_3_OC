<?php
    function afficherBillet($billet)
    {
        // if () comparer la date d'exp a la date actuelle et afficher que si c'est bon
        echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
        echo '<p>' . $billet->getContenu() . '</p>';
    }

    function afficherTousBillets($billets)
    {
        echo '<p>Voici la liste complète des billets :</p>';
        foreach($billets as $billet)
        {
            afficherBillet($billet);
        }
    }
?>