<?php
    // manager de la classe User
    class UserManager
    {
        private $_DB;
        
        public function __construct($DB)
        {
            $this->setDB($DB);
        }
        
        public function setDB($DB)
        {
            $this->_DB = $DB;
        }
        // FINIR LA TRADUCTION ET LA CORRECTION !!!!
        public function inserer(User $utilisateur)
        {
            $requete = $this->_DB->prepare('INSERT INTO User (login, mdp) VALUES (:login, :mdp)');
            $requete->bindValue(':login', $utilisateur->getLogin());
            $requete->bindValue(':mdp', $utilisateur->getMdp());
            
            $requete->execute();
        }
        
        public function recuperer($login)
        {
            $requete = $this->_DB->query('SELECT login, mdp FROM User WHERE login = "' . $login . '"');
            return new User($requete->fetch(PDO::FETCH_ASSOC));
        }
        
        public function recupererTous()
        {
            $utilisateurs = [];
            $requete = $this->_DB->query('SELECT login, mdp FROM User');
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $utilisateurs[] = new User($donnees);
            }
            return $utilisateurs;
        }
        
        public function modifierMdp(User $utilisateur) // note : devra modifier le mdp dans l'objet avant d'appeler la fonction pour appliquer le changement à la DB
        {
            $requete = $this->_DB->prepare('UPDATE User SET mdp = :mdp WHERE login = :login');

            $requete->bindValue(':login', $billet->getLogin());
            $requete->bindValue(':mdp', $billet->getMdp());
            
            $requete->execute();
        }
        
        public function supprimer($login)
        {
            $this->_DB->exec('DELETE FROM Billet WHERE login = "' . $login . '"');
        }
    }

    //classe billets = articles postés, morceaux de livre
    class User
    {
        // attributs
        private $_login;
        private $_mdp;

        // constructeur
        public function __construct()
        {
            $nombre = func_num_args();
            $args = func_get_args();
            //$cpt = 0;
            //$setters = array("setLogin", "setMdp");
            if (is_array($args[0]) && $nombre == 1)
                $this->hydrate($args[0]);
            else
            {
                $this->setLogin($args[0]);
                $this->setMdp($args[1]);
            }
        }
        
        public function hydrate(array $donnees)
        {
            foreach($donnees as $cle => $valeur)
            {
                $methode = 'set' . ucfirst($cle);
                if (method_exists($this, $methode))
                    $this->$methode($valeur);
            }
        }

        // accesseurs
        public function getLogin()
        {
            return $this->_login;
        }
        public function getMdp()
        {
            return $this->_mdp;
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
        public function setMdp($mdp)
        {
            $this->_mdp = $mdp;
        }
    }
?>