<?php
    // doesn't work with just session_destroy
    session_start();
    unset($_SESSION['action']);
    session_destroy();
?>
<script>
    document.location.href="../../index.php";
</script>