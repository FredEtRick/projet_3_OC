<section class="row">
    <?php
        while ($postsLeft>0 AND $indicePost<count($allPosts))
        {
    ?>
            <article class="col-xxl-6 col-xl-12 col-sm-12">
                <a class="bulle" href="../index.php?titre=<?= $postsTitlesForLinks[$indicePost] ?>">
                    <p>
                        <?= $postsTitles[$indicePost] ?><span class="float-right">Le <?= $postsDatesTimes[$indicePost] ?></span>
                    </p>
                    <p class="dernier">
                        <?= $postsContentsBegining[$indicePost] ?> [...]<br /><span class="float-right discret">cliquez pour afficher</span>
                    </p>
                </a>
            </article>
    <?php
            $postsLeft--;
            $indicePost++;
        }
    ?>
    <article class="col-xxl-12 col-xl-12 col-sm-12 navPages">
        <p>
        <?php
            $page = 1+ceil($indiceBegining / $postsPerPage);
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
                elseif ($j>0 AND ($postsPerPage*($j-1))<count($billets))
                {
                    echo '<a href="index.php?page=' . $j . '">' . $j . '</a>';
                }
            }
            $pageMax = ceil(count($billets)/$postsPerPage);
            if ($page < $pageMax-3)
            {
                echo '... ';
            }
            if ($page < $pageMax-2)
            {
                echo '<a href="index.php?page=' . $pageMax . '">' . $pageMax . '</a>';
            }
            if ($indicePost < count($billets))
            {
                echo '<a href="index.php?page=' . ($page+1) . '" class="fa fa-chevron-right"></a>';
            }
        ?>
        </p>
    </article>
</section>