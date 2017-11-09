<?php
    function afficherBillet($billet)
    {
        echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
        echo '<a class="bulle" href="../index.php?titre=' . str_replace(' ', '_', $billet->getTitre()) . '">';
        echo '<p>' . $billet->getTitre() . '<span class="float-right">Le ' . str_replace(' ', ', à ', $billet->getDateHeurePub()) . '</span></p>';
        echo '<p class="dernier">' . mb_substr($billet->getContenu(), 0, 300) . ' [...]' . '<br /><span class="float-right discret">cliquez pour afficher</span>' . '</p>';
        echo '</a>';
        echo '</article>';
        //echo '<hr class="col-xxl-6 col-xl-12 col-sm-12" />';
    }

    function afficherBillets($billets, $i, $n)
    {
        echo '<section class="row">';
        //echo '<p class="col-xxl-12 col-xl-12 col-sm-12">Les billets :</p>';
        while ($n>0 AND $i<count($billets))
        {
            afficherBillet($billets[$i]);
            $n--;
            $i++;
        }
        echo '</section>';
    }
?>