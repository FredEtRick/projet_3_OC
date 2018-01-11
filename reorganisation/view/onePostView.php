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
                <p id="contenu"></p>
                <!-- pagination -->
                <p id="reduire"></p>
                <p id="rallonger"></p>
            </div>
        </div>
    </article>
</section>
    
<!-- show all comments relatives to the post -->
            
<section class="row">
<?php
    foreach($lesCommentaires as $commentaire)
    {
?>
        <div class="hidden-xl-down col-xxl-3"></div>
        <article class="col-xxl-6 col-xl-12 col-sm-12 bulle">
            <p><?= $commentLoginVisitor ?><span class="float-right">Le <?= $commentDateTime ?></span></p>
            <p class="dernier"><?= $commentContent ?></p>
        </article>
<?php
    }
?>
</section>