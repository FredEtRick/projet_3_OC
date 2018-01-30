<?php
    session_start();

    require_once('../../model/Post.php');

    $postManager = new PostManager();
    $postManager->delete($_GET['deletePostTitle']);
?>
<script type="text/javascript">
    console.log('on entre dans redirectionDeleteConfirmation.php');
    document.location.href="../../index.php";
</script>