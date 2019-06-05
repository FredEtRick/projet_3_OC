<?php
    require_once "controler/resizer/preparing.php";
    require_once "controler/resizer/vars.php";
    require_once "controler/resizer/starting.php";
    require_once "controler/resizer/forStartAndNextPage.php";
    require_once "controler/resizer/nextPage.php";
    require_once "controler/resizer/previousPage.php";
?>

<script type="text/javascript">
    
    
    // FIRST RESIZING - when "opening" the post. Functions in "Resizer_starting.php" and "Resizer_forStartAndNextPage.php". Those functions themselves use functions in "Resizer_preparing.php".
    countCharsLine();
    addLotOfLines();
    reduct10by10();
    cleanEnding();
    startingSecondPage();
    
    // CHANGING PAGE RESIZING - resizing again when changing pages of post with "next page" and "previous page" buttons.
    previousButtonElt.setAttribute('onclick', 'previousPage()'); // Functions in "Resizer_previousPage.php". Those functions themselves use functions in "Resizer_preparing.php".
    nextButtonElt.setAttribute('onclick', 'nextPage()'); // Functions in "Resizer_nextPage.php" and "Resizer_forStartAndNextPage.php". Those functions themselves use functions in "Resizer_preparing.php".

</script>