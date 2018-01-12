<section class="row">
    <?php
        while ($n>0 AND $i<count($allPosts)) // commenter n et i
        {
            $post = $allPosts[$i];
            $postTitleForLink = str_replace(' ', '_', $post->getTitre()); // doit pas avoir de getTitre ! (changer getAllPosts direct dans Post.php)
            $postTitle = $post->getTitle();
            $dateDisplay = str_replace(' ', ', à ', $post->getDateTimePub());
            $contentBegining = mb_substr($post->getContent(), 0, 300);
    ?>
            <article class="col-xxl-6 col-xl-12 col-sm-12">
                <a class="bulle" href="../index.php?titre=<?= $postTitleForLink ?>">
                    <p>
                        <?= $postTitle ?><span class="float-right">Le <?= $dateDisplay ?></span>
                    </p>
                    <p class="dernier">
                        <?= contentBegining ?> [...]<br /><span class="float-right discret">cliquez pour afficher</span>
                    </p>
                </a>
            </article>
    <?php
            $n--;
            $i++;
        }
    ?>
    <article class="col-xxl-12 col-xl-12 col-sm-12 navPages">
        <p>
        <?php
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
        ?>
        </p>
    </article>
</section>