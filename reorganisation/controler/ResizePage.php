<!--
    A REECRIRE !!!!!!!!!!!!!
    - passer en anglais
    - corriger noms variables en fonction des autres fichiers (ex : $avecSauts n'existe plus)
    - subdiviser le code et le rendre plus digeste
    - passer en objet ?
    - peut être lui même divisé en MVC ??? Je vois mal la vue, mais en objet quasi tout passe dans le modèle, et les exécutions dans le controleur
    - ou alors, la vue est onePostView !!! visitorControler devient allPostsControler, et resizePage devient onePostControler !!!
    - ou alors, passer tout le fichier en modèle en le transformant en classe, puis inclure le modèle dans visitorControler, puis appeler les methodes dans visitorControler.
    - problème : c'est un script JS, pas une classe PHP !

    Verdict : ce serait trop compliqué de me mettre aux classes en JS, donc je vais laisser comme ça.
-->



<!--
    TODO :
    - écrire un read me ou autre dans ce fichier pour expliquer le fonctionnement global du resizer ?
    - ajouter un schéma qui indique l'ordre d'appel des fonctions ? : non
    - afficher erreurs dans localhost:8888 et corriger
    - m'occuper de l'administration
    - mettre les fichiers appelés dans un sous dossier "resizePage" qui se situerait dans controler
-->

<?php
    require_once "controler/resizer/preparing.php";
    require_once "controler/resizer/vars.php";
    require_once "controler/resizer/starting.php";
    require_once "controler/resizer/forStartAndNextPage.php";
    require_once "controler/resizer/nextPage.php";
    require_once "controler/resizer/previousPage.php";
?>

<script type="text/javascript">
    
    
    // FIRST RESIZING - when "opening" the post. Functions in "Resizer_starting.php" and "Resizer_forStartAndNextPage.php". Those functions themselves use functions in "Resizer_preparing.php".
    countCharsLine();
    addLotOfLines();
    reduct10by10();
    cleanEnding();
    startingSecondPage();
    
    // CHANGING PAGE RESIZING - resizing again when changing pages of post with "next page" and "previous page" buttons.
    previousButtonElt.setAttribute('onclick', 'previousPage()'); // Functions in "Resizer_previousPage.php". Those functions themselves use functions in "Resizer_preparing.php".
    nextButtonElt.setAttribute('onclick', 'nextPage()'); // Functions in "Resizer_nextPage.php" and "Resizer_forStartAndNextPage.php". Those functions themselves use functions in "Resizer_preparing.php".

</script>