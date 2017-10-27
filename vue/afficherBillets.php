<?php
    function afficherBillet($billet)
    {
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p>' . mb_substr($billet->getContenu(), 0, 250) . ' [...]</p>';
            echo '</article>';
            return true;
        }
        return false;
    }

    function afficherBillets($billets, $i, $n)
    {
        echo '<section class="row">';
        //echo '<p class="col-xxl-12 col-xl-12 col-sm-12">Les billets :</p>';
        while ($n>0 AND $i<count($billets))
        {
            if (afficherBillet($billets[$i]))
                $n--;
            $i++;
        }
        echo '</section>';
    }
?>