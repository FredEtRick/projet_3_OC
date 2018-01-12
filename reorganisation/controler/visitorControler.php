<?php
    class VisitorControler // faire deuxième controleur pour admin
    {
        public function allPosts($page)
        {
            try
            {
                require_once('model/Post.php');
                
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
            require_once('model/Post.php');
            require_once('model/Comment.php');
            require_once('model/User.php');
            
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
                    // preparing post variables
                    $post = (new PostManager())->getOnePost($title);
                    $postTitle = $post->getTitle();
                    $postDateTimePub = $billet->getDateHeurePub();
                    
                    // preparing comments variables
                    $commentLoginVisitor = $comment->getVisitorLogin();
                    $commentDateTime = str_replace(' ', ', à ', $comment->getDateTime());
                    $commentContent = $comment->getContent();
                    
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/onePostView.php';
                    
                    $textWithNewLines = htmlspecialchars($post->getContent());
                    $textWithNewLines = nl2br($textWithNewLines);
                    $textWithNewLines = str_replace(array("\r", "\n"), array('', ''), $textWithNewLines);
                    $textLength = mb_strlen($post->getContent());
                    
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/controleur/resizePage.php';
                }
                catch (Exception $e)
                {
                    echo '<p>erreur : ' . $e->getMessage() ; '</p>';
                }
            }
        }
    }
?>