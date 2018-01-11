<?php
    class VisitorControler // faire deuxième controleur pour admin
    {
        public function allPosts($page)
        {
            try
            {
                // préparation des variables
                $pageTitle = 'la liste des billets';
                if (! isset($_GET['page']))
                    $_GET['page'] = 1;
                $i = 5 * ((int) strip_tags($_GET['page']) - 1);
                $n = 5;
                $idep = $i;
                $ndep = $n;
                $allPosts = (new PostManager())->getAllPostsExceptExpiry();
                
                // récupération de la vue, et envoie de cette dernière au template
                ob_start();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/allPostsView.php';
                $content = ob_get_clean();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
            // au lieu de showPosts(), plutot des variables initialisées ici et utilisées dans allPostsView ?
            // showPosts($admin, $allPosts, (5 * ((int) strip_tags($_GET['page']) - 1)), 5);
        }
        
        public function onePost($title)
        {
            $activePost = null;
            foreach($allPosts as $currentPost)
            {
                if ($title == str_replace(' ', '_', $currentPost->getTitle()))
                {
                    $thePost = $currentPost;
                    $comments = $commentManager->getCommentsByPost($currentPost->getTitle());
                }
            }
            if($activePost != null)
            {
                try
                {
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/onePostView.php';
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/controleur/resizePage.php';
                }
                catch (Exception $e)
                {
                    echo '<p>erreur : ' . $e->getMessage() ; '</p>';
                }
                // supprimer les fonctions suivantes, utiliser uniquement des variables !
                // showPost($activePost);
                // showComments($comments);
            }
        }
    }
?>