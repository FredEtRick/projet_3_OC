<?php
    session_start();

    $_SESSION['action'] = 'showAllDeletedPosts';
?>
<script>
    document.location.href="../../index.php";
</script>