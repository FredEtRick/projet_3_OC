<script type="text/javascript" src="Resizer_nextPages_largeScreen.php"></script>
<script type="text/javascript" src="Resizer_nextPage_smallScreen.php"></script>

<script type="text/javascript">
    
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