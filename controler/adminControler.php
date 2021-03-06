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
    function deconnexion()
    {
        document.location.href="controler/redirection/redirectionDeconnexion.php";
    }
    function modifyPost(postTitle)
    {
        document.location.href="controler/redirection/redirectionCreatePost.php?modifyPostTitle=" + postTitle;
    }
    function keepComment(ID)
    {
        document.location.href="controler/redirection/redirectionKeepComment.php?idComment=" + ID;
    }
    function removeComment(ID)
    {
        document.location.href="controler/redirection/redirectionRemoveComment.php?idComment=" + ID;
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
                
                // récupération de la vue, et envoie de cette dernière au template
                ob_start();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/postsManagmentView.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminFooterDeconnexionView.php';
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
            $commentsReported = $this->_adminCommentManager->getAllCommentsReported();
            $nonReported = $this->_adminCommentManager->getAllCommentsNonReported();
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/commentsReportedView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminFooterDeconnexionView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
        public function createPost() // and modify if isset $_POST postitle
        {
            $pageTitle = 'créer un nouveau billet';
            $cssClass = array('postsManagment' => '', 'commentsReported' => '', 'createPost' => 'greyButton');
            $someGiven = isset($_POST['newPostTitle']) || isset($_POST['tinymceNewPost']) || isset($_POST['publish']) || isset($_POST['datePublication']) || isset($_POST['expire']) || isset($_POST['dateExpiration']);
            $allGiven = isset($_POST['newPostTitle']) && isset($_POST['tinymceNewPost']) && isset($_POST['publish']) && isset($_POST['datePublication']) && isset($_POST['expire']) && isset($_POST['dateExpiration']);
            $error;
            $send;
            
            if (isset($_GET['modifyPostTitle']))
            {
                $post = $this->_adminPostManager->getOnePost($_GET['modifyPostTitle']);
                
                $dateTimePub = $post->getDateTimePub();
                $yearPub = '' . substr($dateTimePub, 0, 4);
                $mounthPub = '' . substr($dateTimePub, 5, 2);
                $dayPub = '' . substr($dateTimePub, 8, 2);
                $datePubFr = $dayPub . '/' . $mounthPub . '/' . $yearPub;
                $datePubEn = $yearPub . '-' . $mounthPub . '-' . $dayPub;
                $timePub = '' . substr($dateTimePub, 11, 8);
                
                $dateTimeExp = $post->getDateTimeExp();
                if ($dateTimeExp == null)
                {
                    $jamaisChecked = 'checked';
                    $dateExpireRadioChecked = '';
                    $dateExpireInputFr = '';
                    $dateExpireInputEn = '';
                    $timeExpireInput = '';
                }
                else
                {
                    $jamaisChecked = '';
                    $dateExpireRadioChecked = 'checked';
                    $yearExp = '' . substr($dateTimeExp, 0, 4);
                    $mounthExp = '' . substr($dateTimeExp, 5, 2);
                    $dayExp = '' . substr($dateTimeExp, 8, 2);
                    $dateExpireInputFr = $dayExp . '/' . $mounthExp . '/' . $yearExp;
                    $dateExpireInputEn = $yearExp . '-' . $mounthExp . '-' . $dayExp;
                    $timeExpireInput = '' . substr($dateTimeExp, 11, 8);
                }
                
                $titleValue = $post->getTitle();
                $tinyChargedContent = 'true';
                $content = $post->getContent();
                $ouiChecked = '';
                $nonChecked = 'checked';
                $datePubInputFr = $datePubFr;
                $datePubInputEn = $datePubEn;
                $timePubInput = $timePub; // note : manque secondes, pas possible de mettre
                $formAction = 'controler/redirection/redirectionValidationPost.php?modify=1';
            }
            else
            {
                $titleValue = '';
                $tinyChargedContent = 'false';
                $content = '';
                $ouiChecked = 'checked';
                $nonChecked = '';
                $datePubInputFr = '';
                $datePubInputEn = '';
                $timePubInput = '';
                $jamaisChecked = 'checked';
                $dateExpireRadioChecked = '';
                $dateExpireInput = '';
                $timeExpireInput = '';
                $formAction = 'controler/redirection/redirectionValidationPost.php?modify=0';
            }
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/createPostView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminFooterDeconnexionView.php';
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
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminFooterDeconnexionView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
    }