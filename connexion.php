<?php
    // this way the admin doesn't have to enter variables and values in the URL, and this way the visitors don't see a "connexion" button on the page, the admin can connect by just replacing "index" with "connexion" in the URL. Then, this page send the admin to the page "index.php?action=connexion"
    session_start();
?>
<script type="text/javascript">
    document.location.href="index.php?action=connexion";
</script>