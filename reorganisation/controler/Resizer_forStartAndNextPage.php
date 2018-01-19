<script type="text/javascript">
    
    // THIS FILE CONTAIN FUNCTIONS USED BY OTHER FUNCTIONS, IN "Resizer_starting.php" AND "Resizer_nextPage.php" PAGES, to resize the page(s) when opening the post at first, or when clicking on "next page" button.
    
    // check if there is too much lines at the end of the page. To do so, it check if the end of the page is still visible, comparing "getPositionTop" and "window.innerHeight". Then delete those exceding lines if needed.
    function deleteSomeLines()
    {
        initializeGenericVars();
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
            debuger('deleteSomeLines');
        }
        lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        updatingNonGenericVars();
    }
    
    // Same thing as deleteSomeLines, but rather add lines if the page is too small.
    function addSomeLines()
    {
        initializeGenericVars();
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
            debuger('addSomeLines');
        }
        //lastCharOfPage_generic += numberCharsLine; // au cas où on ait un peu trop retiré. a réadapter pour cette fonction plus tard !!!
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        positionShouldNotAppearElt_generic = getPositionTop(shouldNotAppearElt_generic);
        updatingNonGenericVars();
            debuger('addSomeLines');
    }
    
    // to avoid half lines at the end of a page, delete chars 10 by 10 until there's one less line in page. 10 by 10, this way the execution doesn't last too much, and because the line doesn't need to be perfectly full.
    function reduct10by10()
    {
        initializeGenericVars();
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
        updatingNonGenericVars();
    }
    
    // To avoid pages ending with non complete words, or ending just after a <br />, this function move and of page until it's "clean".
    function cleanEnding()
    {
        initializeGenericVars();
        if (postCompleteText.substr(lastCharOfPage_generic-16, 32).indexOf('<br') != -1) // si il y a des sauts de lignes autour non détectés, se mettre juste avant le premier d'entre eux
        {
            lastCharOfPage_generic = lastCharOfPage_generic - 16 + postCompleteText.substr(lastCharOfPage_generic-16, 32).indexOf('<br') - 1;
            debuger('cleanEndingBr');
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
                debuger('cleanEndingChars');
            } while ((lastCharOfPage_generic > firstCharOfPage_generic + 150) && (postCompleteText.charAt(lastCharOfPage_generic) != ' ')); // jusqu'à tomber sur un espace. Evite de trop réduire aussi. TODO : Vérifier accents aussi
        }
        pageContent_generic = postCompleteText.substr(firstCharOfPage_generic, lastCharOfPage_generic-firstCharOfPage_generic+1);
        pageContentElt_generic.innerHTML = pageContent_generic;
        positionShouldAppearElt_generic = getPositionTop(shouldAppearElt_generic);
        updatingNonGenericVars();
    }
</script>