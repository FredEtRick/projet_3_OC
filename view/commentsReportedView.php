    <article class="col-xxl-6 col-xl-12 col-sm-12">
        <p>liste des commentaires signalés :</p>
        <?php
            foreach ($commentsReported as $comment)
            {
        ?>
                <div class="hidden-xl-down col-xxl-3"></div>
                <div class="col-xxl-6 col-xl-12 col-sm-12 bulle">
                    <p>
                        <?= $comment['visitorLogin'] ?>
                        <span class="float-right">Le <?= $comment['dateTime'] ?></span>
                    </p>
                    <p class="dernier">
                        <?= $comment['content'] ?>
                    </p>
                    <p>
                        Au sujet du billet : <?= $comment['postTitle'] ?>
                    </p>
                    <p>
                        <button onclick="keepComment('<?= $comment['ID'] ?>')">
                            valider le billet
                        </button>
                        <button onclick="removeComment('<?= $comment['ID'] ?>')">
                            retirer le billet
                        </button>
                    </p>
                </div>
        <?php
            }
        ?>
    </article>