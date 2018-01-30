<?php
    session_start();
    require_once "../../model/Post.php";
    
    $postManager = new PostManager();
    $postManager->remove($_GET['postTitle']);
?>

<script>
    console.log(<?= $_GET['page'] ?>);
    document.location.href="../../index.php?page=<?= $_GET['page'] ?>";
</script>