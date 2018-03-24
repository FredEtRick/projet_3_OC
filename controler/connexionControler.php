<?php
    /*
        création du tout premier compte, avec mdp haché
        $utilisateur = new Utilisateur('auteur', sha1('gzOC@0603'));
        $utilisateurManager->inserer($utilisateur);
        // note : le mot de passe est donc OC@0603 ! le gz n'est pas inclus dedans, c'est juste les caractères supplémentaires automatiquement ajoutés dedans pour aider sha1 a noyer le poisson
    */

    require_once('model/User.php');

    class ConnexionControler
    {
        private $_connexionUserManager;
        
        public function __construct()
        {
            $this->_connexionUserManager = new UserManager();
        }
        
        public function connexionForm()
        {
            $pageTitle = 'connexion à l\'administration';
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/connexionView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
        
        public function tryConnexion()
        {
            try
            {
                $allUsers = $this->_connexionUserManager->getAllUsers();
                $activeUser = null;
                foreach($allUsers as $currentUser)
                {
                    if ((strip_tags($_POST['login']) == $currentUser->getLogin()) && (strip_tags(sha1('gz' . $_POST['password'])) == $currentUser->getPassword()))
                    {
                        $activeUser = $currentUser;
                    }
                }
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
            if ($activeUser != null)
            {
                /*$_SESSION['login'] = $_POST['login'];
                $_SESSION['password'] = sha1('gz' . $_POST['password']);*/
                $_SESSION['action'] = 'postsManagment';
                // gérer plus tard aussi avec des cookies si coche case "mémoriser"
?>
<script type="text/javascript">
    document.location.href="index.php";
</script>
<?php
            }

            else
            {
                try
                {
?>
<script type="text/javascript">
    document.location.href="index.php?action=connexion&error=true";
</script>
<?php
                }
                catch (Exception $e)
                {
                    echo '<p>erreur : ' . $e->getMessage() ; '</p>';
                }
            }
        }
    }
?>