<?php
    require_once 'Model.php';

    // manager de la classe post
    class PostManager extends Model
    {
        public function insert(Post $post)
        {
            $pubGiven = $post->getDateTimePub() != '';
            $expGiven = $post->getDateTimeExp() != '';
            
            if ($pubGiven && $expGiven)
                $query = $this->_DB->prepare('INSERT INTO Post (title, dateTimePub, dateTimeExp, content) VALUES (:title, :dateTimePub, :dateTimeExp, :content)');
            elseif ($pubGiven && !$expGiven)
                $query = $this->_DB->prepare('INSERT INTO Post (title, dateTimePub, content) VALUES (:title, :dateTimePub, :content)');
            elseif (!$pubGiven && $expGiven)
                $query = $this->_DB->prepare('INSERT INTO Post (title, dateTimeExp, content) VALUES (:title, :dateTimeExp, :content)');
            else
                $query = $this->_DB->prepare('INSERT INTO Post (title, content) VALUES (:title, :content)');
            
            $query->bindValue(':title', $post->getTitle());
            if ($pubGiven)
                $query->bindValue(':dateTimePub', $post->getDateTimePub());
            if ($expGiven)
                $query->bindValue(':dateTimeExp', $post->getDateTimeExp());
            $query->bindValue(':content', $post->getContent());
            
            $query->execute();
        }
        
        public function getOnePost($title)
        {
            $query = $this->_DB->query('SELECT title, dateTimePub, dateTimeExp, content FROM Post WHERE title = "' . $title . '"');
            return new Post($query->fetch(PDO::FETCH_ASSOC));
        }
        
        public function getAllPostsExceptExpiry() // select all posts that aren't expiry yet, create 3 tabs for allPostsView (one contening all the titles of the posts selected, one for date and time of publication, one for content) and return a table with this 3 tabs within it.
        {
            $allPosts = [];
            $query = $this->_DB->query('SELECT title, dateTimePub, dateTimeExp, content, removed FROM Post ORDER BY dateTimePub');
            $i = 0;
            while($onePostFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                if ((! $onePostFromSQL['removed']) && (date('Y-m-d H:i:s') < $onePostFromSQL['dateTimeExp'] || $onePostFromSQL['dateTimeExp'] == NULL) && (date('Y-m-d H:i:s') > $onePostFromSQL['dateTimePub']))
                {
                    $dateTimePub = $onePostFromSQL['dateTimePub'];
                    $yearPub = '' . substr($dateTimePub, 0, 4);
                    $mounthPub = '' . substr($dateTimePub, 5, 2);
                    $dayPub = '' . substr($dateTimePub, 8, 2);
                    $datePub = $dayPub . '/' . $mounthPub . '/' . $yearPub;
                    $timePub = '' . substr($dateTimePub, 11, 8);
                    $dateTimePub = $datePub . ', à ' . $timePub;
                    
                    $allPosts[$i]['title'] = $onePostFromSQL['title'];
                    $allPosts[$i]['titleForLink'] = str_replace(' ', '_', $onePostFromSQL['title']);
                    $allPosts[$i]['dateTime'] = $dateTimePub;
                    $allPosts[$i]['content'] = $onePostFromSQL['content'];
                    $allPosts[$i]['contentBegin'] = mb_substr($onePostFromSQL['content'], 0, 300); // 300 firts chars
                    $i++;
                }
            }
            return $allPosts;
        }
        
        public function getAllRemovedPosts()
        {
            $allPosts = [];
            $query = $this->_DB->query('SELECT title, dateTimePub, dateTimeExp, content, removed FROM Post ORDER BY dateTimePub');
            $i = 0;
            while($onePostFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                if ($onePostFromSQL['removed'])
                {
                    $allPosts[$i]['title'] = $onePostFromSQL['title'];
                    $allPosts[$i]['titleForLink'] = str_replace(' ', '_', $onePostFromSQL['title']);
                    $allPosts[$i]['dateTime'] = str_replace(' ', ', à ', $onePostFromSQL['dateTimePub']); // correct display with str replace
                    $allPosts[$i]['content'] = $onePostFromSQL['content'];
                    $allPosts[$i]['contentBegin'] = mb_substr($onePostFromSQL['content'], 0, 300); // 300 firts chars
                    $i++;
                }
            }
            return $allPosts;
        }
        
        public function modify(Post $post)
        {
            $pubGiven = $post->getDateTimePub() != '';
            $expGiven = $post->getDateTimeExp() != '';
            
            
            if ($pubGiven && $expGiven)
                $query = $this->_DB->prepare('UPDATE Post SET title = :title, dateTimePub = :dateTimePub, dateTimeExp = :dateTimeExp, content = :content WHERE title = :title');
            elseif ($pubGiven && !$expGiven)
                $query = $this->_DB->prepare('UPDATE Post SET title = :title, dateTimePub = :dateTimePub, content = :content WHERE title = :title');
            elseif (!$pubGiven && $expGiven)
                $query = $this->_DB->prepare('UPDATE Post SET title = :title, dateTimeExp = :dateTimeExp, content = :content WHERE title = :title');
            else
                $query = $this->_DB->prepare('UPDATE Post SET title = :title, content = :content WHERE title = :title');
            
            $query->bindValue(':title', $post->getTitle());
            if ($pubGiven)
                $query->bindValue(':dateTimePub', $post->getDateTimePub());
            if ($expGiven)
                $query->bindValue(':dateTimeExp', $post->getDateTimeExp());
            $query->bindValue(':content', $post->getContent());
            
            $query->execute();
        }
        
        public function delete($title)
        {
            $this->_DB->exec('DELETE FROM Post WHERE title = "' . $title . '"');
        }
        
        public function remove($title)
        {
            $query = $this->_DB->prepare('UPDATE Post SET removed = true WHERE title = :title');

            $query->bindValue(':title', $title);
            
            $query->execute();
        }
        
        public function republish($title)
        {
            $query = $this->_DB->prepare('UPDATE Post SET removed = false WHERE title = :title');

            $query->bindValue(':title', $title);
            
            $query->execute();
        }
    }

    class Post
    {
        // attributs
        private $_title;
        private $_dateTimePub;
        private $_dateTimeExp;
        private $_content;

        // constructeur
        public function __construct()
        {
            $numberOfArgs = func_num_args();
            $args = func_get_args();
            $counter = 0;
            $setters = array("setTitle", "setDateTimePub", "setDateTimeExp", "setContent");
            if ($numberOfArgs == 1 && is_array($args[0]))
                $this->hydrate($args[0]);
            else
                while ($counter < $numberOfArgs && $counter < count($setters))
                {
                    $this->$setters[$counter]($args[$counter]);
                    $counter++;
                }
        }
        
        public function hydrate (array $onePostFromSQL)
        {
            foreach($onePostFromSQL as $key => $value)
            {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method))
                    $this->$method($value);
            }
        }

        // accesseurs
        public function getTitle()
        {
            return $this->_title;
        }
        public function getDateTimePub()
        {
            $dateFirstFormat = $this->_dateTimePub;
            
            if ($dateFirstFormat == null)
                return null;
            else
            {
                if (preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $dateFirstFormat))
                {
                    $year = substr($dateFirstFormat, 0, 4);
                    $mounth = substr($dateFirstFormat, 5, 2);
                    $day = substr($dateFirstFormat, 8, 2);
                }
                elseif (preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#", $dateFirstFormat))
                {
                    $year = substr($dateFirstFormat, 6, 4);
                    $mounth = substr($dateFirstFormat, 3, 2);
                    $day = substr($dateFirstFormat, 0, 2);
                }
                else
                {
                    echo "dans getTimePub, ne match avec rien !!!" . $dateFirstFormat;
                }
                $time = substr($dateFirstFormat, 11, 5);
                $dateFinalFormat = $year . '-' . $mounth . '-' . $day . ' ' . $time;

                return $dateFinalFormat;
            }
        }
        public function getDateTimeExp()
        {
            $dateFirstFormat = $this->_dateTimeExp;
            
            if ($dateFirstFormat == null)
                return null;
            else
            {
                if (preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $dateFirstFormat))
                {
                    $year = substr($dateFirstFormat, 0, 4);
                    $mounth = substr($dateFirstFormat, 5, 2);
                    $day = substr($dateFirstFormat, 8, 2);
                }
                elseif (preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#", $dateFirstFormat))
                {
                    $year = substr($dateFirstFormat, 6, 4);
                    $mounth = substr($dateFirstFormat, 3, 2);
                    $day = substr($dateFirstFormat, 0, 2);
                }
                else
                {
                    echo "dans getTimePub, ne match avec rien !!!" . $dateFirstFormat;
                }
                $time = substr($dateFirstFormat, 11, 5);
                $dateFinalFormat = $year . '-' . $mounth . '-' . $day . ' ' . $time;

                return $dateFinalFormat;
            }
        }
        public function getContent()
        {
            return $this->_content;
        }
        public function getRemoved()
        {
            return $this->_removed;
        }

        // mutateurs
        public function setTitle($title)
        {
            // verification type
            if (! is_string($title))
            {
                trigger_error('le title du post n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
                return;
            }
            // verification taille
            if (strlen($title) > 120)
            {
                trigger_error('le title du post n\'a pu être modifié, le paramètre étant une chaîne de caractères trop longue.', E_USER_WARNING);
                return;
            }

            $this->_title = $title;
        }
        
        public function setDateTimePub($dateTimePub)
        {
            $this->_dateTimePub = $dateTimePub;
        }
        
        public function setDateTimeExp($dateTimeExp)
        {
            $this->_dateTimeExp = $dateTimeExp;
        }

        public function setContent($content)
        {
            if (! is_string($content))
            {
                trigger_error('le content du post n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_content = $content;
        }
        
        public function setRemoved($bool)
        {
            $this->_removed = $bool;
        }
    }