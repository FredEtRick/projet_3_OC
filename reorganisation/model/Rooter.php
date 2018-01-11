<?php
class Rooter // mettre dans modèle puis créer objet dans index
    {
        public function root(/*$posts, $commentManager, $comments, $users, $admin*/) // vars commentManager etc, déclarer dans le controleur et manipuler la bas plutot que trimbaler
        {
            $visitorControler = new VisitorControler();
            if (isset($_GET['action']))
            {
                if ($_GET['action'] == 'allPosts')
                {
                    if (isset($_GET['page']) AND is_numeric($_GET['page']) AND $_GET['page'] <= (ceil(count($allPosts) / 5)))
                    {
                        $visitorControler->allPosts($page);
                    }
                    else
                    {
                        $visitorControler->allPosts(1);
                    }
                }
                elseif ($_GET['action'] == 'onePost')
                {
                    $title = $_GET['title'];
                    if (isset($title))
                    {
                        $visitorControler->onePost($title);
                    }
                    else
                    {
                        echo 'aucun titre';
                    }
                }
            }
            else
            {
                $visitorControler->allPosts(1);
            }
        }
    }