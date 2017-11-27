<?php
    // manager de la classe billet
    class CommentaireManager
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
        
        public function inserer(Commentaire $commentaire)
        {
            $requete = $this->_BDD->prepare('INSERT INTO Commentaire (dateHeure, contenu, titreBillet, pseudoVisiteur) VALUES (:dateHeure, :contenu, :titreBillet, :pseudoVisiteur)');
            $requete->bindValue(':titre', $commentaire->getDateHeure());
            $requete->bindValue(':contenu', $billet->getContenu());
            $requete->bindValue(':titreBillet', $billet->getTitreBillet());
            $requete->bindValue(':pseudoVisiteur', $billet->getPseudoVisiteur());
            
            $requete->execute();
        }
        
        //DATE_FORMAT(dateHeurePub, \'%m/%c/%Y à %H:%i:%s\') AS DHP, DATE_FORMAT(dateHeureExp, \'%m/%c/%Y à %H:%i:%s\') AS DHE
        
        public function recupererTousComsSurUnBillet($titre)
        {
            $requete = $this->_BDD->query('SELECT ID, dateHeure, contenu, titreBillet, pseudoVisiteur FROM Commentaire WHERE titreBillet = "' . $titre . '"');
            $commentaires = [];
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $commentaires[] = new Commentaire($donnees);
            }
            return $commentaires;
        }
        
        /*public function recupererTousSaufExp()
        {
            $billets = [];
            $requete = $this->_BDD->query('SELECT titre, dateHeurePub, dateHeureExp, contenu FROM Billet ORDER BY dateHeurePub');
            while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $billet = new Billet($donnees);
                if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
                    $billets[] = $billet;
            }
            return $billets;
        }
        
        public function modifier(Commentaire $commentaire)
        {
            $requete = $this->_BDD->prepare('UPDATE Billet SET titre = :titre, dateHeurePub = :dateHeurePub, dateHeureExp = :dateHeureExp, contenu = :contenu WHERE titre = :titre');

            $requete->bindValue(':titre', $billet->getTitre());
            $requete->bindValue(':dateHeurePub', $billet->getDateHeurePub());
            $requete->bindValue(':dateHeureExp', $billet->getDateHeureExp());
            $requete->bindValue(':contenu', $billet->getContenu());
            
            $requete->execute();
        }*/
        
        public function supprimer($ID)
        {
            $this->_BDD->exec('DELETE FROM Billet WHERE ID = "' . $ID . '"');
        }
    }

    //classe billets = articles postés, morceaux de livre
    class Commentaire
    {
        // attributs
        private $_ID;
        private $_dateHeure;
        private $_contenu;
        private $_titreBillet;
        private $_pseudoVisiteur;

        // const DEBUT_TITRES = "titre : "; // juste pour l'entrainement

        // private static $_total = 0; // juste pour l'entrainement

        // constructeur
        public function __construct()
        {
            $nombre = func_num_args();
            $args = func_get_args();
            $cpt = 0;
            $setters = array("setDateHeure", "setContenu", "setTitreBillet", "setPseudoVisiteur");
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
        public function getID()
        {
            return $this->_ID;
        }
        public function getDateHeure()
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateHeure);
            $date = $date->format('d/m/Y H:i:s');
            return $date;
        }
        public function getContenu()
        {
            return $this->_contenu;
        }
        public function getTitreBillet()
        {
            return $this->_titreBillet;
        }
        public function getPseudoVisiteur()
        {
            return $this->_pseudoVisiteur;
        }
        
        // mutateurs
        public function setDateHeure($dateHeure) // là force a prendre un stirng
        {
            // try essayer de caster en dateHeurePub
            $this->_dateHeure = $dateHeure;
        }
        public function setContenu($contenu)
        {
            if (! is_string($contenu))
            {
                trigger_error('le contenu du commentaire n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_contenu = $contenu;
        }
        public function setTitreBillet($titre)
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
            $this->_titreBillet = $titre; // juste pour m'entrainer avec self:: etc
        }
        public function setPseudoVisiteur($pseudo)
        {
            $this->_pseudoVisiteur= $pseudo;
        }
    }
?>