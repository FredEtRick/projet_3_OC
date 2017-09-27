<?php
    echo 'entré dans Billet.php'; // ce message n'est jamais affiché !!!

    // manager de la classe billet
    class BilletManager
    {
        const BDD = new PDO('mysql:host=localhost:8888;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        const TABLE = "Billet";
        
        const TITRE = "titre";
        const DATE_HEURE_PUB = "dateHeurePub";
        const DATE_HEURE_EXP = "dateHeureExp";
        const CONTENU = "contenu";
        
        /*public function setBDD($BDD)
        {
            $this->BDD = $BDD;
        }*/
        
        /*public function __construct()
        {
            $nombre = func_num_args();
            $args = func_get_args();
            if ($nombre > 0)
                $this->setBDD($args[0]);
        }*/
        
        public static function inserer(Billet $billet)
        {
            $requete = (self::BDD)->prepare('INSERT INTO :table (:titreBDD, :dateHeurePubBDD, :dateHeureExpBDD, :contenuBDD) VALUES (:titreObj, :dateHeurePubObj, :dateHeureExpObj, :contenuObj)');
            $requete->bindValue(':table', TABLE);
            $requete->bindValue(':titreBDD', TITRE);
            $requete->bindValue(':dateHeurePubBDD', DATE_HEURE_PUB);
            $requete->bindValue(':dateHeureExpBDD', DATE_HEURE_EXP);
            $requete->bindValue(':contenuBDD', CONTENU);
            $requete->bindValue(':titreObj', $billet->getTitre());
            $requete->bindValue(':dateHeurePubObj', $billet->getDateHeurePub());
            $requete->bindValue(':dateHeureExpObj', $billet->getDateHeureExp());
            $requete->bindValue(':contenuObj', $billet->getContenu());
            
            $requete->execute();
        }
        
        public static function recuperer($titre)
        {
            $requete = (self::BDD)->query('SELECT * FROM Billet WHERE titre = "' . $titre . '"');
            return new Billet($requete->fetch(PDO::FETCH_ASSOC));
        }
        
        public static function recupererTous()
        {
            $billets = [];
            $requete = (self::BDD)->query('SELECT * FROM Billets');
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $billets[] = new Billet($donnees);
            }
            return Billets;
        }
        
        public static function modifier(Billet $billet)
        {
            $requete = (self::BDD)->prepare('UPDATE Billet SET :titreBDD = :titreObj, :dateHeurePubBDD = :dateHeurePubObj, :dateHeureExpBDD = :dateHeureExpObj, :contenuBDD = :contenuObj WHERE :titreBDD = :titreObj');

            $requete->bindValue(':table', TABLE);
            $requete->bindValue(':titreBDD', TITRE);
            $requete->bindValue(':dateHeurePubBDD', DATE_HEURE_PUB);
            $requete->bindValue(':dateHeureExpBDD', DATE_HEURE_EXP);
            $requete->bindValue(':contenuBDD', CONTENU);
            $requete->bindValue(':titreObj', $billet->getTitre());
            $requete->bindValue(':dateHeurePubObj', $billet->getDateHeurePub());
            $requete->bindValue(':dateHeureExpObj', $billet->getDateHeureExp());
            $requete->bindValue(':contenuObj', $billet->getContenu());
            
            $requete->execute();
        }
        
        public static function supprimer($titre)
        {
            (self::BDD)->exec('DELETE FROM Billet WHERE titre = "' . $titre . '"');
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
            return $this->_dateHeurePub;
        }
        public function getDateHeureExp()
        {
            return $this->_dateHeureExp;
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

            $this->_titre = 'billet numéro ' . self::$_total . '. ' . self::DEBUT_TITRES . $titre; // juste pour m'entrainer avec self:: etc
        }
        
        public function setDateHeurePub(DateTime $dateHeurePub)
        {
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
            $this->contenu = $contenu;
        }
    }
?>