<?php
    require_once('model/Post.php');

    class Router
    {
        private $_arrayAllPosts;
        private $_postManager;
        private $_visitorControler;
        private $_connexionControler;
        private $_adminControler;
    
        public function __construct()
        {
            $this->_postManager = new PostManager();
            $this->_arrayAllPosts = $this->_postManager->getAllPostsExceptExpiry();
            $this->_visitorControler = new VisitorControler();
            $this->_connexionControler = new ConnexionControler();
            $this->_adminControler = new AdminControler();
        }
        
        public function rout()
        {
            if (isset($_SESSION['action']))
            {
                if($_SESSION['action'] == 'postsManagment')
                {
                    $this->_adminControler->postsManagment();
                }
                elseif($_SESSION['action'] == 'commentsReported')
                {
                    $this->_adminControler->commentsReported();
                }
                elseif($_SESSION['action'] == 'createPost')
                {
                    $this->_adminControler->createPost();
                }
                elseif($_SESSION['action'] == 'showAllDeletedPosts')
                {
                    $this->_adminControler->showAllDeletedPosts();
                }
                else
                {
                    echo 'session action renseigné dans l\'adresse, mais valeur inconnue';
                }
            }
            elseif (isset($_GET['action']))
            {
                if ($_GET['action'] == 'allPosts')
                {
                    if (isset($_GET['page']) AND is_numeric($_GET['page']) AND $_GET['page'] <= (ceil(count($this->_arrayAllPosts) / 5)))
                    {
                        $this->_visitorControler->allPosts($_GET['page']);
                    }
                    else
                    {
                        $this->_visitorControler->allPosts(1);
                    }
                }
                elseif ($_GET['action'] == 'onePost')
                {
                    $title = $_GET['title'];
                    if (isset($title))
                    {
                        $this->_visitorControler->onePost($title);
                    }
                    else
                    {
                        echo 'aucun titre';
                    }
                }
                elseif($_GET['action'] == 'connexion')
                {
                    if (isset($_POST['login']) && isset($_POST['password']))
                    {
                        $this->_connexionControler->tryConnexion();
                    }
                    else
                    {
                        $this->_connexionControler->connexionForm();
                    }
                }
                elseif ($_GET['action'] == 'signal')
                {
                    if (isset($_GET['commentID']) && isset($_GET['postTitle']))
                    {
                        $commentID = $_GET['commentID'];
                        $postTitle = $_GET['postTitle'];
                        $this->_visitorControler->reportComment($commentID, $postTitle);
                    }
                }
                else
                {
                    echo 'get action renseigné dans l\'adresse, mais valeur inconnue';
                }
            }
            else
            {
                $this->_visitorControler->allPosts(1);
            }
        }
    }