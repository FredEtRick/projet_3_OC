<?php
    echo 'entré dans Billet.php'; // ce message n'est jamais affiché !!!

    // manager de la classe billet
    class BilletManager
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
        
        public function inserer(Billet $billet)
        {
            $requete = $this->_BDD->prepare('INSERT INTO Billet (titre, dateHeurePub, dateHeureExp, contenu) VALUES (:titre, :dateHeurePub, :dateHeureExp, :contenu)');
            $requete->bindValue(':titre', $billet->getTitre());
            $requete->bindValue(':dateHeurePub', $billet->getDateHeurePub());
            $requete->bindValue(':dateHeureExp', $billet->getDateHeureExp());
            $requete->bindValue(':contenu', $billet->getContenu());
            
            $requete->execute();
        }
        
        //DATE_FORMAT(dateHeurePub, \'%m/%c/%Y à %H:%i:%s\') AS DHP, DATE_FORMAT(dateHeureExp, \'%m/%c/%Y à %H:%i:%s\') AS DHE
        
        public function recuperer($titre)
        {
            $requete = $this->_BDD->query('SELECT titre, dateHeurePub, dateHeureExp, contenu FROM Billet WHERE titre = "' . $titre . '"');
            return new Billet($requete->fetch(PDO::FETCH_ASSOC));
        }
        
        public function recupererTous()
        {
            $billets = [];
            $requete = $this->_BDD->query('SELECT titre, dateHeurePub, dateHeureExp, contenu FROM Billet');
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $billets[] = new Billet($donnees);
            }
            return $billets;
        }
        
        public function modifier(Billet $billet)
        {
            $requete = $this->_BDD->prepare('UPDATE Billet SET titre = :titre, dateHeurePub = :dateHeurePub, dateHeureExp = :dateHeureExp, contenu = :contenu WHERE titre = :titre');

            $requete->bindValue(':titre', $billet->getTitre());
            $requete->bindValue(':dateHeurePub', $billet->getDateHeurePub());
            $requete->bindValue(':dateHeureExp', $billet->getDateHeureExp());
            $requete->bindValue(':contenu', $billet->getContenu());
            
            $requete->execute();
        }
        
        public function supprimer($titre)
        {
            $this->_BDD->exec('DELETE FROM Billet WHERE titre = "' . $titre . '"');
        }
    }

    //classe billets = articles postés, morceaux de livre
    class Billet
    {
        // attributs
        private $_titre;
        private $_dateHeurePub;
        private $_dateHeureExp;
        private $_contenu;

        // const DEBUT_TITRES = "titre : "; // juste pour l'entrainement

        // private static $_total = 0; // juste pour l'entrainement

        // constructeur
        public function __construct()
        {
            $nombre = func_num_args();
            $args = func_get_args();
            $cpt = 0;
            $setters = array("setTitre", "setDateHeurePub", "setDateHeureExp", "setContenu");
            if (is_array($args[0]) && $nombre == 1)
                $this->hydrate($args[0]);
            else
                while ($cpt < $nombre && $cpt < count($setters))
                {
                    $this->$setters[$cpt]($args[$cpt]);
                    $cpt++;
                }
        }
        
        public function hydrate (array $donnees)
        {
            foreach($donnees as $cle => $valeur)
            {
                $methode = 'set' . ucfirst($cle);
                if (method_exists($this, $methode))
                    $this->$methode($valeur);
            }
        }

        // accesseurs
        public function getTitre()
        {
            return $this->_titre;
        }
        public function getDateHeurePub()
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateHeurePub);
            $date = $date->format('d/m/Y H:i:s');
            return $date;
        }
        public function getDateHeureExp()
        {
            $date = $this->_dateHeureExp;
            if ($this->_dateHeureExp != NULL)
            {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateHeureExp);
                $date = $date->format('d/m/Y H:i:s');
            }
            return $date;
        }
        public function getContenu()
        {
            return $this->_contenu;
        }

        // mutateurs
        public function setTitre($titre)
        {
            // verification type
            if (! is_string($titre))
            {
                trigger_error('le titre du billet n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
                return;
            }
            // verification taille
            if (strlen($titre) > 120)
            {
                trigger_error('le titre du billet n\'a pu être modifié, le paramètre étant une chaîne de caractères trop longue.', E_USER_WARNING);
                return;
            }

            $this->_titre = $titre; // juste pour m'entrainer avec self:: etc
        }
        
        public function setDateHeurePub($dateHeurePub) // là force a prendre un stirng
        {
            // try essayer de caster en dateHeurePub
            $this->_dateHeurePub = $dateHeurePub;
        }
        
        public function setDateHeureExp($dateHeureExp)
        {
            $this->_dateHeureExp = $dateHeureExp;
        }

        public function setContenu($contenu)
        {
            if (! is_string($contenu))
            {
                trigger_error('le contenu du billet n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_contenu = $contenu;
        }
    }
?>