    <?php
        while ($postsLeft>0 AND $indexPost<count($allPosts))
        {
    ?>
            <article class="col-xxl-6 col-xl-12 col-sm-12">
                <div class="bulle" href="../index.php?title=<?= $allPosts[$indexPost]['titleForLink'] ?>&amp;action=onePost">
                    <p>
                        <?= $allPosts[$indexPost]['title'] ?><span class="float-right">Le <?= $allPosts[$indexPost]['dateTime'] ?></span>
                    </p>
                    <p class="dernier">
                        <?= strip_tags($allPosts[$indexPost]['contentBegin']) ?> [...]<!--<br /><span class="float-right discret">cliquez pour afficher</span>-->
                    </p>
                    <p>
                        <button onclick="hideOrShow('<?= $allPosts[$indexPost]['title'] ?>')">afficher / masquer contenu complet</button>
                        <button onclick="removePost('<?= $allPosts[$indexPost]['title'] ?>', <?= $page ?>)">retirer le billet</button>
                        <button onclick="modifyPost('<?= $allPosts[$indexPost]['title'] ?>')">modifier le billet</button>
                    </p>
                    <p class="postContentHidden" id="<?= $allPosts[$indexPost]['title'] ?>">
                        <?= strip_tags($allPosts[$indexPost]['content']) ?>
                    </p>
                </div>
            </article>
    <?php
            $postsLeft--;
            $indexPost++;
        }
    ?>
    <article class="col-xxl-12 col-xl-12 col-sm-12 navPages">
        <p>
        <?php
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
                elseif ($j>0 AND ($postsPerPages*($j-1))<count($allPosts))
                {
                    echo '<a href="index.php?page=' . $j . '">' . $j . '</a>';
                }
            }
            $pageMax = ceil(count($allPosts)/$postsPerPages);
            if ($page < $pageMax-3)
            {
                echo '... ';
            }
            if ($page < $pageMax-2)
            {
                echo '<a href="index.php?page=' . $pageMax . '">' . $pageMax . '</a>';
            }
            if ($indexPost < count($allPosts))
            {
                echo '<a href="index.php?page=' . ($page+1) . '" class="fa fa-chevron-right"></a>';
            }
        ?>
        </p>
    </article>
    <article class="col-xxl-6 col-xl-12 col-sm-12">
        <p class="centrer">
            <button onclick="showAllDeletedPosts()">consulter les billets retirés</button>
        </p>
    </article>