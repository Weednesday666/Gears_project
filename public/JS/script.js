//on charge la page et le script se lance une fois celle ci completement chargée
document.addEventListener('DOMContentLoaded', function() {
    // on utilise strict pour securiser le tout
    'use strict';
    //on declare la variable qui va fouiller la page , selectionner le champ ciblé
    let input = document.querySelector('#search');
    //on vient surveiller le clavier a chaque fois qu'une touche se releve
    //avec un keydown , il faut retaper sur une touche pour "ecouter" la frappe precedente
    input.addEventListener('keyup', () => {
        //on declare une variable qui va recuperer ce qui a été taper
        let textFind = document.querySelector('#search').value;
        //la variable va envoyer au php ce qu'elle recoit , et la , le php prends la main
        let req = new Request('https://thomascavelier.sites.3wa.io/GEARS_FINAL/fig', {
            method: "POST",
            body: JSON.stringify({ textToFind: textFind })
        });
        //le php a gerer son truc dans son coin et on vient piocher ses resultat
        fetch(req)
            //via une promesse on va chercher la reponse
            .then(res => res.text())
            //ensuite on va afficher le resultat de la recherche dans le html
            .then(res => {
                document.querySelector("#listOfFigs").innerHTML = res;
            });

    });

});
