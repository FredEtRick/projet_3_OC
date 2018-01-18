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