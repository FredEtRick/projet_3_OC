<script type="text/javascript">
    
    // FUNCTIONS USED BY "PREVIOUS PAGE" BUTTON
    
    // check if there is too much lines at the begin of the page. To do so, it check if the end of the page is still visible, comparing "getPositionTop" and "window.innerHeight". Then delete those exceding lines if needed.
    function deleteSomeLinesAtBegining()
    {
        initializeGenericVars();
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
            debuger('deleteSomeLinesAtBegining');
        }
        firstCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        updatingNonGenericVars();
    }
    
    // Same thing as deleteSomeLinesAtBegining, but rather add lines if the page is too small.
    function addSomeLinesAtBegining()
    {
        initializeGenericVars();
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
            debuger('addSomeLinesAtBegining');
        }
        //lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré. a réadapter pour cette fonction plus tard !!!
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        updatingNonGenericVars();
    }
    
    // to avoid half lines at the begin of a page, delete chars 10 by 10 until there's one less line in page. 10 by 10, this way the execution doesn't last too much, and because the line doesn't need to be perfectly full.
    function reduct10by10AtBegining()
    {
        initializeGenericVars();
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
        updatingNonGenericVars();
    }
    
    // To avoid pages begining with non complete words, or begining just before a <br />, this function move and of page until it's "clean".
    function cleanStarting()
    {
        initializeGenericVars();
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
        updatingNonGenericVars();
        console.log('?????????? ' + page1Content);
    }
    
</script>