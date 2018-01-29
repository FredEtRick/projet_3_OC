<section class="row">
    <article class="col-xxl-12 col-xl-12 col-sm-12 adminMenu row">
        <form method="post" action="controler/redirectionPostsManagment.php" class="col-xxl-4 col-xl-4 col-sm-4">
            <input type="submit" class="col-xxl-12 col-xl-12 col-sm-12 <?php echo $cssClass['postsManagment'] ?>" value="gestion des billets" />
        </form>
        <form method="post" action="controler/redirectionCommentsReported.php" class="col-xxl-4 col-xl-4 col-sm-4">
            <input type="submit" class="col-xxl-12 col-xl-12 col-sm-12 <?php echo $cssClass['commentsReported'] ?>" value="commentaires signalés" />
        </form>
        <form method="post" action="controler/redirectionCreatePost.php" class="col-xxl-4 col-xl-4 col-sm-4">
            <input type="submit" class="col-xxl-12 col-xl-12 col-sm-12 <?php echo $cssClass['createPost'] ?>" value="créer un nouveau billet" />
        </form>
    </article>
    <p class="col-xxl-12 col-xl-12 col-sm-12"></p>