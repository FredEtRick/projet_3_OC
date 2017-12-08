<?php
    function afficherBillet($billet)
    {
        echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
        echo '<a class="bulle" href="../index.php?titre=' . str_replace(' ', '_', $billet->getTitre()) . '">';
        echo '<p>' . $billet->getTitre() . '<span class="float-right">Le ' . str_replace(' ', ', à ', $billet->getDateHeurePub()) . '</span></p>';
        echo '<p class="dernier">' . mb_substr($billet->getContenu(), 0, 300) . ' [...]' . '<br /><span class="float-right discret">cliquez pour afficher</span>' . '</p>';
        if ($admin)
        {
            // proposer de modifier etc
        }
        echo '</a>';
        echo '</article>';
        //echo '<hr class="col-xxl-6 col-xl-12 col-sm-12" />';
    }

    function afficherBillets($billets, $i, $n)
    {
        $idep = $i;
        $ndep = $n;
        echo '<section class="row">';
        //echo '<p class="col-xxl-12 col-xl-12 col-sm-12">Les billets :</p>';
        while ($n>0 AND $i<count($billets))
        {
            afficherBillet($billets[$i]);
            $n--;
            $i++;
        }
        echo '<article class="col-xxl-12 col-xl-12 col-sm-12 navPages">';
        echo '<p>';
        $page = 1+ceil($idep / $ndep);
        if ($page > 1)
        {
            echo '<a class="fa fa-chevron-left" href="index.php?page=' . ($page-1) . '"></a>';
        }
        if ($page > 3)
        {
            echo '<a href="index.php?page=1">1</a>';
        }
        if ($page > 4)
        {
            echo '... ';
        }
        for ($j=($page-2) ; $j<($page+3) ; $j++)
        {
            if ($j>0 AND $j==$page)
            {
                echo '<span class="pageActuelle">' . $j . '</span>';
            }
            elseif ($j>0 AND ($ndep*($j-1))<count($billets))
            {
                echo '<a href="index.php?page=' . $j . '">' . $j . '</a>';
            }
        }
        $pageMax = ceil(count($billets)/$ndep);
        if ($page < $pageMax-3)
        {
            echo '... ';
        }
        if ($page < $pageMax-2)
        {
            echo '<a href="index.php?page=' . $pageMax . '">' . $pageMax . '</a>';
        }
        if ($i < count($billets))
        {
            echo '<a href="index.php?page=' . ($page+1) . '" class="fa fa-chevron-right"></a>';
        }
        echo '</p>';
        echo '</article>';
        echo '</section>';
    }
?>