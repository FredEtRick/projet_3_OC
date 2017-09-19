<?php
    echo 'entré dans Billet.php'

    //classe billets = articles postés, morceaux de livre
    class Billet
    {
        // attributs
        private $_titre;
        // private $_dateHeurePub;
        private $_contenu;

        const DEBUT_TITRES = "titre : "; // juste pour l'entrainement

        private static $_total = 0; // juste pour l'entrainement

        // constructeur
        public function __construct($titre/*, $dateHeurePub*/, $contenu)
        {
            echo 'constructeur ' . $titre . ' ' . $contenu . '<br />';
            $this->setTitre($titre);
            // $this->setDateHeurePub($dateHeurePub);
            $this->setContenu($contenu);
        }

        // accesseurs
        public function getTitre()
        {
            return this->_titre;
        }
        /*public function getDateHeurePub()
        {
            return this->_dateHeurePub;
        }*/
        public function getContenu()
        {
            return this->_contenu;
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