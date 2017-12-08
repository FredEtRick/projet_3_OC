<?php
    $bdd = new PDO('mysql:host=localhost:8889;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/enTete.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    enTete('connexion');

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/modele/Utilisateur.php';
        $utilisateurManager = new UtilisateurManager($bdd);
        $lesUtilisateurs = $utilisateurManager->recupererTous();
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }

    $leBonUtilisateur = null;

    if (isset($_POST['login']) && isset($_POST['mdp']))
    {
        foreach($lesUtilisateurs as $utilisateur)
        {
            if ((strip_tags($_POST['login']) == $utilisateur->getLogin()) && (strip_tags(sha1('gz' . $_POST['mdp'])) == $utilisateur->getMdp()))
            {
                $leBonUtilisateur = $utilisateur;
            }
        }
    }
    
    if ($leBonUtilisateur != null)
    {
        echo "CONNEXION REUSSIE !!!";
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['mdp'] = sha1('gz' . $_POST['mdp']);
        // gérer plus tard aussi avec des cookies si coche case "mémoriser"
?>
<script type="text/javascript">
    document.location.href="index.php";
</script>
<?php
    }

    else
    {
        try
        {
            require $_SERVER['DOCUMENT_ROOT'] . '/vue/vueConnexion.php';
        }
        catch (Exception $e)
        {
            echo '<p>erreur : ' . $e->getMessage() ; '</p>';
        }
        if (isset($_POST['login']) || isset($_POST['mdp']))
        {
            erreurConnexion();
        }
    }

    // vérifier validité, puis renvoyer vers index avec $_POST. Idée : faire une redirection en javascript.

    try
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/vue/pied.php';
    }
    catch (Exception $e)
    {
        echo '<p>erreur : ' . $e->getMessage() ; '</p>';
    }
?>