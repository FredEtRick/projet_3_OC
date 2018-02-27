<?php
    session_start();

    $_SESSION['action'] = 'createPost';

    $URL = "../../index.php";
    if (isset($_GET['modifyPostTitle']))
        $URL .= '?modifyPostTitle=' . $_GET['modifyPostTitle'];
?>
<script>
    document.location.href='<?= $URL ?>';
</script>