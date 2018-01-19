<script type="text/javascript">
    
    function justOnePageBefore()
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
    
    function fillingRightPageBefore()
    {
        charBetweenBothPages = moveAfterNewLine(lastCharOfPage2 - Math.floor(0.75*numberOfCharsInPage1));
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
    }
    
    function adjustingRightPageBefore()
    {
        fillingRightPageBefore();
        if (positionShouldAppearElt2 > window.innerHeight)
        {
            deleteSomeLinesAtBegining();
            reduct10by10AtBegining();
        }
        if (positionShouldNotAppearElt2 < window.innerHeight)
        {
            addSomeLinesAtBegining();
            reduct10by10AtBegining();
        }
        cleanStarting();
    }
    
    function leftPageBefore()
    {
        workOnSecondPage = false;
        // if begin is near, left page first char is post first char
        if (charBetweenBothPages-Math.floor(0.75*numberOfCharsInPage1) <= 0)
        {
            firstCharOfPage1 = 0;
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
        }
        else // else, fill the left page
        {
            firstCharOfPage1 = moveAfterNewLine(charBetweenBothPages - Math.floor(0.75*numberOfCharsInPage1));
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
            positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
            if (positionShouldAppearElt1 > window.innerHeight)
            {
                deleteSomeLinesAtBegining();
                reduct10by10AtBegining();
            }
            if (positionShouldNotAppearElt1 < window.innerHeight)
            {
                addSomeLinesAtBegining();
                reduct10by10AtBegining();
            }
            cleanStarting();
        }
    }
    
    function previousPagesLargeScreen()
    {
        lastCharOfPage2 = moveBeforeNewLine(firstCharOfPage1);
        if (lastCharOfPage2-Math.floor(0.75*numberOfCharsInPage1) <= 0)
        {
            justOnePageBefore();
        }
        else
        {
            fillingRightPageBefore()
            adjustingRightPageBefore();
            if (charBetweenBothPages > 0)
            {
                leftPageBefore();
            }
        }
    }
    
</script>