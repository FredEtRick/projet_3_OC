<script type="text/javascript">
    
    function previousPageSmallScreen()
    {
        if (charBetweenBothPages-Math.floor(0.75*numberOfCharsInPage1) <= 0)
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
        else
        {
            charBetweenBothPages = moveBeforeNewLine(firstCharOfPage1);
            firstCharOfPage1 = moveAfterNewLine(firstCharOfPage1 - Math.floor(0.75*numberOfCharsInPage1));
            workOnSecondPage = false;
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
    
</script>