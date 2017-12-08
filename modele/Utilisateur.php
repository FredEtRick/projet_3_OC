<?php
    // manager de la classe Utilisateur
    class UtilisateurManager
    {
        private $_BDD;
        
        public function __construct($BDD)
        {
            $this->setBDD($BDD);
        }
        
        public function setBDD($BDD)
        {
            $this->_BDD = $BDD;
        }
        
        public function inserer(Utilisateur $utilisateur)
        {
            $requete = $this->_BDD->prepare('INSERT INTO Utilisateur (login, mdp) VALUES (:login, :mdp)');
            $requete->bindValue(':login', $utilisateur->getLogin());
            $requete->bindValue(':mdp', $utilisateur->getMdp());
            
            $requete->execute();
        }
        
        public function recuperer($login)
        {
            $requete = $this->_BDD->query('SELECT login, mdp FROM Utilisateur WHERE login = "' . $login . '"');
            return new Utilisateur($requete->fetch(PDO::FETCH_ASSOC));
        }
        
        public function recupererTous()
        {
            $utilisateurs = [];
            $requete = $this->_BDD->query('SELECT login, mdp FROM Utilisateur');
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $utilisateurs[] = new Utilisateur($donnees);
            }
            return $utilisateurs;
        }
        
        public function modifierMdp(Utilisateur $utilisateur) // note : devra modifier le mdp dans l'objet avant d'appeler la fonction pour appliquer le changement à la BDD
        {
            $requete = $this->_BDD->prepare('UPDATE Utilisateur SET mdp = :mdp WHERE login = :login');

            $requete->bindValue(':login', $billet->getLogin());
            $requete->bindValue(':mdp', $billet->getMdp());
            
            $requete->execute();
        }
        
        public function supprimer($login)
        {
            $this->_BDD->exec('DELETE FROM Billet WHERE login = "' . $login . '"');
        }
    }

    //classe billets = articles postés, morceaux de livre
    class Utilisateur
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