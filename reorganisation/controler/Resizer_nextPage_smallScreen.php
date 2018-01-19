<script type="text/javascript">
    
    // FUNCTIONS USED BY "NEXT PAGE" BUTTON WHEN WINDOW IS AT LESS THAN 1500 PX LARGE
    
    // used by nextPageSmallScreen below when EOF is near, to add the last page.
    function untilEOF()
    {
        firstCharOfPage1 = moveAfterNewLine(charBetweenBothPages);
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
    
    // used by nextPageSmallScreen below when EOF is not so near, to fill a new page, before adjustments.
    function fillingNewPage()
    {
        firstCharOfPage1 = moveAfterNewLine(charBetweenBothPages);
        charBetweenBothPages = moveBeforeNewLine(charBetweenBothPages + Math.floor(0.75*numberOfCharsInPage1));
        workOnSecondPage = false;
        page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
        page1ContentElt.innerHTML = page1Content;
        positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
        positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
    }
    
    // used by nextPageSmallScreen below when EOF is not so near, to adjust the new page when already filled.
    function adjustingNewPage()
    {
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
    
    // directly called by "nextPage" function when window is less than 1500 px large.
    function nextPageSmallScreen()
    {
        if (charBetweenBothPages+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
        {
            untilEOF();
        }
        else
        {
            fillingNewPage();
            adjustingNewPage();
        }
    }
    
</script>