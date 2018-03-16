<!--
A REECRIRE !!!!!!!!!!!!!
traduire, virer les fonction, garder les while et if, donner des noms simples aux variables.
-->

<!-- show post -->
<section class="row">
    <article class="col-xxl-12 col-xl-12 col-sm-12 post">
        <h4><?= $postTitle ?></h4>
        <p class="float-right onePostDate">Le <?= $postDateTimePub ?></p>
        <div class="row" id="parent">
            <div class="col-xxl-6 col-xl-12 col-sm-12">
                <p id="content"></p>
                <!-- pagination -->
                <p id="shouldAppear"></p>
                <p id="shouldNotAppear"></p>
            </div>
        </div>
        <hr />
    </article>
    <article class="col-xxl-12 col-xl-12 col-sm-12">
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
    <article class="col-xxl-12 col-xl-12 col-sm-12">
        <h4>commentaires</h4>
<?php
    foreach($comments as $comment) // reste à réadapter noms dessous pour tableau
    {
?>
        <div class="hidden-xl-down col-xxl-3"></div>
        <div class="col-xxl-6 col-xl-12 col-sm-12 bulle">
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