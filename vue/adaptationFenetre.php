<?php
    $avecSauts = htmlspecialchars($billet->getContenu());
    $avecSauts = nl2br($avecSauts);
    $avecSauts = str_replace(array("\r", "\n"), array('', ''), $avecSauts);
?>
<script type="text/javascript">
    
    console.log('ICI');
    /* TODO : 
        - séparer en fonction
        - bien commenter
        - trouver ligne avec des allers retours de complexité logarithmique, en allant trop loin, en revenant de moitié, repartant du quart et ainsi de suite
        - redéclencher adaptation texte à la fin des redimensionnements (si pas possible de faire plus simple, créer une variable qui passe a true quand on redimensionne, attendre une seconde, voir si on est toujours en train de redimensionner)
        - adapter en ajoutant texte à la fin si possible plutot qu'au début
        - créer juste des flêches page suivante / précédente pour naviguer, sans numéro de page, trop compliqué avec redimensionnement le nombre de pages change tout le temps.
            - Ne pas présenter flêche précédent si au début ou flêche suivant si a la fin.
            - Si a la fin, flêche précédent met fin au début, puis remonte déb ligne par ligne jusqu'à dépasser puis revient en arrière caractère par caractère. Si atteind début, remettre des lignes a la fin. Inversement si au début et veut faire suivant.
            - Si on touche ni le début ni la fin, pour précédent, faire baisser déb et fin de fin-déb, puis faire remonter déb si texte prend trop de place, sinon faire baisser déb jusqu'à la limite. Inversement pour suivant. Si atteint début texte ou fin, pareil, faire repartir de l'autre côté jusqu'à remplir.
        - mémoriser dans une variable session le premier caractère de la page où on s'est arrêté ? Si quitte, lecteur pourra revenir dessus.
        Créer des micro repères tous les 1000 caractères ? Permettra de remplacer le marque page vu que les pages sont aléatoires, pourra dire "je veux aller au 18ème repère" par ex (micro repères seront indiqués a gauche en marge de la ligne du caractère correspondant)
        - créer un champs en bas entre les deux flêches dans lequel utilisateur peut entrer un numéro de repère pour s'y rendre directement
        - m'occuper du cas xxl !!!! scinder en deux parties
        - ... Je sais plus
    */
    
    // fonction qui renvoie position verticale élément dans page, récupérée ici : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
    function getPositionTop (obj)
    {
		var curtop = 0;
		if (obj.offsetParent)
        {
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {curtop += obj.offsetTop;}
		}
		return curtop;
	}
    
    // préparation des variables
    var texte = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($avecSauts))); ?>';
    var caractereDeb = 0; // indice du premier caractère qui doit apparaitre dans la page
    var caractereFin = texte.length; // indice du dernier
    // TODO : ou alors remplacer tout ce qui suit par qqch qui calcul en temps réel hauteur et largeur dispo, qui calcul le nombre de caractères max qu'on peut y mettre et fait en fonction
    var contenuPageElt = document.getElementById('contenu'); // La balise paragraphe <p> qui contiendra le texte a afficher (le corps du billet)
    var contenuPage = contenuPageElt.innerHTML; // Le texte a afficher. Pour le moment, la variable contient tout le billet. Après manipulation, contiendra une page.
    var reduireElt = document.getElementById('reduire');
    contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
    contenuPageElt.innerHTML = contenuPage;
    var positionReduireElt = getPositionTop(reduireElt);
    // TODO : modifier, estimer le nombre de caractères en trop
    var nbCharsLigneApprox = 0; // nombre approximatif de cars dans une ligne, approximatif car a plus large que i par ex
    var hauteurLigne = 0; // hauteur d'une ligne en px
    var sautLigne = false;
    
    function debuger(fonction)
    {
        console.log('fonction : ' + fonction + ' caractereDeb : ' + caractereDeb + ' caractereFin : ' + caractereFin + ' positionReduireElt : ' + positionReduireElt + ' nbCharsLigneApprox : ' + nbCharsLigneApprox + ' hauteurLigne : ' + hauteurLigne + ' sautLigne : ' + sautLigne);
    }
    
    // regarde si le texte "déborde" de la fenêtre, et adapte le texte a la fenêtre si besoin
    if ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt))
    {
        adapter();
    }
    
    function viderLigne() // vider la dernière ligne avant de calculer la longueur d'une ligne
    {
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt) && (positionReduireElt == getPositionTop(reduireElt)))
        {
            caractereFin--;
            while (texte.substr(caractereFin-2, 2).indexOf('\\') != -1)
            {
                caractereFin -= 2;
            }
            contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            if (positionReduireElt > getPositionTop(reduireElt))
            {
                hauteurLigne = positionReduireElt - getPositionTop(reduireElt);
            }
            debuger('viderLigne');
        }
        positionReduireElt = getPositionTop(reduireElt);
    }
    
    function compterCharsLigne() // Compte le nombre de chars dans une ligne (varie d'une ligne a l'autre mais permet de s'en rapprocher avec un exemple d'une ligne pleine)
    {
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt) && (positionReduireElt == getPositionTop(reduireElt)) && !sautLigne) 
        {
            if (texte.substr(caractereFin-6, 6).indexOf('<') != -1)
            {
                caractereFin -= 6;
                sautLigne = true;
            }
            else
            {
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
            debuger('compterCharsLigne');
        }
        positionReduireElt = getPositionTop(reduireElt);
    }
    
    function supprLignes()
    {
        while (getPositionTop(reduireElt) > window.innerHeight)
        {
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
            debuger('supprLignes');
        }
        caractereFin += nbCharsLigneApprox; // au cas où on ait un peu trop retiré
        contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
        contenuPageElt.innerHTML = contenuPage;
        positionReduireElt = getPositionTop(reduireElt);
    }
    
    function reduction10par10()
    {
        while ((caractereFin > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt)) // si id reduire n'est pas visible, réduire le texte.
        {
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
            positionReduireElt = getPositionTop(reduireElt);
            debuger('reduction10');
        }
    }
    
    function decoupagePropre()
    {
        if (texte.substr(caractereFin-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste avant le premier d'entre eux
        {
            caractereFin = caractereFin - 16 + texte.substr(caractereFin-16, 32).indexOf('<br') - 1;
            debuger('decoupagePropreBr');
        }
        else
        {
            do
            {
                caractereFin--;
                debuger('decoupagePropreChars');
            } while ((caractereFin > caractereDeb + 150) && (texte.charAt(caractereDeb + caractereFin) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        contenuPage = texte.substr(caractereDeb, caractereFin-caractereDeb+1);
        contenuPageElt.innerHTML = contenuPage;
        positionReduireElt = getPositionTop(reduireElt);
    }
    
    function adapter() // adapte le texte a la place dispo dans la fenêtre, présente une page
    {
        // note : code divisé pour plus de clarté
        
        // vider ligne peut être incomplète pour compter chars ligne précédente (qui elle est complète)
        viderLigne();
        
        // vérif si réduc suffit (premiere partie du if), sinon calcul nb chars dans une ligne
        compterCharsLigne();
        
        // suppr des lignes jusqu'à ce que ce soit suffisant. Vérifie aussi les <br />. Rajoute ensuite une ligne au cas où trop enlevé.
        supprLignes();
        
        // réduction 10 par 10 jusqu'arrivé à la taille voulue
        reduction10par10();
        
        // stop la page à la fin d'un mot, ou juste avant un saut de ligne s'il y en a un proche (à la fin d'un paragraphe par exemple)
        decoupagePropre();
        
        if (window.innerWidth > 1500)
        {
            var parent = document.getElementById('parent');
            var secondVolet = document.createElement('div');
            parent.appendChild(secondVolet);
            var contenu2 = document.createElement('p');
            var reduire2 = document.createElement('p');
            var rallonger2 = document.createElement('p');
            secondVolet.appendChild(contenu2);
            secondVolet.appendChild(reduire2);
            secondVolet.appendChild(rallonger2);
            secondVolet.setAttribute('class', 'col-xxl-6');
            contenu2.setAttribute('class', 'contenu2');
            reduire2.setAttribute('class', 'reduire2');
            rallonger2.setAttribute('class', 'rallonger2');
            contenu2.textContent = 'estse ';
            for (var i=0 ; i<10 ; i++)
            {
                contenu2.textContent += contenu2.textContent;
            }
        }
    }
    
    // CODE POUBELLE
        
    /*var hauteurExcedente = positionReduireElt - window.innerHeight;
    var nbLignesExcedentes = Math.floor(hauteurExcedente / hauteurLigne) - 1; // Une ligne de sécurité car nbCharLigneApprox est approximatif. Si on a trop bouffé de lignes, l'algo qui remet les manquantes devrait réparer juste après (pas oublier de le faire !!!)
    //var nbCaracteresExcedents = nbCharsLigneApprox * nbLignesExcedentes;*/
    
    //caractereFin -= nbCaracteresExcedents;
        //console.log('nbCharsLigneApprox : ' + nbCharsLigneApprox + ' hauteurLigne : ' + hauteurLigne + ' positionReduireElt : ' + positionReduireElt + ' hauteurExcedente : ' + hauteurExcedente + ' nbLignesExcedentes : ' + nbLignesExcedentes + ' nbCaracteresExcedents : ' + nbCaracteresExcedents);
    
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