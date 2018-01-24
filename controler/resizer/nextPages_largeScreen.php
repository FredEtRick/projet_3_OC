<script type="text/javascript">
    
    // FUNCTIONS USED BY "NEXT PAGE" BUTTON WHEN WINDOW IS AT LEAST 1500 PX LARGE
    
    // used by nextPagesLargeScreen below when EOF is near and we couldn't add more than one page.
    function justOneMorePage()
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
    
    // used by nextPagesLargeScreen below when EOF is not so near, to add one more page, before adding another if possible.
    function firstPageMore()
    {
        charBetweenBothPages = moveBeforeNewLine(firstCharOfPage1 + Math.floor(0.75*numberOfCharsInPage1));
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
            deleteSomeLines();
            reduct10by10();
        }
        if (positionShouldNotAppearElt1 < window.innerHeight)
        {
            addSomeLines();
            reduct10by10();
        }
        cleanEnding();
    }
    
    // used by nextPagesLargeScreen below when EOF is not so near and one page is already added, to add the second one.
    function secondPageMore()
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
            lastCharOfPage2 = moveBeforeNewLine(charBetweenBothPages + Math.floor(0.75*numberOfCharsInPage1)); // j'ai changé firstCharOfPage1 en charBetweenBothPages, mais ça marchait avant... Bizarre
            page2Content = postCompleteText.substr(charBetweenBothPages, lastCharOfPage2-charBetweenBothPages+1);
            page2ContentElt.innerHTML = page2Content;
            positionShouldAppearElt2 = getPositionTop(shouldAppearElt2);
            positionShouldNotAppearElt2 = getPositionTop(shouldNotAppearElt2);
            if (positionShouldAppearElt2 > window.innerHeight)
            {
                deleteSomeLines();
                reduct10by10();
            }
            if (positionShouldNotAppearElt2 < window.innerHeight)
            {
                addSomeLines();
                reduct10by10();
            }
            cleanEnding();
        }
    }
    
    // directly called by "nextPage" function when window is more than 1500 px large.
    function nextPagesLargeScreen()
    {
        firstCharOfPage1 = moveAfterNewLine(lastCharOfPage2);
        if (firstCharOfPage1+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
        {
            justOneMorePage();
        }
        else
        {
            firstPageMore()
            if (charBetweenBothPages < postCompleteText.length-1)
            {
                secondPageMore()
            }
        }
    }
    
</script>