<?php


class FigController {

    // afichage de la figurine ciblée
    public static function showFig($id = null){
        $figs = null;
        //connexion a la db
        $db = Db::getDb();
        //si on a un id de figurine , alors
        if (isset($id)) {
            // On affiche une seule mini
            $figs = Fig::getFig($id);
            //on envoi le rendu de l'affichage d'une seule mini
            Render::render("display-fig", ['Fig'=>$figs]);
        }
    }
    // afichage de la figurine ciblée pour la partie front
    public static function showPublicFig($id = null){
        $figs = null;
        //connexion a la db
        $db = Db::getDb();
        //si on a un id de figurine , alors
        if (isset($id)) {
            // On affiche une seule mini
            $figs = Fig::getFig($id);
            //on envoi le rendu de l'affichage d'une seule mini
            Render::render("public-display", ['Fig'=>$figs]);
        }
    }

    //creation d'une mini complete
    public static function addFig() {

        // Traite les données du formulaire
        //si le champ n'est pas vide
        if (!empty($_POST)) {
            //declaration d'une image "placeholder" en cas de non envoi d'un fichier a la creation
            $imageName = 'picture.png';
            //si le champ est rempli et qu'une image existe (fonctionne aussi avec le fichier placeholder)
            if (isset($_POST['name']) && isset($_FILES['picture']['name']) ) {
                 // Si une nouvelle image a été chargée
                if(isset($_FILES['picture']) && $_FILES['picture']['name'] !== '') {
                    //connexion a la db
                    $db = Db::getDb();
                    //declaration du dossier dans lequel upload l'image
                    $dossier = "uploads";
                    //declaration du tableau d'erreur
                    $errors= [];
                    //instanciation d'un ulpoad
                    $model = new Uploads();
                    // On l'upload et on change la valeur de 'addImage' dans notre tableau
                    $imageName = $model->uploadFile($_FILES['picture'], $dossier, $errors);
                }
                //instanciation d'une nouvelle mini
                $fig = new Fig();
                //declaration du nom
                $fig->name = $_POST['name'];
                //declaration du fichier ( fonctionne aussi avec le placeholder)
                $fig->picture = $imageName;
                //declaration du fluff de la mini
                $fig->content = $_POST['content'];
                //etablissement de la sauvegarde des données de la mini
                $fig->save();
                // Traitement des peintures
                //si les peintures sont cochées
                if (isset($_POST['paintChecker'])){
                    //pour chaque peinture cochée , on prend son id
                    foreach ($_POST['paintChecker'] as $paint_id) {
                        //on envoi un tableau contenant toutes les id des peintures selectionnées
                        $fig->paints[] = $paint_id;
                    }
                    //on sauvegarde les peintures associées a la mini
                    $fig->savePaints();
                }
            }
            // retour sur la  page principale apres la creation de la mini
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index");
        }
        // affichage du formulaire de creation de la mini
        Render::render("form-fig" , []);
    }

    //mise a jour de la mini
    public static function updateFig($id) {
        //Vérifier qu'on a des données POST
        //instanciation d'une nouvelle mini
        $fig = new Fig();
        //recuperation des infos de la mini grace a getFig , ciblé sur son id
        $figDetail= $fig->getFig($id);
        //recuperation de l'image grace a figDetail ( qui recupere  les infos globales)
        $imageName = $figDetail[0]->picture;
        //recuperation des peintures de la mini
        $colors = $fig->getColorByFig($id);
        //creation d'un tableau de couleur pour recuperer les ID des peintures
        $tab=[];
        //pour chaque couleur
        foreach ($colors as $color){
            //on va chercher dans le tableau de couleur chaque id selectionnée a la creation
            $tab[]= $color['paint_ID'];
        }
        //si le post n'est pas vide
        if (!empty($_POST)) {
            //si tout les champs sont rempli ( peuvent etre null selon la creation dans la db)
            if (isset($_POST['name']) && isset($_FILES['picture']) && isset($_POST['content'])) {
                // Si une nouvelle image a été chargée
                if(isset($_FILES['picture']) && $_FILES['picture']['name'] !== '') {
                    //on verifie que l'image n'est pas le placeholder
                    if($imageName !== 'picture.png'){
                        //on delie l'ancienne image postée
                        unlink('public/uploads/'.$imageName );
                    }
                    //declaration du dossier ou l'image doit etre ulpoadée
                    $dossier = "uploads";
                    //declaration du tableau d'erreur
                    $errors= [];
                    //on instancie un nouvel upload
                    $model = new Uploads();
                    // On l'uploade et on change la valeur de 'addImage' dans notre tableau
                    $imageName = $model->uploadFile($_FILES['picture'], $dossier, $errors);
                }

                //Instancier un nouveau Fig
                $fig = new Fig();
                //on charge les données POST dans le Fig , comme lors de la creation initiale
                $fig->name = $_POST['name'];
                $fig->picture = $imageName;
                $fig->content = $_POST['content'];
                //on lancer la méthode qui update le Fig
                $fig->update($id);
                // on supprime les anciennes paints du fig
                $fig->deletePaints($id);
                // on ajoute les nouvelles paints du fig
                $fig->editPaints($id, $_POST["paintChecker"]);
            }
              // Redirection
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index");
            return;
        }
        //rendu de la page de mise a jour avec les données préchargée pour ne pas avoir a tout réecrire
        Render::render("update-form-fig",["figDetail"=>$figDetail,'tab'=>$tab]);
    }

    //methode de suppression de la mini
    public static function deleteFig($id) {
        //si on a une id de figurine etabli
        if (isset($id)){
            //instanciation de la mini
            $fig = new Fig();
            //on recupere son id
            $fig->ID = $id;
            // Ensuite on supprime la mini
            $fig->deleteFig($id);
            // retour page principale apres delete de la mini
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
            exit();
        }
    }
     public static function findAjax(){
         //recuperation du contenu de mon champ input dans fig-list.phtml
        $content = file_get_contents("php://input");
        //on utilise json_decode pour "traduire" ce que JS nous envoie
        $data = json_decode($content, true);

        if(isset($data['textToFind'])){
            //on extrait de mon input ce qu'il s'y passe
            $search = "%" . $data['textToFind'] . "%" ;
            //on appelle la methode qui lancera la requete de recherche
            $Figs = Fig::searchAjax($search);
            //on visualise le resultat
            include"src/vues/result-fig.phtml";
        }else{
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
            exit();
        }



    }
}