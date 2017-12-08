<?php
class Routeur
{
    public function router($lesBillets, $commentaireManager, $lesCommentaires, $lesUtilisateurs)
    {
        if(isset($_GET['titre']))
        {
            foreach($lesBillets as $billet)
            {
                if (strip_tags($_GET['titre']) == str_replace(' ', '_', $billet->getTitre()))
                {
                    $leBillet = $billet;
                    $lesCommentaires = $commentaireManager->recupererTousComsSurUnBillet($billet->getTitre());
                }
            }
        }

        if(isset($_GET['titre']) AND ($leBillet != null))
        {
            try
            {
                require $_SERVER['DOCUMENT_ROOT'] . '/vue/billetVue.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            } 
            afficherBilletComplet($leBillet);
            afficherCommentaires($lesCommentaires);
        }

        elseif(isset($_GET['page']) AND is_numeric($_GET['page']) AND $_GET['page'] <= (ceil(count($lesBillets) / 5)))
        {
            try
            {
                require $_SERVER['DOCUMENT_ROOT'] . '/vue/afficherBillets.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
            afficherBillets($lesBillets, (5 * ((int) strip_tags($_GET['page']) - 1)), 5);
        }

        
        
        else
        {
            try
            {
                require $_SERVER['DOCUMENT_ROOT'] . '/vue/afficherBillets.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
            afficherBillets($lesBillets, 0, 5);
        }
    }
}