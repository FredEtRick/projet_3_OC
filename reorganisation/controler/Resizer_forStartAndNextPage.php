<script type="text/javascript">
    function deleteSomeLines()
    {
        initializationVars();
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
        updatingVars();
    }
    
    function addSomeLines()
    {
        initializationVars();
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
        updatingVars();
            debuger('addSomeLines');
    }
    
    function reduct10by10()
    {
        initializationVars();
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
        updatingVars();
    }
    
    function cleanEnding()
    {
        initializationVars();
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
        updatingVars();
    }
</script>