<!--
    A REECRIRE !!!!!!!!!!!!!
    - passer en anglais
    - corriger noms variables en fonction des autres fichiers (ex : $avecSauts n'existe plus)
    - subdiviser le code et le rendre plus digeste
    - passer en objet ?
    - peut être lui même divisé en MVC ??? Je vois mal la vue, mais en objet quasi tout passe dans le modèle, et les exécutions dans le controleur
    - ou alors, la vue est onePostView !!! visitorControler devient allPostsControler, et resizePage devient onePostControler !!!
    - ou alors, passer tout le fichier en modèle en le transformant en classe, puis inclure le modèle dans visitorControler, puis appeler les methodes dans visitorControler.
    - problème : c'est un script JS, pas une classe PHP !

    Verdict : ce serait trop compliqué de me mettre aux classes en JS, donc je vais laisser comme ça.
-->



<!--
    TODO :
    - mettre toutes les pages Resizer_machin en POO et entre balises JS
    - traduire cette page et les resizer_machin
    - réorganiser cette page
    - subdiviser les méthodes pageSuivante et page précédente
    - diviser fichier resizer_nextPage en deux ?
-->



<script type="text/javascript" src="Resizer.php"></script>
<script type="text/javascript" src="Resizer_preparing.php"></script>
<script type="text/javascript" src="Resizer_starting.php"></script>
<script type="text/javascript" src="Resizer_forStartAndNextPage.php"></script>
<script type="text/javascript" src="Resizer_nextPage.php"></script>
<script type="text/javascript" src="Resizer_previousPage.php"></script>

<script type="text/javascript">
    
    // doit être extrait et remit ailleurs :
    page1ContentElt.innerHTML = page1Content;
    
    adapter();
    
    /*function remplirLigne() // remplir la première ligne pour calculer la longueur d'une ligne
    {
        while ((charBetweenBothPages > (firstCharOfPage1 + 150)) && (window.innerHeight < positionShouldAppearElt1) && (positionShouldAppearElt1 == getPositionTop(shouldAppearElt1)))
        {
            charBetweenBothPages--;
            while (postCompleteText.substr(charBetweenBothPages-2, 2).indexOf('\\') != -1)
            {
                charBetweenBothPages -= 2;
            }
            page1Content = postCompleteText.substr(firstCharOfPage1, charBetweenBothPages-firstCharOfPage1+1);
            page1ContentElt.innerHTML = page1Content;
            if (positionShouldAppearElt1 > getPositionTop(shouldAppearElt1))
            {
                lineHeightPx = positionShouldAppearElt1 - getPositionTop(shouldAppearElt1);
            }
            debuger('viderLigne');
        }
        positionShouldAppearElt1 = getPositionTop(shouldAppearElt1);
    }*/
    
    function adapter() // adapte le texte a la place dispo dans la fenêtre, présente une page
    {
        // note : code divisé pour plus de clarté
        
        compterCharsLigne();
        
        ajoutPleinLignes();
        
        // réduction 10 par 10 jusqu'arrivé à la taille voulue
        reduction10par10();
        
        // stop la page à la fin d'un mot, ou juste avant un saut de ligne s'il y en a un proche (à la fin d'un paragraphe par exemple)
        decoupagePropre();
        
        /*var page2ContentElt;
        var page2Content;
        var shouldAppearElt2;
        var shouldNotAppearElt2;
        var positionShouldAppearElt2;
        var positionShouldNotAppearElt2;*/
        
        startingSecondPage();
    }
    
    // pageSuivante pagePrecedente
    
    parentElt.appendChild(pagesButtonsElt);
    pagesButtonsElt.appendChild(previousButtonElt);
    pagesButtonsElt.appendChild(nextButtonElt);
    pagesButtonsElt.classList.add('navPages');
    pagesButtonsElt.classList.add('col-xxl-12');
    pagesButtonsElt.classList.add('col-xl-12');
    pagesButtonsElt.classList.add('col-sm-12');
    previousButtonElt.classList.add('fa');
    previousButtonElt.classList.add('fa-chevron-left');
    previousButtonElt.setAttribute('onclick', 'pagePrecedente()');
    nextButtonElt.classList.add('fa');
    nextButtonElt.classList.add('fa-chevron-right');
    nextButtonElt.setAttribute('onclick', 'pageSuivante()');

</script>