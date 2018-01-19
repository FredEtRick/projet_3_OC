<script type="text/javascript">
    // FUNCTIONS USED FOR FIRST RESIZING when opening a post. Not used when changing pages. Those functions use themselves functions in the file "Resizer_forStartAndNextPage.php".
    
    // counting approximative number of chars by line. Use a full line this way it can approach the average.
    function countCharsLine()
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
            debuger('countCharsLine');
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
    
    // function used when we first open the post, so we don't know yet, even approximatively, how much chars will be in each pages. Executed after countCharsLine. This way its execution doesn't last to much, it compute an estimation, base on line height and window.innerHeight, of how much lines we will need to add this way we could approximatively fit the page. It does add all those lines, then Resize_page call other functions to ajust things.
    function addLotOfLines()
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
                deleteSomeLines();
            }
            if (window.innerHeight > positionShouldNotAppearElt1) // si on a pas assez ajouté, ajouter ligne par ligne
            {
                addSomeLines();
            }
            // sinon c'est bon*/
        }
    }
    
    // called when starting to read a post. Try to know if a second page is needed (if the window is more than 1500px large) then if it is, add it and resize it.
    function startingSecondPage()
    {
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
                    deleteSomeLines(); // reste a ajouter decoupage propre etc
                    reduct10by10();
                    cleanEnding();
                }
                else if (getPositionTop(shouldNotAppearElt2) < window.innerHeight) // pas assez loin
                {
                    addSomeLines();
                    reduct10by10();
                    cleanEnding();
                }
                // vérifie découpage mot
            }
        }
    }
</script>