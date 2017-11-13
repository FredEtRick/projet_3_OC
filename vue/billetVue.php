<?php
    function afficherBilletComplet($billet)
    {
        echo '<section class="row">';
        if (date('d/m/Y H:i:s') < $billet->getDateHeureExp() || $billet->getDateHeureExp() == NULL)
        {
            $longueurTexte = mb_strlen($billet->getContenu());
            //$pages = array(); // TODO : créer des blocs de (3000 ?) caractères par pages puis afficher les pages avec les classes ci dessous !!! créer un système de pages comme a la page d'accueil ? Ou mettre les pages les unes sous les autres ? Autre idée : ajouter <span> au debut, </span><span class="mobile"> tous les 750, </span>. ou alors js
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>' . $billet->getTitre() . ' - ' . $billet->getDateHeurePub() . '</p>';
            echo '<p id="contenu">' . $billet->getContenu() . '</p>';
            // pagination
            echo '<p id="reduire"></p><p id="rallonger"></p>';
            echo '</article>';
        }
        else
        {
            echo '<article class="col-xxl-6 col-xl-12 col-sm-12">';
            echo '<p>Billet expiré</p>';
            echo '</article>';
        }
        echo '</section>';
        $avecSauts = htmlspecialchars($billet->getContenu());
        $avecSauts = nl2br($avecSauts);
        $avecSauts=str_replace(array("\r", "\n"), array('', ''), $avecSauts);
        //afficherCommentaires($billet);
?>
<script type="text/javascript">
    
    // TODO : GERER SAUTS LIGNES DANS MON ALGO !!!!!!!! C'est l'erreur actuelle je crois
    
    var texte = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($avecSauts))); ?>';
    var pages = new Array();
    var caractereDeb = 0; // indice du premier caractère qui doit apparaitre dans la page
    var caractereFin = texte.length; // indice du dernier
    // TODOD : ou alors remplacer tout ce qui suit par qqch qui calcul en temps réel hauteur et largeur dispo, qui calcul le nombre de caractères max qu'on peut y mettre et fait en fonction
    var contenuPageElt = document.getElementById('contenu');
    var contenuPage = contenuPageElt.innerHTML;
    var reduireElt = document.getElementById('reduire');
    function getPositionTop (obj) // fonction qui renvoie position verticale élément dans page, récupérée ici : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
    {
		var curtop = 0;
		if (obj.offsetParent)
        {
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {curtop += obj.offsetTop;}
		}
		return curtop;
	}
    contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
    contenuPageElt.innerHTML = contenuPage;
    var positionReduireElt = getPositionTop(reduireElt);
    console.log(caractereFin + ' ' + caractereDeb + ' ' + window.innerHeight + ' ' + positionReduireElt);
    // TODO : modifier, estimer le nombre de caractères en trop
    var nbCharsLigneApprox = 0; // nombre approximatif de cars dans une ligne, approximatif car a plus large que i par ex
    var hauteurLigne = 0; // hauteur d'une ligne en px
    if ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt))
    {
        // NOTE : premier while s'effectue qu'une fois quoi que je fasse !!! getPosition augmente ??? Dafuq
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt) && (positionReduireElt == getPositionTop(reduireElt))) // vider la dernière ligne avant de calculer la longueur d'une ligne
        {
            console.log(caractereFin + ' ' + caractereDeb + ' ' + window.innerHeight + ' ' + positionReduireElt + ' ' + getPositionTop(reduireElt) + ' premier while');
            caractereFin--;
            while (texte.substr(caractereFin-2, 2).indexOf('\\') != -1)
            {
                console.log('ICI');
                caractereFin -= 2;
            }
            contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            if (positionReduireElt > getPositionTop(reduireElt))
            {
                hauteurLigne = positionReduireElt - getPositionTop(reduireElt);
            }
            console.log(caractereFin + ' ' + caractereDeb + ' ' + window.innerHeight + ' ' + positionReduireElt + ' ' + getPositionTop(reduireElt) + ' premier while fin');
        }
        positionReduireElt = getPositionTop(reduireElt);
        var sautLigne = false;
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt) && (positionReduireElt == getPositionTop(reduireElt)) && !sautLigne) // vérif si réduc suffit (premiere partie du if), sinon calcul nb chars dans une ligne
        {
            if (texte.substr(caractereFin-6, 6).indexOf('<') != -1)
            {
                caractereFin -= 6;
                sautLigne = true;
            }
            else
            {
                console.log(caractereFin + ' ' + nbCharsLigneApprox + ' second while');
                caractereFin--;
                while (texte.substr(caractereFin-2, 2).indexOf('\\') != -1)
                {
                    caractereFin -= 2; // modif pour appostrophes, retire 6 et compte juste un là
                    nbCharsLigneApprox++;
                }
                nbCharsLigneApprox++;
            }
            contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
        }
        positionReduireElt = getPositionTop(reduireElt);
        /*var hauteurExcedente = positionReduireElt - window.innerHeight;
        var nbLignesExcedentes = Math.floor(hauteurExcedente / hauteurLigne) - 1; // Une ligne de sécurité car nbCharLigneApprox est approximatif. Si on a trop bouffé de lignes, l'algo qui remet les manquantes devrait réparer juste après (pas oublier de le faire !!!)
        //var nbCaracteresExcedents = nbCharsLigneApprox * nbLignesExcedentes;*/
        while (getPositionTop(reduireElt) > window.innerHeight)
        {
            console.log(getPositionTop(reduireElt) + ' ' + window.innerHeight + ' supprLignes');
            if (texte.substr(caractereFin-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
            {
                caractereFin = caractereDeb + caractereFin - Math.ceil(nbCharsLigneApprox*1,25) + texte.substr(caractereFin-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
            }
            else
            {
                caractereFin -= nbCharsLigneApprox;
            }
            contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
        }
        caractereFin += nbCharsLigneApprox; // au cas où on ait un peu trop retiré
        //caractereFin -= nbCaracteresExcedents;
        //console.log('nbCharsLigneApprox : ' + nbCharsLigneApprox + ' hauteurLigne : ' + hauteurLigne + ' positionReduireElt : ' + positionReduireElt + ' hauteurExcedente : ' + hauteurExcedente + ' nbLignesExcedentes : ' + nbLignesExcedentes + ' nbCaracteresExcedents : ' + nbCaracteresExcedents);
        contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
        contenuPageElt.innerHTML = contenuPage;
        positionReduireElt = getPositionTop(reduireElt);
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt)) // si id reduire n'est pas visible, réduire le texte.
        {
            console.log(caractereFin);
            caractereFin -= 10; // par 10 pour aller plus vite sans que ce soit génant
            while (texte.substr(caractereFin-6, 6).indexOf('<') != -1)
            {
                caractereFin = caractereFin - 6 + texte.substr(caractereFin-6, 6).indexOf('<') - 1;
            }
            while (texte.substr(caractereFin-2, 2).indexOf('\\') != -1)
            {
                caractereFin = caractereFin - 2 + texte.substr(caractereFin-2, 2).indexOf('\\') - 1;
            }
            contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            var positionReduireElt = getPositionTop(reduireElt);
        }
        if (texte.substr(caractereFin-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste avant le premier d'entre eux
        {
            console.log('FIN 1 !!!');
            console.log(caractereFin);
            caractereFin = caractereFin - 16 + texte.substr(caractereFin-16, 32).indexOf('<br') - 1;
            console.log(caractereFin + ' ' + texte.charAt(caractereFin));
        }
        else
        {
            console.log('FIN 2 !!!');
            do
            {
                console.log(caractereFin);
                caractereFin--;
            } while ((caractereFin > caractereDeb + 150) && (texte.charAt(caractereDeb + caractereFin) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
        contenuPageElt.innerHTML = contenuPage;
        var positionReduireElt = getPositionTop(reduireElt);
    }
    /*if (window.innerWidth < 576px)
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
        
    }*/
</script>
<?php
    }
    /*function afficherCommentaires($billet)
    {
        // TODO : ramasser tous les commentaires relatif au billet dans un tableau
        echo '<section class="row">';
        // TODO : afficher les commentaires (avec appel d'une autre fonction peut être)
        echo '</section>';
    }*/
?>