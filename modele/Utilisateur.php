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
            $requete->bindValue(':login', $billet->getLogin());
            $requete->bindValue(':mdp', $billet->getMdp());
            
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
        public function __construct(array $donnees) // hydrate direct dans construct
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
            $this->_login = $login;
        }
        public function setMdp($mdp)
        {
            $this->_mdp = $mdp;
        }
    }
?>