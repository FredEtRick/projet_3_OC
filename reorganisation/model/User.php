<?php
    require_once 'Model.php';

    // manager de la classe User
    class UserManager extends Model
    {
        public function insert(User $user)
        {
            $query = $this->_DB->prepare('INSERT INTO User (login, password) VALUES (:login, :password)');
            $query->bindValue(':login', $user->getLogin());
            $query->bindValue(':password', $user->getMdp());
            
            $query->execute();
        }
        
        public function getUser($login)
        {
            $query = $this->_DB->query('SELECT login, password FROM User WHERE login = "' . $login . '"');
            return new User($query->fetch(PDO::FETCH_ASSOC));
        }
        
        public function getAllUsers()
        {
            $users = [];
            $query = $this->_DB->query('SELECT login, password FROM User');
            while($userFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                $users[] = new User($userFromSQL);
            }
            return $users;
        }
        
        public function modifyPassword(User $user) // note : devra modifier le password dans l'objet avant d'appeler la fonction pour appliquer le changement à la DB
        {
            $query = $this->_DB->prepare('UPDATE User SET password = :password WHERE login = :login');

            $query->bindValue(':login', $billet->getLogin());
            $query->bindValue(':password', $billet->getMdp());
            
            $query->execute();
        }
        
        public function deleteUser($login)
        {
            $this->_DB->exec('DELETE FROM Billet WHERE login = "' . $login . '"');
        }
    }

    //classe billets = articles postés, morceaux de livre
    class User
    {
        // attributs
        private $_login;
        private $_password;

        // constructeur
        public function __construct()
        {
            $argsNumber = func_num_args();
            $args = func_get_args();
            //$cpt = 0;
            //$setters = array("setLogin", "setMdp");
            if (is_array($args[0]) && $argsNumber == 1)
                $this->hydrate($args[0]);
            else
            {
                $this->setLogin($args[0]);
                $this->setMdp($args[1]);
            }
        }
        
        public function hydrate(array $userFromSQL)
        {
            foreach($userFromSQL as $key => $value)
            {
                $methode = 'set' . ucfirst($key);
                if (method_exists($this, $methode))
                    $this->$methode($value);
            }
        }

        // accesseurs
        public function getLogin()
        {
            return $this->_login;
        }
        public function getPassword()
        {
            return $this->_password;
        }

        // mutateurs
        public function setLogin($login)
        {
            if (! is_string($login))
            {
                trigger_error('le contenu du commentaire n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_login = $login;
        }
        public function setPassword($password)
        {
            $this->_password = $password;
        }
    }
?>