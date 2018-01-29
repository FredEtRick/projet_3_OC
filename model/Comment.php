<?php
    require_once 'Model.php';

    // manager de la classe post
    class CommentManager extends Model
    {
        public function insert(Comment $comment)
        {
            $query = $this->_DB->prepare('INSERT INTO Comment (content, postTitle, visitorLogin) VALUES (:content, :postTitle, :visitorLogin)');
            $query->bindValue(':content', $comment->getContent());
            $query->bindValue(':postTitle', $comment->getPostTitle());
            $query->bindValue(':visitorLogin', $comment->getVisitorLogin());

            $query->execute();
        }
        
        //DATE_FORMAT(dateTimePub, \'%m/%c/%Y à %H:%i:%s\') AS DHP, DATE_FORMAT(dateTimeExp, \'%m/%c/%Y à %H:%i:%s\') AS DHE
        
        public function getAllCommentsOnPost($title)
        {
            $query = $this->_DB->query('SELECT ID, dateTime, content, postTitle, visitorLogin FROM Comment WHERE postTitle = "' . $title . '"');
            $comments = [];
            while($postFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                $array = [];
                $array['dateTime'] = $postFromSQL['dateTime'];
                $array['content'] = $postFromSQL['content'];
                $array['postTitle'] = $postFromSQL['postTitle'];
                $array['visitorLogin'] = $postFromSQL['visitorLogin'];
                $comments[] = $array;
            }
            return $comments;
        }
        
        /*public function recupererTousSaufExp()
        {
            $comments = [];
            $query = $this->_DB->query('SELECT title, dateTimePub, dateTimeExp, content FROM Comment ORDER BY dateTimePub');
            while($postFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                $comment = new Comment($postFromSQL);
                if (date('d/m/Y H:i:s') < $comment->getDateTimeExp() || $comment->getDateTimeExp() == NULL)
                    $comments[] = $comment;
            }
            return $comments;
        }
        
        public function modifier(Comment $comment)
        {
            $query = $this->_DB->prepare('UPDATE Comment SET title = :title, dateTimePub = :dateTimePub, dateTimeExp = :dateTimeExp, content = :content WHERE title = :title');

            $query->bindValue(':title', $comment->getTitre());
            $query->bindValue(':dateTimePub', $comment->getDateTimePub());
            $query->bindValue(':dateTimeExp', $comment->getDateTimeExp());
            $query->bindValue(':content', $comment->getContent());
            
            $query->execute();
        }*/
        
        public function delete($ID)
        {
            $this->_DB->exec('DELETE FROM Comment WHERE ID = "' . $ID . '"');
        }
    }

    //classe comments = articles postés, morceaux de livre
    class Comment
    {
        // attributs
        private $_ID;
        private $_dateTime;
        private $_content;
        private $_postTitle;
        private $_visitorLogin;

        // const DEBUT_TITRES = "title : "; // juste pour l'entrainement

        // private static $_total = 0; // juste pour l'entrainement

        // constructeur
        public function __construct()
        {
            $argsNumber = func_num_args();
            $args = func_get_args();
            $cpt = 0;
            $setters = array("setDateTime", "setContent", "setPostTitle", "setVisitorLogin");
            if ($argsNumber != 0)
            {
                if (is_array($args[0]) && $argsNumber == 1)
                    $this->hydrate($args[0]);
                else
                    while ($cpt < $argsNumber && $cpt < count($setters))
                    {
                        $this->$setters[$cpt]($args[$cpt]);
                        $cpt++;
                    }
            }
        }
        
        public function hydrate (array $postFromSQL)
        {
            foreach($postFromSQL as $key => $value)
            {
                $methode = 'set' . ucfirst($key);
                if (method_exists($this, $methode))
                    $this->$methode($value);
            }
        }

        // accesseurs
        public function getID()
        {
            return $this->_ID;
        }
        public function getDateTime()
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateTime);
            $date = $date->format('d/m/Y H:i:s');
            return $date;
        }
        public function getContent()
        {
            return $this->_content;
        }
        public function getPostTitle()
        {
            return $this->_postTitle;
        }
        public function getVisitorLogin()
        {
            return $this->_visitorLogin;
        }
        
        // mutateurs
        public function setDateTime($dateTime) // là force a prendre un stirng
        {
            // try essayer de caster en dateTimePub
            $this->_dateTime = $dateTime;
        }
        public function setContent($content)
        {
            if (! is_string($content))
            {
                trigger_error('le content du commentaire n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_content = $content;
        }
        public function setPostTitle($title)
        {
            // verification type
            if (! is_string($title))
            {
                trigger_error('le title du comment n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
                return;
            }
            // verification taille
            if (strlen($title) > 120)
            {
                trigger_error('le title du comment n\'a pu être modifié, le paramètre étant une chaîne de caractères trop longue.', E_USER_WARNING);
                return;
            }
            $this->_postTitle = $title; // juste pour m'entrainer avec self:: etc
        }
        public function setVisitorLogin($login)
        {
            $this->_visitorLogin= $login;
        }
        public function nullDate()
        {
            return $this->_dateTime == null;
        }
    }
?>