<script type="text/javascript">
    
    // FUNCTIONS USED BY "NEXT PAGE" BUTTON WHEN WINDOW IS AT LESS THAN 1500 PX LARGE
    
    // used by previousPageSmallScreen below when the begin of the post is near, to add the first page.
    function untilBeginOfPost()
    {
        charBetweenBothPages = moveBeforeNewLine(firstCharOfPage1);
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
    
    // used by previousPageSmallScreen below when the begin of the post is not so near, to fill a new page, before adjustments.
    function fillingPageBefore()
    {
        charBetweenBothPages = moveBeforeNewLine(firstCharOfPage1);
        firstCharOfPage1 = moveAfterNewLine(firstCharOfPage1 - Math.floor(0.75*numberOfCharsInPage1));
        workOnSecondPage = false;
        page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
        page1ContentElt.innerHTML = page1Content;
        positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
        positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
    }
    
    // used by previousPageSmallScreen below when the begin of the post is not so near, to adjust the new page when already filled.
    function adjustingPageBefore()
    {
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
    
    // directly called by "previousPage" function when window is less than 1500 px large.
    function previousPageSmallScreen()
    {
        if (charBetweenBothPages-Math.floor(0.75*numberOfCharsInPage1) <= 0)
        {
            untilBeginOfPost();
        }
        else
        {
            fillingPageBefore();
            adjustingPageBefore();
        }
    }
    
</script>