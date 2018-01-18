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
        console.log('fonction : ' + fonction + ' workOnSecondPage : ' + workOnSecondPage + ' ; ' + ' firstCharOfPage1 : ' + firstCharOfPage1 + ' charBetweenBothPages : ' + charBetweenBothPages + ' lastCharOfPage2 : ' + lastCharOfPage2 + ' positionShouldAppearElt1 : ' + positionShouldAppearElt1 + ' positionShouldNotAppearElt1 : ' + positionShouldNotAppearElt1 + ' numberCharsLine : ' + numberCharsLine + ' lineHeightPx : ' + lineHeightPx + ' window.innerHeight : ' + window.innerHeight + ' positionShouldNotAppearElt2 : ' + positionShouldNotAppearElt2 + ' positionShouldAppearElt2 : ' + positionShouldAppearElt2 + /*' contenu ' + page1Content +*/ ' contenuGenerique : ' + pageContent_generic);
    }
    
    function initialisationVars()
    {
        if (workOnSecondPage)
        {
            pageContentElt_generic = page2ContentElt;
            pageContent_generic = page2Content;
            shouldAppearElt_generic = shouldAppearElt2;
            shouldNotAppearElt_generic = shouldNotAppearElt2;
            positionShouldAppearElt_generic = positionShouldAppearElt2;
            positionShouldNotAppearElt_generic = positionShouldNotAppearElt2;
            firstCharOfPage_generic = charBetweenBothPages;
            lastCharOfPage_generic = lastCharOfPage2;
        }
        else
        {
            pageContentElt_generic = page1ContentElt;
            pageContent_generic = page1Content;
            shouldAppearElt_generic = shouldAppearElt1;
            shouldNotAppearElt_generic = shouldNotAppearElt1;
            positionShouldAppearElt_generic = positionShouldAppearElt1;
            positionShouldNotAppearElt_generic = positionShouldNotAppearElt1;
            firstCharOfPage_generic = firstCharOfPage1;
            lastCharOfPage_generic = charBetweenBothPages;
        }
        replacerDebut();
    }
    
    function actualisationVars()
    {
        if (workOnSecondPage)
        {
            charBetweenBothPages = firstCharOfPage_generic;
            lastCharOfPage2 = lastCharOfPage_generic;
            page2Content = pageContent_generic;
            positionShouldAppearElt2 = positionShouldAppearElt_generic;
            positionShouldNotAppearElt2 = positionShouldNotAppearElt_generic;
        }
        else
        {
            firstCharOfPage1 = firstCharOfPage_generic;
            charBetweenBothPages = lastCharOfPage_generic;
            page1Content = pageContent_generic;
            positionShouldAppearElt1 = positionShouldAppearElt_generic;
            positionShouldNotAppearElt1 = positionShouldNotAppearElt_generic;
        }
    }
    
    function replacerDebut()
    {
        while (postCompleteText.substr(firstCharOfPage_generic, 4).indexOf('<br') != -1)
        {
            firstCharOfPage_generic += postCompleteText.substr(firstCharOfPage_generic, 7).lastIndexOf('>') + 1;
        }
    }
    
    function deplacerAvantSaut(caractere)
    {
        while (postCompleteText.substr(caractere-7, 7).indexOf('<br') != -1)
        {
            caractere += -7 + postCompleteText.substr(caractere-7, 7).indexOf('<br') - 1;
        }
        return caractere;
    }
    
    function deplacerApresSaut(caractere)
    {
        while (postCompleteText.substr(caractere, 4).indexOf('<br') != -1)
        {
            caractere += postCompleteText.substr(caractere, 7).lastIndexOf('>') + 1;
        }
        return caractere;
    }
    
    adapter();
    
    /*function remplirLigne() // remplir la première ligne pour calculer la longueur d'une ligne
    {
        while ((charBetweenBothPages > (firstCharOfPage1 + 150)) && (window.innerHeight < positionShouldAppearElt1) && (positionShouldAppearElt1 == getPositionTop(shouldAppearElt1)))
        {
            charBetweenBothPages--;
            while (postCompleteText.substr(charBetweenBothPages-2, 2).indexOf('\\') != -1)
            {
                charBetweenBothPages -= 2;
            }
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            if (positionShouldAppearElt1 > getPositionTop(shouldAppearElt1))
            {
                lineHeightPx = positionShouldAppearElt1 - getPositionTop(shouldAppearElt1);
            }
            debuger('viderLigne');
        }
        positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
    }*/
    
    function compterCharsLigne() // Compte le nombre de chars dans une ligne (varie d'une ligne a l'autre mais permet de s'en rapprocher avec un exemple d'une ligne pleine)
    {
        charBetweenBothPages = firstCharOfPage1;
        while ((window.innerHeight > positionShouldNotAppearElt1) && (positionShouldNotAppearElt1 == getPositionTop(rallongerElt)) && (charBetweenBothPages < postCompleteText.length-1)) 
        {
            if (postCompleteText.substr(charBetweenBothPages, 16).indexOf('<') != -1)
            {
                charBetweenBothPages += postCompleteText.substr(charBetweenBothPages, 22).lastIndexOf('>')+1;
                numberCharsLine = 0;
                page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                page1ContentElt.innerHTML = page1Content;
                positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
            }
            else
            {
                charBetweenBothPages += 10;
                while (postCompleteText.substr(charBetweenBothPages-1, 2).indexOf('\\') != -1)
                {
                    charBetweenBothPages += 2; // modif pour appostrophes, retire 6 et compte juste un là
                    numberCharsLine++;
                }
                numberCharsLine += 10;
            }
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            debuger('compterCharsLigne');
        }
        if (positionShouldNotAppearElt1 < getPositionTop(shouldNotAppearElt1))
        {
            lineHeightPx = getPositionTop(shouldNotAppearElt1) - positionShouldNotAppearElt1;
        }
        while (positionShouldNotAppearElt1 != getPositionTop(shouldNotAppearElt1))
        {
            charBetweenBothPages--;
            if (postCompleteText.substr(charBetweenBothPages-1, 2).indexOf('\\'))
            {
                charBetweenBothPages -= 2;
                numberCharsLine--;
            }
            numberCharsLine--;
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
        }
        charBetweenBothPages++;
        numberCharsLine++;
        page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
        page1ContentElt.innerHTML = page1Content;
        positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
        positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
    }
    
    function supprLignes()
    {
        initialisationVars();
        console.log(firstCharOfPage_generic + ' ' + lastCharOfPage_generic);
        while (getPositionTop(shouldAppearElt_generic) > window.innerHeight)
        {
            if (postCompleteText.substr(lastCharOfPage_generic-Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).indexOf('<br') != -1)
            {
                lastCharOfPage_generic += -Math.ceil(numberCharsLine*1,25) + postCompleteText.substr(lastCharOfPage_generic-Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que numberCharsLine au cas ou la ligne compte plus de caractères que numberCharsLine
            }
            else
            {
                lastCharOfPage_generic -= numberCharsLine;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            debuger('supprLignes');
        }
        lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        actualisationVars();
    }
    
    function ajoutLignes()
    {
        initialisationVars();
        while (getPositionTop(shouldNotAppearElt_generic) < window.innerHeight && lastCharOfPage_generic < postCompleteText.length-1)
        {
            if (lastCharOfPage_generic + Math.ceil(numberCharsLine*1,25) >= postCompleteText.length-1)
            {
                lastCharOfPage_generic = postCompleteText.length-1;
            }
            else if (postCompleteText.substr(lastCharOfPage_generic+3, Math.ceil(numberCharsLine*1,25)).indexOf('<br') != -1)
            {
                console.log('ICI');
                lastCharOfPage_generic += 3 + postCompleteText.substr(lastCharOfPage_generic+3, Math.ceil(numberCharsLine*1,25)).indexOf('<br') - 1; // S'il y a un saut de ligne après, placer le "curseur" de fin juste avant. On balaie un peu plus que numberCharsLine au cas ou la ligne compte plus de caractères que numberCharsLine
            }
            else
            {
                console.log('LA');
                lastCharOfPage_generic += numberCharsLine;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            debuger('ajoutLignes');
        }
        //lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré. a réadapter pour cette fonction plus tard !!!
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        actualisationVars();
            debuger('ajoutLignes');
    }
    
    function supprLignesDeb()
    {
        initialisationVars();
        console.log(firstCharOfPage_generic + ' ' + lastCharOfPage_generic);
        while (getPositionTop(shouldAppearElt_generic) > window.innerHeight)
        {
            if (postCompleteText.substr(firstCharOfPage_generic-Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).indexOf('<br') != -1)
            {
                firstCharOfPage_generic += -Math.ceil(numberCharsLine*1,25) + postCompleteText.substr(firstCharOfPage_generic-Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).lastIndexOf('<br') - 1; // S'il y a un saut de ligne, placer le "curseur" de fin juste avant. On balaie un peu plus que numberCharsLine au cas ou la ligne compte plus de caractères que numberCharsLine
            }
            else
            {
                firstCharOfPage_generic -= numberCharsLine;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            debuger('supprLignesDeb');
        }
        firstCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        actualisationVars();
    }
    
    function ajoutLignesDeb()
    {
        initialisationVars();
        while (getPositionTop(shouldNotAppearElt_generic) < window.innerHeight && firstCharOfPage_generic != 0)
        {
            if (firstCharOfPage_generic - Math.ceil(numberCharsLine*1,25) <= 0)
            {
                firstCharOfPage_generic = 0;
            }
            else if (postCompleteText.substr(firstCharOfPage_generic - 12 - Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).indexOf('<br') != -1)
            {
                console.log('ICI');
                firstCharOfPage_generic += -12 - Math.ceil(numberCharsLine*1,25) + postCompleteText.substr(firstCharOfPage_generic - 12 - Math.ceil(numberCharsLine*1,25), Math.ceil(numberCharsLine*1,25)).lastIndexOf('>') + 1; // S'il y a un saut de ligne avant, placer le "curseur" de fin juste après le dernier saut. On balaie un peu plus que numberCharsLine au cas ou la ligne compte plus de caractères que numberCharsLine
            }
            else
            {
                console.log('LA');
                firstCharOfPage_generic -= numberCharsLine;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            debuger('ajoutLignesDeb');
        }
        //lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré. a réadapter pour cette fonction plus tard !!!
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        actualisationVars();
    }
    
    function supprPleinLignes()
    {
        
    }
    
    function ajoutPleinLignes()
    {
        if (lineHeightPx != null) // si la hauteur de ligne a été calculée, donc s'il existait une ligne entière a parcourir dans le texte pour mesurer la hauteur d'une ligne dans compterCharslignes, alors ajouter direct des caractères pour remplir approximativement la fenêtre en se basant sur les calculs suivants :
        {
            missingHeight = window.innerHeight - positionShouldNotAppearElt1;
            missingLines = Math.floor(missingHeight / lineHeightPx);
            missingChars = numberCharsLine * missingLines;
            charBetweenBothPages += missingChars;
        }
        console.log(positionShouldNotAppearElt1 + ' ' + window.innerHeight + ' ' + missingHeight + ' ' + lineHeightPx + ' ' + missingLines + ' ' + missingChars + ' ' + charBetweenBothPages);
        if (charBetweenBothPages+50 > postCompleteText.length) // si on est a peu près a la fin
        {
            charBetweenBothPages = postCompleteText.length-1;
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
        }
        else
        {
            console.log('DANS AJOUT PLEIN LIGNES');
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            console.log(page1Content);
            page1ContentElt.innerHTML = page1Content;
            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
            if (window.innerHeight < positionShouldAppearElt1) // si on a trop ajouté, retirer ligne par ligne
            {
                supprLignes();
            }
            if (window.innerHeight > positionShouldNotAppearElt1) // si on a pas assez ajouté, ajouter ligne par ligne
            {
                ajoutLignes();
            }
            // sinon c'est bon*/
        }
    }
    
    function reduction10par10()
    {
        initialisationVars();
        while ((lastCharOfPage_generic > (firstCharOfPage_generic + 150)) && (window.innerHeight < positionShouldAppearElt_generic)) // si id reduire n'est pas visible, réduire le texte.
        {
            lastCharOfPage_generic -= 10; // par 10 pour aller plus vite sans que ce soit génant
            while (postCompleteText.substr(lastCharOfPage_generic-6, 6).indexOf('<') != -1)
            {
                lastCharOfPage_generic = lastCharOfPage_generic - 6 + postCompleteText.substr(lastCharOfPage_generic-6, 6).indexOf('<') - 1;
            }
            while (postCompleteText.substr(lastCharOfPage_generic-1, 2).indexOf('\\') != -1)
            {
                lastCharOfPage_generic = lastCharOfPage_generic - 1 + postCompleteText.substr(lastCharOfPage_generic-1, 2).indexOf('\\') - 1;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
            debuger('reduction10');
        }
        actualisationVars();
    }
    
    function decoupagePropre()
    {
        initialisationVars();
        if (postCompleteText.substr(lastCharOfPage_generic-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste avant le premier d'entre eux
        {
            lastCharOfPage_generic = lastCharOfPage_generic - 16 + postCompleteText.substr(lastCharOfPage_generic-16, 32).indexOf('<br') - 1;
            debuger('decoupagePropreBr');
        }
        else if (lastCharOfPage_generic + numberCharsLine > postCompleteText.length-1)
        {
            lastCharOfPage_generic = postCompleteText.length-1;
        }
        else
        {
            do
            {
                lastCharOfPage_generic--;
                debuger('decoupagePropreChars');
            } while ((lastCharOfPage_generic > firstCharOfPage_generic + 150) && (postCompleteText.charAt(lastCharOfPage_generic) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        actualisationVars();
    }
    
    function reduction10par10Deb()
    {
        initialisationVars();
        while ((lastCharOfPage_generic > (firstCharOfPage_generic + 150)) && (window.innerHeight < positionShouldAppearElt_generic)) // si id reduire n'est pas visible, réduire le texte.
        {
            firstCharOfPage_generic += 10; // par 10 pour aller plus vite sans que ce soit génant
            while (postCompleteText.substr(firstCharOfPage_generic, 6).indexOf('<') != -1)
            {
                firstCharOfPage_generic += postCompleteText.substr(firstCharOfPage_generic, 12).lastIndexOf('>') + 1;
            }
            while (postCompleteText.substr(lastCharOfPage_generic-1, 2).indexOf('\\') != -1)
            {
                lastCharOfPage_generic += -1 + postCompleteText.substr(lastCharOfPage_generic-2, 2).indexOf('\\') + 2;
            }
            pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
            pageContentElt_generic.innerHTML = pageContent_generic;
            positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
            debuger('reduction10Deb');
        }
        actualisationVars();
    }
    
    function decoupagePropreDeb()
    {
        initialisationVars();
        if (postCompleteText.substr(firstCharOfPage_generic-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste après le dernier d'entre eux
        {
            firstCharOfPage_generic += -16 + postCompleteText.substr(lastCharOfPage_generic-16, 35).lastIndexOf('>') + 1;
            debuger('decoupagePropreBrDeb');
        }
        else if (firstCharOfPage_generic - numberCharsLine <= 0)
        {
            firstCharOfPage_generic = 0;
        }
        else
        {
            do
            {
                firstCharOfPage_generic++;
                debuger('decoupagePropreCharsDeb');
                console.log(lastCharOfPage_generic + ' ' + (firstCharOfPage_generic+150) + ' ' + firstCharOfPage_generic + ' ' + postCompleteText.charAt(firstCharOfPage_generic));
                console.log((lastCharOfPage_generic > firstCharOfPage_generic + 150) + ' ' + (postCompleteText.charAt(firstCharOfPage_generic) != ' '));
            } while ((lastCharOfPage_generic > firstCharOfPage_generic + 150) && (postCompleteText.charAt(firstCharOfPage_generic) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        console.log('?????????? ' + pageContent_generic);
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        actualisationVars();
        console.log('?????????? ' + page1Content);
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
        
        /*var page2ContentElt;
        var page2Content;
        var shouldAppearElt2;
        var shouldNotAppearElt2;
        var positionShouldAppearElt2;
        var positionShouldNotAppearElt2;*/
        
        if (window.innerWidth > 1500 && charBetweenBothPages < postCompleteText.length)
        {
            workOnSecondPage = true;
            parentElt = document.getElementById('parent');
            page2ContainerElt = document.createElement('div');
            parentElt.appendChild(page2ContainerElt);
            page2ContentElt = document.createElement('p');
            shouldAppearElt2 = document.createElement('p');
            shouldNotAppearElt2 = document.createElement('p');
            page2ContainerElt.appendChild(page2ContentElt);
            page2ContainerElt.appendChild(shouldAppearElt2);
            page2ContainerElt.appendChild(shouldNotAppearElt2);
            page2ContainerElt.setAttribute('class', 'col-xxl-6');
            page2ContentElt.setAttribute('id', 'contenu2');
            shouldAppearElt2.setAttribute('id', 'reduire2');
            shouldNotAppearElt2.setAttribute('id', 'rallonger2');
            numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
            while (postCompleteText.charAt(charBetweenBothPages + 1) == '<')
                charBetweenBothPages += postCompleteText.substr(charBetweenBothPages+1, 6).indexOf('>') + 2;
            if (charBetweenBothPages + numberOfCharsInPage1 >= postCompleteText.length)
            {
                lastCharOfPage2 = postCompleteText.length-1;
            }
            else
            {
                lastCharOfPage2 = charBetweenBothPages + numberOfCharsInPage1;
                page2Content = postCompleteText.substr(firstCharOfPage1, numberOfCharsInPage1);
                page2ContentElt.textContent = page2Content;
                if (getPositionTop(shouldAppearElt2) > window.innerHeight) // on a été trop loin en terme de lignes
                {
                    supprLignes(); // reste a ajouter decoupage propre etc
                    reduction10par10();
                    decoupagePropre();
                }
                else if (getPositionTop(shouldNotAppearElt2) < window.innerHeight) // pas assez loin
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
    parentElt.appendChild(boutonsPagesElt);
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
        numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
        if (window.innerWidth > 1500)
        {
            if (firstCharOfPage1 > 0)
            {
                lastCharOfPage2 = deplacerAvantSaut(firstCharOfPage1);
                if (lastCharOfPage2-Math.floor(0.75*numberOfCharsInPage1) <= 0)
                {
                    charBetweenBothPages = 0;
                    firstCharOfPage1 = 0;
                    page1Content = '';
                    page2Content = postCompleteText.substr(charBetweenBothPages, lastCharOfPage2-charBetweenBothPages+1);
                    page1ContentElt.innerHTML = page1Content;
                    page2ContentElt.innerHTML = page2Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                    positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                }
                else
                {
                    charBetweenBothPages = deplacerApresSaut(lastCharOfPage2 - Math.floor(0.75*numberOfCharsInPage1));
                    firstCharOfPage1 = charBetweenBothPages;
                    workOnSecondPage = true;
                    page1Content = '';
                    page2Content = postCompleteText.substr(charBetweenBothPages, lastCharOfPage2-charBetweenBothPages+1);
                    page1ContentElt.innerHTML = page1Content;
                    page2ContentElt.innerHTML = page2Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                    positionShouldNotAppearElt1 = getPositionTop(rallongerElt);
                    positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                    if (positionShouldAppearElt2 > window.innerHeight)
                    {
                        supprLignesDeb();
                        reduction10par10Deb();
                    }
                    if (positionShouldNotAppearElt2 < window.innerHeight)
                    {
                        ajoutLignesDeb();
                        reduction10par10Deb();
                    }
                    decoupagePropreDeb();
                    if (charBetweenBothPages > 0)
                    {
                        workOnSecondPage = false;
                        if (charBetweenBothPages-Math.floor(0.75*numberOfCharsInPage1) <= 0)
                        {
                            firstCharOfPage1 = 0;
                            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                            page1ContentElt.innerHTML = page1Content;
                            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                        }
                        else
                        {
                            firstCharOfPage1 = deplacerApresSaut(charBetweenBothPages - Math.floor(0.75*numberOfCharsInPage1));
                            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                            page1ContentElt.innerHTML = page1Content;
                            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                            if (positionShouldAppearElt1 > window.innerHeight)
                            {
                                supprLignesDeb();
                                reduction10par10Deb();
                            }
                            if (positionShouldNotAppearElt1 < window.innerHeight)
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
            if (firstCharOfPage1 > 0)
            {
                if (charBetweenBothPages-Math.floor(0.75*numberOfCharsInPage1) <= 0)
                {
                    charBetweenBothPages = deplacerAvantSaut(firstCharOfPage1);
                    firstCharOfPage1 = 0;
                    /*while (postCompleteText.substr(firstCharOfPage1-5, 6).indexOf('<') != -1)
                    {
                        charBetweenBothPages += (postCompleteText.substr(charBetweenBothPages-5, 6).indexOf('<') - 6);
                    }*/
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page1ContentElt.innerHTML = page1Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                }
                else
                {
                    charBetweenBothPages = deplacerAvantSaut(firstCharOfPage1);
                    firstCharOfPage1 = deplacerApresSaut(firstCharOfPage1 - Math.floor(0.75*numberOfCharsInPage1));
                    workOnSecondPage = false;
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page1ContentElt.innerHTML = page1Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                    if (positionShouldAppearElt1 > window.innerHeight)
                    {
                        supprLignesDeb();
                        reduction10par10Deb();
                    }
                    if (positionShouldNotAppearElt1 < window.innerHeight)
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
        numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
        if (window.innerWidth > 1500)
        {
            if (lastCharOfPage2 < postCompleteText.length-1)
            {
                firstCharOfPage1 = deplacerApresSaut(lastCharOfPage2);
                if (firstCharOfPage1+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
                {
                    charBetweenBothPages = postCompleteText.length-1;
                    lastCharOfPage2 = postCompleteText.length-1;
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page2Content = '';
                    page1ContentElt.innerHTML = page1Content;
                    page2ContentElt.innerHTML = page2Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                    positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                }
                else
                {
                    charBetweenBothPages = deplacerAvantSaut(firstCharOfPage1 + Math.floor(0.75*numberOfCharsInPage1));
                    lastCharOfPage2 = charBetweenBothPages;
                    workOnSecondPage = false;
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page2Content = '';
                    page1ContentElt.innerHTML = page1Content;
                    page2ContentElt.innerHTML = page2Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                    positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                    if (positionShouldAppearElt1 > window.innerHeight)
                    {
                        supprLignes();
                        reduction10par10();
                    }
                    if (positionShouldNotAppearElt1 < window.innerHeight)
                    {
                        ajoutLignes();
                        reduction10par10();
                    }
                    decoupagePropre();
                    if (charBetweenBothPages < postCompleteText.length-1)
                    {
                        workOnSecondPage = true;
                        if (charBetweenBothPages+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
                        {
                            lastCharOfPage2 = postCompleteText.length-1;
                            page2Content = postCompleteText.substr(charBetweenBothPages, lastCharOfPage2-charBetweenBothPages+1);
                            page2ContentElt.innerHTML = page2Content;
                            positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                            positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                        }
                        else
                        {
                            lastCharOfPage2 = deplacerAvantSaut(charBetweenBothPages + Math.floor(0.75*numberOfCharsInPage1)); // j'ai changé firstCharOfPage1 en charBetweenBothPages, mais ça marchait avant... Bizarre
                            page2Content = postCompleteText.substr(charBetweenBothPages, lastCharOfPage2-charBetweenBothPages+1);
                            page2ContentElt.innerHTML = page2Content;
                            positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
                            positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
                            if (positionShouldAppearElt2 > window.innerHeight)
                            {
                                supprLignes();
                                reduction10par10();
                            }
                            if (positionShouldNotAppearElt2 < window.innerHeight)
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
            if (charBetweenBothPages < postCompleteText.length-1)
            {
                if (charBetweenBothPages+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
                {
                    firstCharOfPage1 = deplacerApresSaut(charBetweenBothPages);
                    charBetweenBothPages = postCompleteText.length-1;
                    /*while (postCompleteText.substr(firstCharOfPage1-5, 6).indexOf('<') != -1)
                    {
                        charBetweenBothPages += (postCompleteText.substr(charBetweenBothPages-5, 6).indexOf('<') - 6);
                    }*/
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page1ContentElt.innerHTML = page1Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                }
                else
                {
                    firstCharOfPage1 = deplacerApresSaut(charBetweenBothPages);
                    charBetweenBothPages = deplacerAvantSaut(charBetweenBothPages + Math.floor(0.75*numberOfCharsInPage1));
                    workOnSecondPage = false;
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page1ContentElt.innerHTML = page1Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
                    if (positionShouldAppearElt1 > window.innerHeight)
                    {
                        supprLignes();
                        reduction10par10();
                    }
                    if (positionShouldNotAppearElt1 < window.innerHeight)
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