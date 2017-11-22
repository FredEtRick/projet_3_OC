<script type="text/javascript">    
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
    var parent;
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
    
    function debuger(fonction)
    {
        console.log('fonction : ' + fonction + ' caractereDeb : ' + caractereDeb + ' caractereFin : ' + caractereFin + ' positionReduireElt : ' + positionReduireElt + ' nbCharsLigneApprox : ' + nbCharsLigneApprox + ' hauteurLigne : ' + hauteurLigne + ' window.innerHeight : ' + window.innerHeight + ' positionRallongerElt_2 : ' + positionRallongerElt_2 + ' positionReduireElt_2 : ' + positionReduireElt_2);
    }
    
    function initialisationVars()
    {
        if (deuxiemePage)
        {
            contenuPageElt_generique = contenuPageElt_2;
            contenuPage_generique = contenuPage_2;
            reduireElt_generique = reduireElt_2;
            rallongerElt_generique = rallongerElt_2;
            positionReduireElt_generique = positionReduireElt_2;
            positionRallongerElt_generique = positionRallongerElt_2;
            deb_generique = caractereMilieu;
            fin_generique = caractereFin;
        }
        else
        {
            contenuPageElt_generique = contenuPageElt;
            contenuPage_generique = contenuPage;
            reduireElt_generique = reduireElt;
            rallongerElt_generique = rallongerElt;
            positionReduireElt_generique = positionReduireElt;
            positionRallongerElt_generique = positionRallongerElt;
            deb_generique = caractereDeb;
            fin_generique = caractereMilieu;
        }
    }
    
    function actualisationVars()
    {
        if (deuxiemePage)
        {
            caractereMilieu = deb_generique;
            caractereFin = fin_generique;
            contenuPage_2 = contenuPage_generique;
            positionReduireElt_2 = positionReduireElt_generique;
            positionRallongerElt_2 = positionRallongerElt_generique;
        }
        else
        {
            caractereDeb = deb_generique;
            caractereMilieu = fin_generique;
            contenuPage = contenuPage_generique;
            positionReduireElt = positionReduireElt_generique;
            positionRallongerElt = positionRallongerElt_generique;
        }
    }
    
    adapter();
    
    /*function remplirLigne() // remplir la première ligne pour calculer la longueur d'une ligne
    {
        while ((caractereMilieu > (caractereDeb + 150)) && (window.innerHeight < positionReduireElt) && (positionReduireElt == getPositionTop(reduireElt)))
        {
            caractereMilieu--;
            while (texte.substr(caractereMilieu-2, 2).indexOf('\\') != -1)
            {
                caractereMilieu -= 2;
            }
            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            if (positionReduireElt > getPositionTop(reduireElt))
            {
                hauteurLigne = positionReduireElt - getPositionTop(reduireElt);
            }
            debuger('viderLigne');
        }
        positionReduireElt = getPositionTop(reduireElt);
    }*/
    
    function compterCharsLigne() // Compte le nombre de chars dans une ligne (varie d'une ligne a l'autre mais permet de s'en rapprocher avec un exemple d'une ligne pleine)
    {
        while ((window.innerHeight > positionRallongerElt) && (positionRallongerElt == getPositionTop(rallongerElt)) && (caractereMilieu < texte.length-1)) 
        {
            if (texte.substr(caractereMilieu, 16).indexOf('<') != -1)
            {
                caractereMilieu += texte.substr(caractereMilieu, 22).lastIndexOf('>')+1;
                nbCharsLigneApprox = 0;
                contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                contenuPageElt.innerHTML = contenuPage;
                positionRallongerElt = getPositionTop(rallongerElt);
            }
            else
            {
                caractereMilieu += 10;
                while (texte.substr(caractereMilieu-1, 2).indexOf('\\') != -1)
                {
                    caractereMilieu += 2; // modif pour appostrophes, retire 6 et compte juste un là
                    nbCharsLigneApprox++;
                }
                nbCharsLigneApprox += 10;
            }
            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            debuger('compterCharsLigne');
        }
        if (positionRallongerElt < getPositionTop(rallongerElt))
        {
            hauteurLigne = getPositionTop(rallongerElt) - positionRallongerElt;
        }
        while (positionRallongerElt != getPositionTop(rallongerElt))
        {
            caractereMilieu--;
            if (texte.substr(caractereMilieu-1, 2).indexOf('\\'))
            {
                caractereMilieu -= 2;
                nbCharsLigneApprox--;
            }
            nbCharsLigneApprox--;
            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
        }
        caractereMilieu++;
        nbCharsLigneApprox++;
        contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
        contenuPageElt.innerHTML = contenuPage;
        positionReduireElt = getPositionTop(reduireElt);
        positionRallongerElt = getPositionTop(rallongerElt);
    }
    
    function supprLignes()
    {
        initialisationVars();
        console.log(deb_generique + ' ' + fin_generique);
        while (getPositionTop(reduireElt_generique) > window.innerHeight)
        {
            if (texte.substr(fin_generique-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
            {
                fin_generique -= Math.ceil(nbCharsLigneApprox*1,25) + texte.substr(fin_generique-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
            }
            else
            {
                fin_generique -= nbCharsLigneApprox;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            debuger('supprLignes');
        }
        fin_generique += nbCharsLigneApprox; // au cas où on ait un peu trop retiré
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        positionRallongerElt_generique = getPositionTop(rallongerElt_generique);
        actualisationVars();
    }
    
    function ajoutLignes()
    {
        initialisationVars();
        while (getPositionTop(rallongerElt_generique) < window.innerHeight)
        {
            if (fin_generique + Math.ceil(nbCharsLigneApprox*1,25) >= texte.length)
            {
                fin_generique = texte.length;
            }
            if (texte.substr(fin_generique+3, Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
            {
                console.log('ICI');
                fin_generique += 3 + texte.substr(fin_generique+3, Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') - 1; // S'il y a un saut de ligne après, placer le "curseur" de fin juste avant. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
            }
            else
            {
                console.log('LA');
                fin_generique += nbCharsLigneApprox;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            debuger('ajoutLignes');
        }
        //fin_generique += nbCharsLigneApprox; // au cas où on ait un peu trop retiré. a réadapter pour cette fonction plus tard !!!
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        positionRallongerElt_generique = getPositionTop(rallongerElt_generique);
        actualisationVars();
    }
    
    function supprPleinLignes()
    {
        
    }
    
    function ajoutPleinLignes()
    {
        hauteurManquante = window.innerHeight - positionRallongerElt;
        nbLignesManquantes = Math.floor(hauteurManquante / hauteurLigne);
        nbCaracteresManquants = nbCharsLigneApprox * nbLignesManquantes;
        caractereMilieu += nbCaracteresManquants;
        console.log(positionRallongerElt + ' ' + window.innerHeight + ' ' + hauteurManquante + ' ' + hauteurLigne + ' ' + nbLignesManquantes + ' ' + nbCaracteresManquants + ' ' + caractereMilieu);
        if (caractereMilieu+50 > texte.length) // si on est a peu près a la fin
        {
            caractereMilieu = texte.length-1;
            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
            contenuPageElt.innerHTML = contenuPage;
            positionReduireElt = getPositionTop(reduireElt);
            positionRallongerElt = getPositionTop(rallongerElt);
        }
        else
        {
            console.log('DANS AJOUT PLEIN LIGNES');
            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
            console.log(contenuPage);
            contenuPageElt.innerHTML = contenuPage;
            positionReduireElt = getPositionTop(reduireElt);
            positionRallongerElt = getPositionTop(rallongerElt);
            if (window.innerHeight < positionReduireElt) // si on a trop ajouté, retirer ligne par ligne
            {
                supprLignes();
            }
            if (window.innerHeight > positionRallongerElt) // si on a pas assez ajouté, ajouter ligne par ligne
            {
                ajoutLignes();
            }
            // sinon c'est bon*/
        }
    }
    
    function reduction10par10()
    {
        initialisationVars();
        while ((fin_generique > (deb_generique + 150)) && (window.innerHeight < positionReduireElt_generique)) // si id reduire n'est pas visible, réduire le texte.
        {
            fin_generique -= 10; // par 10 pour aller plus vite sans que ce soit génant
            while (texte.substr(fin_generique-6, 6).indexOf('<') != -1)
            {
                fin_generique = fin_generique - 6 + texte.substr(fin_generique-6, 6).indexOf('<') - 1;
            }
            while (texte.substr(fin_generique-2, 2).indexOf('\\') != -1)
            {
                fin_generique = fin_generique - 2 + texte.substr(fin_generique-2, 2).indexOf('\\') - 1;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            positionReduireElt_generique = getPositionTop(reduireElt_generique);
            debuger('reduction10');
        }
        actualisationVars();
    }
    
    function decoupagePropre()
    {
        initialisationVars();
        if (texte.substr(fin_generique-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste avant le premier d'entre eux
        {
            fin_generique = fin_generique - 16 + texte.substr(fin_generique-16, 32).indexOf('<br') - 1;
            debuger('decoupagePropreBr');
        }
        else
        {
            do
            {
                fin_generique--;
                debuger('decoupagePropreChars');
            } while ((fin_generique > deb_generique + 150) && (texte.charAt(deb_generique + fin_generique) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        actualisationVars();
    }
    
    function adapter() // adapte le texte a la place dispo dans la fenêtre, présente une page
    {
        // note : code divisé pour plus de clarté
        
        compterCharsLigne();
        
        ajoutPleinLignes();
        
        // réduction 10 par 10 jusqu'arrivé à la taille voulue
        reduction10par10();
        
        // stop la page à la fin d'un mot, ou juste avant un saut de ligne s'il y en a un proche (à la fin d'un paragraphe par exemple)
        decoupagePropre();
        
        /*var contenuPageElt_2;
        var contenuPage_2;
        var reduireElt_2;
        var rallongerElt_2;
        var positionReduireElt_2;
        var positionRallongerElt_2;*/
        
        if (window.innerWidth > 1500 && caractereMilieu < texte.length)
        {
            deuxiemePage = true;
            parent = document.getElementById('parent');
            secondVolet = document.createElement('div');
            parent.appendChild(secondVolet);
            contenuPageElt_2 = document.createElement('p');
            reduireElt_2 = document.createElement('p');
            rallongerElt_2 = document.createElement('p');
            secondVolet.appendChild(contenuPageElt_2);
            secondVolet.appendChild(reduireElt_2);
            secondVolet.appendChild(rallongerElt_2);
            secondVolet.setAttribute('class', 'col-xxl-6');
            contenuPageElt_2.setAttribute('id', 'contenu2');
            reduireElt_2.setAttribute('id', 'reduire2');
            rallongerElt_2.setAttribute('id', 'rallonger2');
            difference = caractereMilieu - caractereDeb;
            while (texte.charAt(caractereMilieu + 1) == '<')
                caractereMilieu += texte.substr(caractereMilieu+1, 6).indexOf('>') + 2;
            if (caractereMilieu + difference >= texte.length)
            {
                caractereFin = texte.length-1;
            }
            else
            {
                caractereFin = caractereMilieu + difference;
                contenuPage_2 = texte.substr(caractereDeb, difference);
                contenuPageElt_2.textContent = contenuPage_2;
                if (getPositionTop(reduireElt_2) > window.innerHeight) // on a été trop loin en terme de lignes
                {
                    supprLignes(); // reste a ajouter decoupage propre etc
                    reduction10par10();
                    decoupagePropre();
                }
                else if (getPositionTop(rallongerElt_2) < window.innerHeight) // pas assez loin
                {
                    ajoutLignes();
                    reduction10par10();
                    decoupagePropre();
                }
                // vérifie découpage mot
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
            caractereMilieu = caractereDeb + 750; // modif ? fin texte avant ?
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