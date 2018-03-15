<?php
    session_start();

    $_SESSION['action'] = 'postsManagment';

    require_once "../../model/Post.php";

    if (isset($_GET['modify']))
    {
        $post = new Post();
        $post->setTitle($_POST['newPostTitle']);
        $post->setContent($_POST['tinymceNewPost']);
        echo 'dateExpire : ' . $_POST['dateExpire'] . '<br />';
        echo 'timeExpire : ' . $_POST['timeExpire'] . '<br />';
        if ($_POST['publish'] == 'non') // régler la date si on a pas dit oui a "publier maintenant" sinon laisser la date par défaut
        {
            if (preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['datePublication']))
            {
                $year = substr($_POST['datePublication'], 0, 4);
                $mounth = substr($_POST['datePublication'], 5, 2);
                $day = substr($_POST['datePublication'], 8, 2);
            }
            elseif (preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#", $_POST['datePublication']))
            {
                $year = substr($_POST['datePublication'], 6, 4);
                $mounth = substr($_POST['datePublication'], 3, 2);
                $day = substr($_POST['datePublication'], 0, 2);
            }
            else
            {
                echo "ne match avec rien !!!" . $_POST['datePublication'];
            }
            $time = $_POST['timePublication'];
            $dateTimePub = $day . '/' . $mounth . '/' . $year . ' ' . $time;
            $post->setDateTimePub($dateTimePub);
        }
        if ($_POST['expire'] == 'dateExpire') // régler la date d'expiration si on a pas choisi "ne jamais expirer", sinon laisser par défaut a null
        {
            if (preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['dateExpire']))
            {
                $year = substr($_POST['dateExpire'], 0, 4);
                $mounth = substr($_POST['dateExpire'], 5, 2);
                $day = substr($_POST['dateExpire'], 8, 2);
            }
            elseif (preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#", $_POST['dateExpire']))
            {
                $year = substr($_POST['dateExpire'], 6, 4);
                $mounth = substr($_POST['dateExpire'], 3, 2);
                $day = substr($_POST['dateExpire'], 0, 2);
            }
            $time = $_POST['timeExpire'];
            $dateTimeExp = $day . '/' . $mounth . '/' . $year . ' ' . $time;
            $post->setDateTimeExp($dateTimeExp);
        }
        $postManager = new PostManager();
        if ($_GET['modify'])
        {
            $postManager->modify($post);
        }
        else
        {
            $postManager->insert($post);
        }
    }
    else
    {
        echo 'erreur : modify n\'est pas passé en GET';
    }
?>
<script>
    document.location.href="../../index.php";
</script>