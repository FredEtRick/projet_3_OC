<?php
    require_once('model/Post.php');
    require_once('model/Comment.php');
    require_once('model/User.php');
?>

<script type="text/javascript">
    function hideOrShow(postTitle)
    {
        var contentElt = document.getElementById(postTitle);
        var displayProperty = getComputedStyle(contentElt).display;
        if (displayProperty == 'none')
        {
            contentElt.style.display = 'inline';
        }
        else if (displayProperty == 'inline')
        {
            contentElt.style.display = 'none';
        }
    }
    function removePost(postTitle, page)
    {
        document.location.href="controler/redirection/redirectionDeletePost.php?postTitle=" + postTitle + "&page=" + page;
    }
    function showAllDeletedPosts()
    {
        document.location.href="controler/redirection/redirectionShowAllDeletedPosts.php";
    }
    function republishPost(postTitle)
    {
        document.location.href="controler/redirection/redirectionRepublishPost.php?postTitle=" + postTitle;
    }
    function definitivelyDeletePost(postTitle)
    {
        var contentElt = document.getElementById(postTitle);
        var displayProperty = getComputedStyle(contentElt).display;
        if (displayProperty == 'none')
        {
            contentElt.style.display = 'inline';
        }
        else if (displayProperty == 'inline')
        {
            contentElt.style.display = 'none';
        }
    }
    function deleteConfirmation(postTitle)
    {
        document.location.href="controler/redirection/redirectionDeleteConfirmation.php?deletePostTitle=" + postTitle;
    }
</script>

<?php
    class AdminControler
    {
        private $_adminPostManager;
        private $_adminCommentManager;
        
        public function __construct()
        {
            $this->_adminPostManager = new PostManager();
            $this->_adminCommentManager = new CommentManager();
        }
        
        public function postsManagment()
        {
            try
            {
                // préparation des variables
                $pageTitle = 'gestion des billets';
                if (! isset($_GET['page']))
                    $_GET['page'] = 1;
                $indiceBegining = 5 * ((int) strip_tags($_GET['page']) - 1);
                $postsPerPages = 5;
                $indexPost = $indiceBegining;
                $postsLeft = $postsPerPages;
                $allPosts = $this->_adminPostManager->getAllPostsExceptExpiry();
                $cssClass = array('postsManagment' => 'greyButton', 'commentsReported' => '', 'createPost' => ''); // the postsManagment button will be grey
                $page = 1+ceil($indiceBegining / $postsPerPages);
                /*$pageDeleteRedirection;
                if ($indiceBegining >= count($allPosts)) // if deleting a post = 1 page less
                {
                    $pageDeleteRedirection = $page - 1;
                    echo '<script type="text/javascript">alert("' . $indiceBegining . ' =? ' . count($allPosts) . ', pageDeleteRedirection : ' . $pageDeleteRedirection . '")</script>';
                }
                else
                {
                    $pageDeleteRedirection = $page;
                }*/
                
                // récupération de la vue, et envoie de cette dernière au template
                ob_start();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/postsManagmentView.php';
                $content = ob_get_clean();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
        }
        public function commentsReported()
        {
            $pageTitle = 'commentaires signalés';
            $cssClass = array('postsManagment' => '', 'commentsReported' => 'greyButton', 'createPost' => '');
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/commentsReportedView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
        public function createPost()
        {
            $pageTitle = 'créer un nouveau billet';
            $cssClass = array('postsManagment' => '', 'commentsReported' => '', 'createPost' => 'greyButton');
            $someGiven = isset($_POST['newPostTitle']) || isset($_POST['tinymceNewPost']) || isset($_POST['publish']) || isset($_POST['datePublication']) || isset($_POST['expire']) || isset($_POST['dateExpiration']);
            $allGiven = isset($_POST['newPostTitle']) && isset($_POST['tinymceNewPost']) && isset($_POST['publish']) && isset($_POST['datePublication']) && isset($_POST['expire']) && isset($_POST['dateExpiration']);
            $error;
            $send;
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/createPostView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
        public function showAllDeletedPosts()
        {
            $pageTitle = 'billets retirés';
            $cssClass = array('postsManagment' => '', 'commentsReported' => '', 'createPost' => '');
            $removedPosts = $this->_adminPostManager->getAllRemovedPosts();
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/showAllDeletedPostsView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
    }

/*
a caler ailleurs :
    <textarea class="tinymce"></textarea>
    <script type="text/javascript" src="../plugins/jquery.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/init-tinymce.js"></script>
*/