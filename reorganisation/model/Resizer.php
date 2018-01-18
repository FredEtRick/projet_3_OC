<?php

class Resizer
{
    // préparation des variables
    var texte = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($avecSauts))); ?>';
    var caractereDeb = 0; // indice du premier caractère qui doit apparaitre dans la page
    var caractereMilieu = 0; // indice du dernier
    // TODO : ou alors remplacer tout ce qui suit par qqch qui calcul en temps réel hauteur et largeur dispo, qui calcul le nombre de caractères max qu'on peut y mettre et fait en fonction
    var caractereFin;
    
    var contenuPageElt = document.getElementById('contenu'); // La balise paragraphe <p> qui contiendra le texte a afficher (le corps du billet)
    var contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1); // Le texte a afficher. Pour le moment, la variable contient tout le billet. Après manipulation, contiendra une page.
    var reduireElt = document.getElementById('reduire');
    var rallongerElt = document.getElementById('rallonger');
    contenuPageElt.innerHTML = contenuPage;
    var positionReduireElt = getPositionTop(reduireElt);
    var positionRallongerElt = getPositionTop(rallongerElt);
    
    var contenuPageElt_2;
    var contenuPage_2;
    var reduireElt_2;
    var rallongerElt_2;
    var positionReduireElt_2;
    var positionRallongerElt_2;
    var difference;
    var parent = document.getElementById('parent');
    var secondVolet;
    
    var contenuPageElt_generique;
    var contenuPage_generique;
    var reduireElt_generique;
    var rallongerElt_generique;
    var positionReduireElt_generique;
    var positionRallongerElt_generique;
    var deb_generique;
    var fin_generique;
    
    var deuxiemePage = false; // vaut true si (largeur > 1500 + on est en train de s'occuper de la seconde page) sert a déterminer s'il faut utiliser (deb et mil) ou (mil et fin) et s'il faut utiliser le premier set de variables ou le second
    
    // TODO : modifier, estimer le nombre de caractères en trop
    var nbCharsLigneApprox = 0; // nombre approximatif de cars dans une ligne, approximatif car a plus large que i par ex
    var hauteurLigne; // hauteur d'une ligne en px
    var hauteurManquante;
    var nbLignesManquantes;
    var nbCaracteresManquants;
    
    var hauteurExcedente;
    var nbLignesExcedentes;
    var nbCaracteresExcedents;
}