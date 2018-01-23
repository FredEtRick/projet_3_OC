<?php
    require_once "controler/resizer/nextPages_largeScreen.php";
    require_once "controler/resizer/nextPage_smallScreen.php";
?>

<script type="text/javascript">
    
    // function called when clicking on "next page" button. Use functions in "Resizer_nextPages_largeScreen.php" and "Resizer_nextPage_smallScreen.php".
    
    function nextPage()
    {
        console.log('PAGE SUIVANTE');
        numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
        if (window.innerWidth > 1500)
        {
            if (lastCharOfPage2 < postCompleteText.length-1)
            {
                nextPagesLargeScreen();
            }
        }
        else
        {
            if (charBetweenBothPages < postCompleteText.length-1)
            {
                nextPageSmallScreen();
            }
        }
    }
</script>