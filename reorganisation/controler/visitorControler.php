<?php
    require_once('model/Post.php');
    require_once('model/Comment.php');
    require_once('model/User.php');

    class VisitorControler // faire deuxième controleur pour admin
    {
        private $_visitorPostManager;
        
        public function __construct()
        {
            $this->_visitorPostManager = new PostManager();
            $this->_visitorCommentManager = new CommentManager();
        }
        
        public function allPosts($page)
        {
            try
            {
                // préparation des variables
                $pageTitle = 'la liste des billets';
                if (! isset($_GET['page']))
                    $_GET['page'] = 1;
                $indiceBegining = 5 * ((int) strip_tags($_GET['page']) - 1);
                $postsPerPages = 5;
                $indexPost = $indiceBegining;
                $postsLeft = $postsPerPages;
                $allPosts = $this->_visitorPostManager->getAllPostsExceptExpiry();
                
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
            $activePostTitle = null;
            $allPosts = $this->_visitorPostManager->getAllPostsExceptExpiry();
            foreach($allPosts as $currentPost)
            {
                if ($title == str_replace(' ', '_', $currentPost['title']))
                {
                    $activePost = $currentPost;
                    $comments = $this->_visitorCommentManager->getAllCommentsOnPost($currentPost['title']);
                }
            }
            if($activePost != null)
            {
                try
                {
                    // preparing post variables
                    $postTitle = $activePost['title'];
                    $postDateTimePub = $activePost['dateTime'];
                    $pageTitle = 'Billet simple pour l\'Alaska - ' . $postTitle;
                    
                    ob_start();
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/onePostView.php';
                    $content = ob_get_clean();
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
                    
                    $textWithNewLines = htmlspecialchars($activePost['content']);
                    $textWithNewLines = nl2br($textWithNewLines);
                    $textWithNewLines = str_replace(array("\r", "\n"), array('', ''), $textWithNewLines);
                    $textLength = mb_strlen($activePost['content']);
                    
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