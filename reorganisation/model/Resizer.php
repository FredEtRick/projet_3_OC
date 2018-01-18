<script type="text/javascript">
    
    // doit être extrait et remit ailleurs :
    page1ContentElt.innerHTML = page1Content;

function Resizer()
{
    // TEXT AND INDEXES - text and indexes of chars
    this.postCompleteText = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($avecSauts))); ?>'; // All the text of the Post, after beeing treated this way the "next line" and other are manipulables
    this.firstCharOfPage1 = 0; // index of the first char appearing in page one
    this.charBetweenBothPages = 0; // index of last appearing on page one, or first on page 2 (if there's two pages on the screen, on very large screens) this var can represent the last char of page 1 or the first of page 2, beeing modify during execution to fit the needs
    this.lastCharOfPage2; // index of last char appearing on page 2, if there is any. (large screen)
    
    // PAGE 1 - page 1 content, and page 1 delimiters
    this.page1ContentElt = document.getElementById('content'); // The <p> paragraph marker which will contain the text to show on screen in page 1
    this.page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1); // the text to show in previous marker
    this.shouldAppearElt1 = document.getElementById('shouldAppear'); // if this element is not visible when page 1 is loaded, it means the text is to big and it doesn't fit the window. So we'll have to reduct page 1
    this.shouldNotAppearElt1 = document.getElementById('shouldNotAppear'); // if this element, below the precendent, is visible, it means the page 1 is shorter than expected.
    this.positionShouldAppearElt1 = getPositionTop(shouldAppearElt1); // vertical position of element that should appear. This var is used to know if the element that should appear does appear or not.
    this.positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
    
    // PAGE 2 - page 2 content, page 2 delimiters, and some vars and elements to manipulate page 2
    this.page2ContentElt; // same as for page 1
    this.page2Content;
    this.shouldAppearElt2;
    this.shouldNotAppearElt2;
    this.positionShouldAppearElt2;
    this.positionShouldNotAppearElt2;
    this.numberOfCharsInPage1; // used to estimate how much chars should approximatively fit in page 2.
    this.parentElt = document.getElementById('parent'); // element which will contain both pages, and elements relative to both pages (shouldAppear etc)
    this.page2ContainerElt; // element which will contain page2ContentElt, shouldAppear2 and shouldNotAppear2. This element is also the second child of "parent"
    
    // GENERIC PAGE - generic vars to manipulate a page get as parameter (whatever it is page 1 or 2)
    this.pageContentElt_generic;
    this.pageContent_generic;
    this.shouldAppearElt_generic;
    this.shouldNotAppearElt_generic;
    this.positionShouldAppearElt_generic;
    this.positionShouldNotAppearElt_generic;
    this.firstCharOfPage_generic;
    this.lastCharOfPage_generic;
    
    this.workOnSecondPage = false; // boolean determining if we will be working on page 1 or page 2
    
    // PAGE DIMENSIONS - vars used to estimate number of chars and height of lines and pages
    this.numberCharsLine = 0; // approximate number of chars in a line. Approximate because "W" is larger than "." as instance.
    this.lineHeightPx; // line height in pixels
    this.missingHeight; // estimated missing height in pixels to fit the page
    this.missingLines; // estimated number of lines missing to fit the page
    this.missingChars; // same but for chars
}

</script>