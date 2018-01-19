<script type="text/javascript">
    function nextPage()
    {
        console.log('PAGE SUIVANTE');
        numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
        if (window.innerWidth > 1500)
        {
            if (lastCharOfPage2 < postCompleteText.length-1)
            {
                firstCharOfPage1 = moveAfterNewLine(lastCharOfPage2);
                if (firstCharOfPage1+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
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
                else
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
                    if (charBetweenBothPages < postCompleteText.length-1)
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
                }
            }
        }
        else
        {
            if (charBetweenBothPages < postCompleteText.length-1)
            {
                if (charBetweenBothPages+Math.floor(0.75*numberOfCharsInPage1) >= postCompleteText.length-1)
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
                else
                {
                    firstCharOfPage1 = moveAfterNewLine(charBetweenBothPages);
                    charBetweenBothPages = moveBeforeNewLine(charBetweenBothPages + Math.floor(0.75*numberOfCharsInPage1));
                    workOnSecondPage = false;
                    page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
                    page1ContentElt.innerHTML = page1Content;
                    positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
                    positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
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
            }
        }
    }
</script>