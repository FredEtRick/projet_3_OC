<?php
    function afficherBilletComplet($billet)
    {
        echo '<section class="row">';
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p>' . $billet->getContenu() . '</p>';
            echo '</article>';
        }
        else
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>Billet expiré</p>';
            echo '</article>';
        }
        echo '</section>';
    }
?>