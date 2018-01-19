<script type="text/javascript">
    
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