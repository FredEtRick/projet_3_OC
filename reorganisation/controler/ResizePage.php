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



<script type="text/javascript" src="../model/Resizer.php"></script>

<script type="text/javascript">
    
    // function sending back vertical position of element in the page, "getPositionTop" is the only code I didn't wrote myself. I took it here : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
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
    
    function debuger(fonction)
    {
        console.log('fonction : ' + fonction + ' deuxiemePage : ' + deuxiemePage + ' ; ' + ' caractereDeb : ' + caractereDeb + ' caractereMilieu : ' + caractereMilieu + ' caractereFin : ' + caractereFin + ' positionReduireElt : ' + positionReduireElt + ' positionRallongerElt : ' + positionRallongerElt + ' nbCharsLigneApprox : ' + nbCharsLigneApprox + ' hauteurLigne : ' + hauteurLigne + ' window.innerHeight : ' + window.innerHeight + ' positionRallongerElt_2 : ' + positionRallongerElt_2 + ' positionReduireElt_2 : ' + positionReduireElt_2 + /*' contenu ' + contenuPage +*/ ' contenuGenerique : ' + contenuPage_generique);
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
        replacerDebut();
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
    
    function replacerDebut()
    {
        while (texte.substr(deb_generique, 4).indexOf('<br') != -1)
        {
            deb_generique += texte.substr(deb_generique, 7).lastIndexOf('>') + 1;
        }
    }
    
    function deplacerAvantSaut(caractere)
    {
        while (texte.substr(caractere-7, 7).indexOf('<br') != -1)
        {
            caractere += -7 + texte.substr(caractere-7, 7).indexOf('<br') - 1;
        }
        return caractere;
    }
    
    function deplacerApresSaut(caractere)
    {
        while (texte.substr(caractere, 4).indexOf('<br') != -1)
        {
            caractere += texte.substr(caractere, 7).lastIndexOf('>') + 1;
        }
        return caractere;
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
        caractereMilieu = caractereDeb;
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
                fin_generique += -Math.ceil(nbCharsLigneApprox*1,25) + texte.substr(fin_generique-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
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
        while (getPositionTop(rallongerElt_generique) < window.innerHeight && fin_generique < texte.length-1)
        {
            if (fin_generique + Math.ceil(nbCharsLigneApprox*1,25) >= texte.length-1)
            {
                fin_generique = texte.length-1;
            }
            else if (texte.substr(fin_generique+3, Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
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
            debuger('ajoutLignes');
    }
    
    function supprLignesDeb()
    {
        initialisationVars();
        console.log(deb_generique + ' ' + fin_generique);
        while (getPositionTop(reduireElt_generique) > window.innerHeight)
        {
            if (texte.substr(deb_generique-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
            {
                deb_generique += -Math.ceil(nbCharsLigneApprox*1,25) + texte.substr(deb_generique-Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
            }
            else
            {
                deb_generique -= nbCharsLigneApprox;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            debuger('supprLignesDeb');
        }
        deb_generique += nbCharsLigneApprox; // au cas où on ait un peu trop retiré
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        positionRallongerElt_generique = getPositionTop(rallongerElt_generique);
        actualisationVars();
    }
    
    function ajoutLignesDeb()
    {
        initialisationVars();
        while (getPositionTop(rallongerElt_generique) < window.innerHeight && deb_generique != 0)
        {
            if (deb_generique - Math.ceil(nbCharsLigneApprox*1,25) <= 0)
            {
                deb_generique = 0;
            }
            else if (texte.substr(deb_generique - 12 - Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).indexOf('<br') != -1)
            {
                console.log('ICI');
                deb_generique += -12 - Math.ceil(nbCharsLigneApprox*1,25) + texte.substr(deb_generique - 12 - Math.ceil(nbCharsLigneApprox*1,25), Math.ceil(nbCharsLigneApprox*1,25)).lastIndexOf('>') + 1; // S'il y a un saut de ligne avant, placer le "curseur" de fin juste après le dernier saut. On balaie un peu plus que nbCharsLigneApprox au cas ou la ligne compte plus de caractères que nbCharsLigneApprox
            }
            else
            {
                console.log('LA');
                deb_generique -= nbCharsLigneApprox;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            debuger('ajoutLignesDeb');
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
        if (hauteurLigne != null) // si la hauteur de ligne a été calculée, donc s'il existait une ligne entière a parcourir dans le texte pour mesurer la hauteur d'une ligne dans compterCharslignes, alors ajouter direct des caractères pour remplir approximativement la fenêtre en se basant sur les calculs suivants :
        {
            hauteurManquante = window.innerHeight - positionRallongerElt;
            nbLignesManquantes = Math.floor(hauteurManquante / hauteurLigne);
            nbCaracteresManquants = nbCharsLigneApprox * nbLignesManquantes;
            caractereMilieu += nbCaracteresManquants;
        }
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
            while (texte.substr(fin_generique-1, 2).indexOf('\\') != -1)
            {
                fin_generique = fin_generique - 1 + texte.substr(fin_generique-1, 2).indexOf('\\') - 1;
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
        else if (fin_generique + nbCharsLigneApprox > texte.length-1)
        {
            fin_generique = texte.length-1;
        }
        else
        {
            do
            {
                fin_generique--;
                debuger('decoupagePropreChars');
            } while ((fin_generique > deb_generique + 150) && (texte.charAt(fin_generique) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        actualisationVars();
    }
    
    function reduction10par10Deb()
    {
        initialisationVars();
        while ((fin_generique > (deb_generique + 150)) && (window.innerHeight < positionReduireElt_generique)) // si id reduire n'est pas visible, réduire le texte.
        {
            deb_generique += 10; // par 10 pour aller plus vite sans que ce soit génant
            while (texte.substr(deb_generique, 6).indexOf('<') != -1)
            {
                deb_generique += texte.substr(deb_generique, 12).lastIndexOf('>') + 1;
            }
            while (texte.substr(fin_generique-1, 2).indexOf('\\') != -1)
            {
                fin_generique += -1 + texte.substr(fin_generique-2, 2).indexOf('\\') + 2;
            }
            contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
            contenuPageElt_generique.innerHTML = contenuPage_generique;
            positionReduireElt_generique = getPositionTop(reduireElt_generique);
            debuger('reduction10Deb');
        }
        actualisationVars();
    }
    
    function decoupagePropreDeb()
    {
        initialisationVars();
        if (texte.substr(deb_generique-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste après le dernier d'entre eux
        {
            deb_generique += -16 + texte.substr(fin_generique-16, 35).lastIndexOf('>') + 1;
            debuger('decoupagePropreBrDeb');
        }
        else if (deb_generique - nbCharsLigneApprox <= 0)
        {
            deb_generique = 0;
        }
        else
        {
            do
            {
                deb_generique++;
                debuger('decoupagePropreCharsDeb');
                console.log(fin_generique + ' ' + (deb_generique+150) + ' ' + deb_generique + ' ' + texte.charAt(deb_generique));
                console.log((fin_generique > deb_generique + 150) + ' ' + (texte.charAt(deb_generique) != ' '));
            } while ((fin_generique > deb_generique + 150) && (texte.charAt(deb_generique) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        console.log('?????????? ' + contenuPage_generique);
        contenuPage_generique = texte.substr(deb_generique, fin_generique-deb_generique+1);
        contenuPageElt_generique.innerHTML = contenuPage_generique;
        positionReduireElt_generique = getPositionTop(reduireElt_generique);
        actualisationVars();
        console.log('?????????? ' + contenuPage);
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
    
    // pageSuivante pagePrecedente
    
    var boutonsPagesElt = document.createElement('p');
    var precedenteElt = document.createElement('button');
    var suivanteElt = document.createElement('button');
    parent.appendChild(boutonsPagesElt);
    boutonsPagesElt.appendChild(precedenteElt);
    boutonsPagesElt.appendChild(suivanteElt);
    boutonsPagesElt.classList.add('navPages');
    boutonsPagesElt.classList.add('col-xxl-12');
    boutonsPagesElt.classList.add('col-xl-12');
    boutonsPagesElt.classList.add('col-sm-12');
    precedenteElt.classList.add('fa');
    precedenteElt.classList.add('fa-chevron-left');
    precedenteElt.setAttribute('onclick', 'pagePrecedente()');
    suivanteElt.classList.add('fa');
    suivanteElt.classList.add('fa-chevron-right');
    suivanteElt.setAttribute('onclick', 'pageSuivante()');
    
    function pagePrecedente()
    {
        console.log('PAGE PRECEDENTE');
        difference = caractereMilieu - caractereDeb;
        if (window.innerWidth > 1500)
        {
            if (caractereDeb > 0)
            {
                caractereFin = deplacerAvantSaut(caractereDeb);
                if (caractereFin-Math.floor(0.75*difference) <= 0)
                {
                    caractereMilieu = 0;
                    caractereDeb = 0;
                    contenuPage = '';
                    contenuPage_2 = texte.substr(caractereMilieu, caractereFin-caractereMilieu+1);
                    contenuPageElt.innerHTML = contenuPage;
                    contenuPageElt_2.innerHTML = contenuPage_2;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionReduireElt_2 = getPositionTop(reduireElt_2);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                }
                else
                {
                    caractereMilieu = deplacerApresSaut(caractereFin - Math.floor(0.75*difference));
                    caractereDeb = caractereMilieu;
                    deuxiemePage = true;
                    contenuPage = '';
                    contenuPage_2 = texte.substr(caractereMilieu, caractereFin-caractereMilieu+1);
                    contenuPageElt.innerHTML = contenuPage;
                    contenuPageElt_2.innerHTML = contenuPage_2;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionReduireElt_2 = getPositionTop(reduireElt_2);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                    if (positionReduireElt_2 > window.innerHeight)
                    {
                        supprLignesDeb();
                        reduction10par10Deb();
                    }
                    if (positionRallongerElt_2 < window.innerHeight)
                    {
                        ajoutLignesDeb();
                        reduction10par10Deb();
                    }
                    decoupagePropreDeb();
                    if (caractereMilieu > 0)
                    {
                        deuxiemePage = false;
                        if (caractereMilieu-Math.floor(0.75*difference) <= 0)
                        {
                            caractereDeb = 0;
                            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                            contenuPageElt.innerHTML = contenuPage;
                            positionReduireElt = getPositionTop(reduireElt);
                            positionRallongerElt = getPositionTop(rallongerElt);
                        }
                        else
                        {
                            caractereDeb = deplacerApresSaut(caractereMilieu - Math.floor(0.75*difference));
                            contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                            contenuPageElt.innerHTML = contenuPage;
                            positionReduireElt = getPositionTop(reduireElt);
                            positionRallongerElt = getPositionTop(rallongerElt);
                            if (positionReduireElt > window.innerHeight)
                            {
                                supprLignesDeb();
                                reduction10par10Deb();
                            }
                            if (positionRallongerElt < window.innerHeight)
                            {
                                ajoutLignesDeb();
                                reduction10par10Deb();
                            }
                            decoupagePropreDeb();
                        }
                    }
                }
            }
        }
        else
        {
            if (caractereDeb > 0)
            {
                if (caractereMilieu-Math.floor(0.75*difference) <= 0)
                {
                    caractereMilieu = deplacerAvantSaut(caractereDeb);
                    caractereDeb = 0;
                    /*while (texte.substr(caractereDeb-5, 6).indexOf('<') != -1)
                    {
                        caractereMilieu += (texte.substr(caractereMilieu-5, 6).indexOf('<') - 6);
                    }*/
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPageElt.innerHTML = contenuPage;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionRallongerElt = getPositionTop(rallongerElt);
                }
                else
                {
                    caractereMilieu = deplacerAvantSaut(caractereDeb);
                    caractereDeb = deplacerApresSaut(caractereDeb - Math.floor(0.75*difference));
                    deuxiemePage = false;
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPageElt.innerHTML = contenuPage;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    if (positionReduireElt > window.innerHeight)
                    {
                        supprLignesDeb();
                        reduction10par10Deb();
                    }
                    if (positionRallongerElt < window.innerHeight)
                    {
                        ajoutLignesDeb();
                        reduction10par10Deb();
                    }
                    decoupagePropreDeb();
                }
            }
        }
    }
    
    function pageSuivante()
    {
        console.log('PAGE SUIVANTE');
        difference = caractereMilieu - caractereDeb;
        if (window.innerWidth > 1500)
        {
            if (caractereFin < texte.length-1)
            {
                caractereDeb = deplacerApresSaut(caractereFin);
                if (caractereDeb+Math.floor(0.75*difference) >= texte.length-1)
                {
                    caractereMilieu = texte.length-1;
                    caractereFin = texte.length-1;
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPage_2 = '';
                    contenuPageElt.innerHTML = contenuPage;
                    contenuPageElt_2.innerHTML = contenuPage_2;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionReduireElt_2 = getPositionTop(reduireElt_2);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                }
                else
                {
                    caractereMilieu = deplacerAvantSaut(caractereDeb + Math.floor(0.75*difference));
                    caractereFin = caractereMilieu;
                    deuxiemePage = false;
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPage_2 = '';
                    contenuPageElt.innerHTML = contenuPage;
                    contenuPageElt_2.innerHTML = contenuPage_2;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionReduireElt_2 = getPositionTop(reduireElt_2);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                    if (positionReduireElt > window.innerHeight)
                    {
                        supprLignes();
                        reduction10par10();
                    }
                    if (positionRallongerElt < window.innerHeight)
                    {
                        ajoutLignes();
                        reduction10par10();
                    }
                    decoupagePropre();
                    if (caractereMilieu < texte.length-1)
                    {
                        deuxiemePage = true;
                        if (caractereMilieu+Math.floor(0.75*difference) >= texte.length-1)
                        {
                            caractereFin = texte.length-1;
                            contenuPage_2 = texte.substr(caractereMilieu, caractereFin-caractereMilieu+1);
                            contenuPageElt_2.innerHTML = contenuPage_2;
                            positionReduireElt_2 = getPositionTop(reduireElt_2);
                            positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                        }
                        else
                        {
                            caractereFin = deplacerAvantSaut(caractereMilieu + Math.floor(0.75*difference)); // j'ai changé caractereDeb en caractereMilieu, mais ça marchait avant... Bizarre
                            contenuPage_2 = texte.substr(caractereMilieu, caractereFin-caractereMilieu+1);
                            contenuPageElt_2.innerHTML = contenuPage_2;
                            positionReduireElt_2 = getPositionTop(reduireElt_2);
                            positionRallongerElt_2 = getPositionTop(rallongerElt_2);
                            if (positionReduireElt_2 > window.innerHeight)
                            {
                                supprLignes();
                                reduction10par10();
                            }
                            if (positionRallongerElt_2 < window.innerHeight)
                            {
                                ajoutLignes();
                                reduction10par10();
                            }
                            decoupagePropre();
                        }
                    }
                }
            }
        }
        else
        {
            if (caractereMilieu < texte.length-1)
            {
                if (caractereMilieu+Math.floor(0.75*difference) >= texte.length-1)
                {
                    caractereDeb = deplacerApresSaut(caractereMilieu);
                    caractereMilieu = texte.length-1;
                    /*while (texte.substr(caractereDeb-5, 6).indexOf('<') != -1)
                    {
                        caractereMilieu += (texte.substr(caractereMilieu-5, 6).indexOf('<') - 6);
                    }*/
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPageElt.innerHTML = contenuPage;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionRallongerElt = getPositionTop(rallongerElt);
                }
                else
                {
                    caractereDeb = deplacerApresSaut(caractereMilieu);
                    caractereMilieu = deplacerAvantSaut(caractereMilieu + Math.floor(0.75*difference));
                    deuxiemePage = false;
                    contenuPage = texte.substr(caractereDeb, caractereMilieu-caractereDeb+1);
                    contenuPageElt.innerHTML = contenuPage;
                    positionReduireElt = getPositionTop(reduireElt);
                    positionRallongerElt = getPositionTop(rallongerElt);
                    if (positionReduireElt > window.innerHeight)
                    {
                        supprLignes();
                        reduction10par10();
                    }
                    if (positionRallongerElt < window.innerHeight)
                    {
                        ajoutLignes();
                        reduction10par10();
                    }
                    decoupagePropre();
                }
            }
        }
    }
</script>