<?php
    function afficherBilletComplet($billet)
    {
        echo '<section class="row">';
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            $longueurTexte = mb_strlen($billet->getContenu());
            //$pages = array(); // TODO : créer des blocs de (3000 ?) caractères par pages puis afficher les pages avec les classes ci dessous !!! créer un système de pages comme a la page d'accueil ? Ou mettre les pages les unes sous les autres ? Autre idée : ajouter <span> au debut, </span><span class="mobile"> tous les 750, </span>. ou alors js
?>
<script>
    var texte = <?php echo $billet->getContenu(); ?>;
    var pages = new Array();
    var caractereDeb = 0;
    var caractereFin = 0;
    if (window.innerWidth < 576px)
    {
        while (caractere < texte.length)
        {
            caractereFin = caractereDeb + 750; // modif ? fin texte avant ?
            while ()
            {
                // TODO : vérif espaces et fin de texte
            }
        }
    }
    else if (window.innerWidth < 768px)
    {
        
    }
    else if (window.innerWidth < 992px)
    {
        
    }
    else if (window.innerWidth < 1200px)
    {
        
    }
    else if (window.innerWidth < 1500px)
    {
        
    }
    else
    {
        
    }
</script>
<?php
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p>' . $billet->getContenu() . '</p>';
            echo '</article>';
        }
        else
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>Billet expiré</p>';
            echo '</article>';
        }
        echo '</section>';
        afficherCommentaires($billet);
    }
    function afficherCommentaires($billet)
    {
        // TODO : ramasser tous les commentaires relatif au billet dans un tableau
        echo '<section class="row">';
        // TODO : afficher les commentaires (avec appel d'une autre fonction peut être)
        echo '</section>';
    }
?>