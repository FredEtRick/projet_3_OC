<?php
    session_start();

    $_SESSION['action'] = 'createPost';

    $URL = "../../index.php";
    if (isset($_POST['postTitle']))
        $URL .= '?postTitle=' . $_POST['postTitle'];
?>
<script>
    document.location.href='<?= $URL ?>';
</script>