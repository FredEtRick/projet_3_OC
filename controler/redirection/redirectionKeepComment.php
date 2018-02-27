<?php
    session_start();
    require_once "../../model/Comment.php";
    
    $commentManager = new commentManager();
    $commentManager->keep($_GET['idComment']);
?>

<script>
    document.location.href="../../index.php";
</script>