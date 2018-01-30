<?php
    session_start();

    $_SESSION['action'] = 'commentsReported';
?>
<script>
    document.location.href="../../index.php";
</script>