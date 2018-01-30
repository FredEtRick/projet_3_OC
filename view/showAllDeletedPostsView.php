    <?php
        foreach ($removedPosts as $removedPost)
        {
    ?>
            <article class="col-xxl-6 col-xl-12 col-sm-12">
                <div class="bulle" href="../index.php?title=<?= $removedPost['titleForLink'] ?>&amp;action=onePost">
                    <p>
                        <?= $removedPost['title'] ?><span class="float-right">Le <?= $removedPost['dateTime'] ?></span>
                    </p>
                    <p class="dernier">
                        <?= $removedPost['contentBegin'] ?> [...]<!--<br /><span class="float-right discret">cliquez pour afficher</span>-->
                    </p>
                    <p>
                        <button onclick="republishPost('<?= $removedPost['title'] ?>')">Republier le billet (le rendre accessible aux visiteurs)</button>
                        <button onclick="definitivelyDeletePost('<?= $removedPost['title'] ?>')">supprimer le billet (ATTENTION : DEFINITIF !)</button>
                    </p>
                    <p class="choiceHidden" id="<?= $removedPost['title'] ?>">
                        Êtes vous sûr ?<br />
                        <button onclick="deleteConfirmation('<?= $removedPost['title'] ?>')">oui (ATTENTION : DEFINITIF !)</button>
                        <button onclick="definitivelyDeletePost('<?= $removedPost['title'] ?>')">non (conseillé. Billet innaccessible et récupérable.)</button> <!-- it doesn't delet the post, but it's supposed to do the exact same thing as "definitivelyDeletePost() : it change the visibility of this paragraphe -->
                    </p>
                </div>
            </article>
    <?php
        }
    ?>
</section>