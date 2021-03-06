<!-- show post -->
<section class="row">
    <article class="col-xxl-12 col-xl-12 col-sm-12 post">
        <h4><?= $postTitle ?></h4>
        <p class="rightSide onePostDate">Le <?= $postDateTimePub ?></p>
        <div class="row clear" id="parent">
            <div class="col-xxl-6 col-xl-12 col-sm-12">
                <p id="content"></p>
                <!-- pagination -->
                <p id="shouldAppear"></p>
                <p id="shouldNotAppear"></p>
            </div>
        </div>
        <hr />
    </article>
    <article class="col-xxl-6 col-xl-12 col-sm-12 comments">
        <!-- message si le visiteur a tenté de renseigner le formulaire de dépôt de commentaire (message d'erreur ou de confirmation d'envoie) -->
<?php
    if ($error)
    {
?>
        <p class="alert alert-danger" role="alert">Erreur : <?= $message; ?></p>
<?php
    }
?>
<?php
    if ($sent)
    {
?>
        <p class="alert alert-success" role="alert"><?= $message; ?></p>
<?php
    }
?>
        <form method="post" class="writeCommentForm">
            <h4>Ecrivez un commentaire :</h4>
            <p>
                <label for="login">votre pseudo :  </label><input type="text" id="login" name="login" maxlength="30" /><br />
            </p>
            <p>
                <label for="message">Votre message :</label><br />
                <textarea id="message" name="message"></textarea>
            </p>
            <p>
                <input type="submit" value="Valider" />
            </p>
        </form>
        <hr />
    </article>
<!-- show all comments relatives to the post -->
    <div class="col-xxl-12 col-xl-12 col-sm-12"></div>
    <article class="col-xxl-6 col-xl-12 col-sm-12 comments">
        <h4>commentaires</h4>
<?php
    foreach($comments as $comment)
    {
?>
        <div class="bulle">
            <p><?= $comment['visitorLogin'] ?><span class="float-right">Le <?= $comment['dateTime'] ?></span></p>
            <p class="dernier"><?= $comment['content'] ?></p>
<?php
        if (! isset($_GET['commentID']) || $_GET['commentID'] != $comment['ID'])
        {
?>
            <p><a href="../index.php?action=signal&amp;commentID=<?= $comment['ID'] ?>&amp;postTitle=<?= $postTitle ?>">Signaler</a></p>
<?php
        }
        else
        {
?>
            <p>Commentaire signalé, en attente de modération.</p>
<?php
        }
?>
        </div>
<?php
    }
?>
    </article>
</section>