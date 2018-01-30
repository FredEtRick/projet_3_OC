<?php
    session_start();
    require_once "../../model/Post.php";
    
    $postManager = new PostManager();
    $postManager->republish($_GET['postTitle']);
?>

<script>
    document.location.href="../../index.php";
</script>