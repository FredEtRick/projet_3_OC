<script type="text/javascript">
    
    // FUNCTIONS OFTEN USED BY OTHERS to make preparations this way other functions can be executed in correct environment
    
    // function sending back vertical position of element in the page. "getPositionTop" is the only code I didn't wrote myself. I took it here : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
    function getPositionTop (obj)
    {
		var curtop = 0;
		if (obj.offsetParent)
        {
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {curtop += obj.offsetTop;}
		}
		return curtop;
	}
    
    // just a debuging function.
    function debug(fonction)
    {
        console.log('fonction : ' + fonction + ' workOnSecondPage : ' + workOnSecondPage + ' ; ' + ' firstCharOfPage1 : ' + firstCharOfPage1 + ' charBetweenBothPages : ' + charBetweenBothPages + ' lastCharOfPage2 : ' + lastCharOfPage2 + ' positionShouldAppearElt1 : ' + positionShouldAppearElt1 + ' positionShouldNotAppearElt1 : ' + positionShouldNotAppearElt1 + ' numberCharsLine : ' + numberCharsLine + ' lineHeightPx : ' + lineHeightPx + ' window.innerHeight : ' + window.innerHeight + ' positionShouldNotAppearElt2 : ' + positionShouldNotAppearElt2 + ' positionShouldAppearElt2 : ' + positionShouldAppearElt2 + /*' contenu ' + page1Content +*/ ' contenuGenerique : ' + pageContent_generic);
    }
    
    // use to initialize the generic vars, with vars for page 1 or page 2, depending on the value of "wordOnSecondPage". This function is called at the begin of other functions this way they could work on correct variables without worry about the page.
    function initializeGenericVars()
    {
        if (workOnSecondPage)
        {
            pageContentElt_generic = page2ContentElt;
            pageContent_generic = page2Content;
            shouldAppearElt_generic = shouldAppearElt2;
            shouldNotAppearElt_generic = shouldNotAppearElt2;
            positionShouldAppearElt_generic = positionShouldAppearElt2;
            positionShouldNotAppearElt_generic = positionShouldNotAppearElt2;
            firstCharOfPage_generic = charBetweenBothPages;
            lastCharOfPage_generic = lastCharOfPage2;
        }
        else
        {
            pageContentElt_generic = page1ContentElt;
            pageContent_generic = page1Content;
            shouldAppearElt_generic = shouldAppearElt1;
            shouldNotAppearElt_generic = shouldNotAppearElt1;
            positionShouldAppearElt_generic = positionShouldAppearElt1;
            positionShouldNotAppearElt_generic = positionShouldNotAppearElt1;
            firstCharOfPage_generic = firstCharOfPage1;
            lastCharOfPage_generic = charBetweenBothPages;
        }
        repositioningFirstChar();
    }
    
    // used at the end of other function, after working on generic variables. It use "workOnSecondPage" to know which page is considered, and put values of generic variables in the good variables (variables for page 1 or page 2)
    function updatingNonGenericVars()
    {
        if (workOnSecondPage)
        {
            charBetweenBothPages = firstCharOfPage_generic;
            lastCharOfPage2 = lastCharOfPage_generic;
            page2Content = pageContent_generic;
            positionShouldAppearElt2 = positionShouldAppearElt_generic;
            positionShouldNotAppearElt2 = positionShouldNotAppearElt_generic;
        }
        else
        {
            firstCharOfPage1 = firstCharOfPage_generic;
            charBetweenBothPages = lastCharOfPage_generic;
            page1Content = pageContent_generic;
            positionShouldAppearElt1 = positionShouldAppearElt_generic;
            positionShouldNotAppearElt1 = positionShouldNotAppearElt_generic;
        }
    }
    
    // this function position the first char of the current page (generic variable determined by workOnSecondPage before) just after the "break line" if there is one near. This way, the page doesn't start with a <br />.
    function repositioningFirstChar()
    {
        while (postCompleteText.substr(firstCharOfPage_generic, 4).indexOf('<br') != -1)
        {
            firstCharOfPage_generic += postCompleteText.substr(firstCharOfPage_generic, 7).lastIndexOf('>') + 1;
        }
    }
    
    // Take a char index as parameter, and move it just before the first <br /> near if there is at least one near.
    function moveBeforeNewLine(charIndex)
    {
        while (postCompleteText.substr(charIndex-7, 7).indexOf('<br') != -1)
        {
            charIndex += -7 + postCompleteText.substr(charIndex-7, 7).indexOf('<br') - 1;
        }
        return charIndex;
    }
    
    // Take a char index as parameter, and move it just after the last <br /> near if there is at least one near.
    function moveAfterNewLine(charIndex)
    {
        while (postCompleteText.substr(charIndex, 4).indexOf('<br') != -1)
        {
            charIndex += postCompleteText.substr(charIndex, 7).lastIndexOf('>') + 1;
        }
        return charIndex;
    }
</script>