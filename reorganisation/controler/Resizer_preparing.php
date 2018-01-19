<script type="text/javascript">
    // function sending back vertical position of element in the page, "getPositionTop" is the only code I didn't wrote myself. I took it here : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
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
    
    function debug(fonction)
    {
        console.log('fonction : ' + fonction + ' workOnSecondPage : ' + workOnSecondPage + ' ; ' + ' firstCharOfPage1 : ' + firstCharOfPage1 + ' charBetweenBothPages : ' + charBetweenBothPages + ' lastCharOfPage2 : ' + lastCharOfPage2 + ' positionShouldAppearElt1 : ' + positionShouldAppearElt1 + ' positionShouldNotAppearElt1 : ' + positionShouldNotAppearElt1 + ' numberCharsLine : ' + numberCharsLine + ' lineHeightPx : ' + lineHeightPx + ' window.innerHeight : ' + window.innerHeight + ' positionShouldNotAppearElt2 : ' + positionShouldNotAppearElt2 + ' positionShouldAppearElt2 : ' + positionShouldAppearElt2 + /*' contenu ' + page1Content +*/ ' contenuGenerique : ' + pageContent_generic);
    }
    
    function initializationVars()
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
    
    function updatingVars()
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
    
    function repositioningFirstChar()
    {
        while (postCompleteText.substr(firstCharOfPage_generic, 4).indexOf('<br') != -1)
        {
            firstCharOfPage_generic += postCompleteText.substr(firstCharOfPage_generic, 7).lastIndexOf('>') + 1;
        }
    }
    
    function moveBeforeNewLine(caractere)
    {
        while (postCompleteText.substr(caractere-7, 7).indexOf('<br') != -1)
        {
            caractere += -7 + postCompleteText.substr(caractere-7, 7).indexOf('<br') - 1;
        }
        return caractere;
    }
    
    function moveAfterNewLine(caractere)
    {
        while (postCompleteText.substr(caractere, 4).indexOf('<br') != -1)
        {
            caractere += postCompleteText.substr(caractere, 7).lastIndexOf('>') + 1;
        }
        return caractere;
    }
</script>