<!--
A REECRIRE !!!!!!!!!!!!!
traduire, virer les fonction, garder les while et if, donner des noms simples aux variables.
-->

<!-- show post -->
<section class="row">
    <article class="col-xxl-12 col-xl-12 col-sm-12">
        <p>
            <?= $postTitle ?> - <?= $postDateTimePub ?>
        </p>
        <div class="row" id="parent">
            <div class="col-xxl-6 col-xl-12 col-sm-12">
                <p id="content"></p>
                <!-- pagination -->
                <p id="shouldAppear"></p>
                <p id="shouldNotAppear"></p>
            </div>
        </div>
    </article>
</section>
    
<!-- show all comments relatives to the post -->

<section class="row">
    <textarea class="tinymce"></textarea>
    <script type="text/javascript" src="../plugins/jquery.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/init-tinymce.js"></script>
</section>
            
<section class="row">
<?php
    foreach($comments as $comment) // reste à réadapter noms dessous pour tableau
    {
?>
        <div class="hidden-xl-down col-xxl-3"></div>
        <article class="col-xxl-6 col-xl-12 col-sm-12 bulle">
            <p><?= $comment['visitorLogin'] ?><span class="float-right">Le <?= $comment['dateTime'] ?></span></p>
            <p class="dernier"><?= $comment['content'] ?></p>
        </article>
<?php
    }
?>
</section>