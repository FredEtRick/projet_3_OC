<?php
    session_start();
    require_once "../../model/Comment.php";
    
    $commentManager = new commentManager();
    $commentManager->delete($_GET['idComment']);
?>

<script>
    document.location.href="../../index.php";
</script>