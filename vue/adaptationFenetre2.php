<script text="javascript">
    
    // fonction qui renvoie position verticale élément dans page, récupérée ici : https://forum.alsacreations.com/topic-5-38724-1-Calculer-la-position-dun-element-en-javascript.html
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
    
    // création d'un tableau pour accéder aux variables dans toutes les fonctions, passer tout le tableau a chaque fois. Note ajouter une variable "milieu" pour la fin de la page de gauche, et "fin" pour la fin de la page de droite ? Et une variable contexte qui détermine si on est dans la première ou la deuxième page. Si on est dans la première, faire les calculs avec deb et milieu, sinon avec milieu et fin. Gérer les pages autres qu'au début, et gérer la complexité
    // sinon pas de tableau, tout comme avant, mais création en amont des paragraphes nécessaires a la seconde page, création des le début de vars milieu et contexte, et plus besoin de passer de paramètres !
    var tab = new Object();
    tab['texte'] = '<?php echo str_replace('"', '\"', str_replace("'", "\'", json_encode($avecSauts))); ?>';
    
    
</script>