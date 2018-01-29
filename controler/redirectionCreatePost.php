<?php
    session_start();

    $_SESSION['action'] = 'createPost';
?>
<script>
    document.location.href="../index.php";
</script>