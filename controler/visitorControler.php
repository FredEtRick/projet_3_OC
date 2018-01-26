<?php
    require_once('model/Post.php');
    require_once('model/Comment.php');
    require_once('model/User.php');

    class VisitorControler // faire deuxième controleur pour admin
    {
        private $_visitorPostManager;
        private $_visitorCommentManager;
        
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
            //print_r($allPosts);
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
                    $error = false;
                    $sent = false;
                    $message = '';
                    $allGiven = isset($_POST['login']) && isset($_POST['email']) && isset($_POST['message']);
                    $someGiven = isset($_POST['login']) || isset($_POST['email']) || isset($_POST['message']);
                    if ($someGiven)
                    {
                        if (! $allGiven)
                        {
                            $error = true;
                            $message .= 'Vous n\'avez pas renseigné tous les champs. ';
                        }
                        // suppr mail ? Y est pas dans BDD
                        if ((isset($_POST['email'])) && (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
                        {
                            $error = true;
                            $message .= 'E-mail invalide. ';
                        }
                    }
                    if ($allGiven && ! $error)
                    {
                        $sent = true;
                        
                        $newComment = new Comment(); // initialise la date a l'actuelle si pas d'arguments
                        // supprimer mail ? Y est pas dans BDD
                        $newComment->setContent(strip_tags($_POST['message']));
                        $newComment->setVisitorLogin(strip_tags($_POST['login']));
                        $newComment->setPostTitle($postTitle);
                        
                        $this->_visitorCommentManager->insert($newComment);
                        
                        $message .= 'Le commentaire a été envoyé.';
                    }
                    
                    ob_start();
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/onePostView.php';
                    $content = ob_get_clean();
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
                    
                    $textWithNewLines = htmlspecialchars($activePost['content']);
                    $textWithNewLines = nl2br($textWithNewLines);
                    $textWithNewLines = str_replace(array("\r", "\n"), array('', ''), $textWithNewLines);
                    $textWithNewLines = str_replace('"', '\"', str_replace("'", "\'", json_encode($textWithNewLines)));
                    $textLength = mb_strlen($activePost['content']);
                    
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/controler/resizePage.php';
                }
                catch (Exception $e)
                {
                    echo '<p>erreur : ' . $e->getMessage() ; '</p>';
                }
            }
        }
    }
?>