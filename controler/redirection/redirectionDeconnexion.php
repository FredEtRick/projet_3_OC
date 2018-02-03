<?php
    /*
        session_destroy();
        session_unset();
        $_SESSION = [];
        
        I abandonned this lines because it gave me an error "session doesn't exist" even when I'm still connected.
    */
    session_start();
    unset($_SESSION['action']);
    session_destroy();
?>
<script>
    document.location.href="../../index.php";
</script>