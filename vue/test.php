<?php
    function afficherBillet($billet)
    {
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p>' . $billet->getContenu() . '</p>';
        }
    }

    function afficherTousBillets($billets)
    {
        echo '<p>Voici la liste complète des billets non expirés :</p>';
        foreach($billets as $billet)
        {
            afficherBillet($billet);
        }
    }
?>