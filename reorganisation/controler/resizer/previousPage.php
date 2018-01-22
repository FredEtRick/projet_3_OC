<script type="text/javascript" src="Resizer_previousPage_forPrevious.php"></script>
<script type="text/javascript" src="Resizer_previousPages_largeScreen.php"></script>
<script type="text/javascript" src="Resizer_previousPage_smallScreen.php"></script>

<script type="text/javascript">
    
    // function called when clicking on "previous page" button. Use functions in "Resizer_previousPages_largeScreen.php" and "Resizer_previousPage_smallScreen.php", that use themeselves functions in "Resizer_previousPage_forPrevious.php".
    
    function previousPage()
    {
        console.log('PAGE PRECEDENTE');
        numberOfCharsInPage1 = charBetweenBothPages - firstCharOfPage1;
        if (window.innerWidth > 1500)
        {
            if (firstCharOfPage1 > 0)
            {
                previousPagesLargeScreen();
            }
        }
        else
        {
            if (firstCharOfPage1 > 0)
            {
                previousPageSmallScreen();
            }
        }
    }
    
</script>