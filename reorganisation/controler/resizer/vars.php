<script type="text/javascript">

    // ALL THE VARS USED TO RESIZE PAGE
    
    // TEXT AND INDEXES - text and indexes of chars
    var postCompleteText = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($textWithNewLines))); ?>'; // All the text of the Post, after beeing treated this way the "next line" and other are manipulables
    var firstCharOfPage1 = 0; // index of the first char appearing in page one
    var charBetweenBothPages = 0; // index of last appearing on page one, or first on page 2 (if there's two pages on the screen, on very large screens) this var can represent the last char of page 1 or the first of page 2, beeing modify during execution to fit the needs
    var lastCharOfPage2; // index of last char appearing on page 2, if there is any. (large screen)
    
    // PAGE 1 - page 1 content, and page 1 delimiters
    var page1ContentElt = document.getElementById('content'); // The <p> paragraph marker which will contain the text to show on screen in page 1
    var page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1); // the text to show in previous marker
    page1ContentElt.innerHTML = page1Content;
    var shouldAppearElt1 = document.getElementById('shouldAppear'); // if this element is not visible when page 1 is loaded, it means the text is to big and it doesn't fit the window. So we'll have to reduct page 1
    var shouldNotAppearElt1 = document.getElementById('shouldNotAppear'); // if this element, below the precendent, is visible, it means the page 1 is shorter than expected.
    var positionShouldAppearElt1 = getPositionTop(shouldAppearElt1); // vertical position of element that should appear. This var is used to know if the element that should appear does appear or not.
    var positionShouldNotAppearElt1 = getPositionTop(shouldNotAppearElt1);
    
    // PAGE 2 - page 2 content, page 2 delimiters, and some vars and elements to manipulate page 2
    var page2ContentElt; // same as for page 1
    var page2Content;
    var shouldAppearElt2;
    var shouldNotAppearElt2;
    var positionShouldAppearElt2;
    var positionShouldNotAppearElt2;
    var numberOfCharsInPage1; // used to estimate how much chars should approximatively fit in page 2.
    var parentElt = document.getElementById('parent'); // element which will contain both pages, and elements relative to both pages (shouldAppear etc)
    var page2ContainerElt; // element which will contain page2ContentElt, shouldAppear2 and shouldNotAppear2. This element is also the second child of "parent"
    
    // GENERIC PAGE - generic vars to manipulate a page get as parameter (whatever it is page 1 or 2)
    var pageContentElt_generic;
    var pageContent_generic;
    var shouldAppearElt_generic;
    var shouldNotAppearElt_generic;
    var positionShouldAppearElt_generic;
    var positionShouldNotAppearElt_generic;
    var firstCharOfPage_generic;
    var lastCharOfPage_generic;
    
    var workOnSecondPage = false; // boolean determining if we will be working on page 1 or page 2
    
    // PAGE DIMENSIONS - vars used to estimate number of chars and height of lines and pages
    var numberCharsLine = 0; // approximate number of chars in a line. Approximate because "W" is larger than "." as instance.
    var lineHeightPx; // line height in pixels
    var missingHeight; // estimated missing height in pixels to fit the page
    var missingLines; // estimated number of lines missing to fit the page
    var missingChars; // same but for chars
    
    // BUTTONS PREVIOUS NEXT
    var pagesButtonsElt = document.createElement('p');
    var previousButtonElt = document.createElement('button');
    var nextButtonElt = document.createElement('button');
    parentElt.appendChild(pagesButtonsElt);
    pagesButtonsElt.appendChild(previousButtonElt);
    pagesButtonsElt.appendChild(nextButtonElt);
    pagesButtonsElt.classList.add('navPages');
    pagesButtonsElt.classList.add('col-xxl-12');
    pagesButtonsElt.classList.add('col-xl-12');
    pagesButtonsElt.classList.add('col-sm-12');
    previousButtonElt.classList.add('fa');
    previousButtonElt.classList.add('fa-chevron-left');
    nextButtonElt.classList.add('fa');
    nextButtonElt.classList.add('fa-chevron-right');

</script>