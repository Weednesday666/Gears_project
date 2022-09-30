<?php


class FigController {

    // afichage de la figurine ciblée
    public static function showFig($id = null){
        $figs = null;
        $db = Db::getDb();
        if (isset($id)) {
            // On affiche une seule mini
            $figs = Fig::getFig($id);
            Render::render("display-fig", ['Fig'=>$figs]);
        }
    }

    public static function addFig() {

        // Traite les données du formulaire
        if (!empty($_POST)) {
            if (isset($_POST['name']) && isset($_FILES['picture']['name']) ) {
                 // Si une nouvelle image a été chargée
                if(isset($_FILES['picture']) && $_FILES['picture']['name'] !== '') {
                    $db = Db::getDb();
                    $dossier = "uploads";
                    $errors= [];
                    $model = new Uploads();
                    // On l'upload et on change la valeur de 'addImage' dans notre tableau
                    $imageName = $model->uploadFile($_FILES['picture'], $dossier, $errors);
                }

                $fig = new Fig();
                $fig->name = $_POST['name'];
                $fig->picture = $imageName;
                $fig->content = $_POST['content'];

                $fig->save();

                // Traitement des peintures
                if (isset($_POST['paintChecker'])){
                    foreach ($_POST['paintChecker'] as $paint_id) {
                        $fig->paints[] = $paint_id;
                    }

                    $fig->savePaints();
                }
            }


            // retour sur la  page principale apres la creation de la mini
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index");


        }

        // affichage du formulaire de creation de la mini
        Render::render("form-fig" , []);
    }


    public static function updateFig($id) {
        //Vérifier qu'on a des données POST
        $fig = new Fig();
        $figDetail= $fig->getFig($id);
        //var_dump($fig[0]->name);die;
        if (!empty($_POST)) {
            if (isset($_POST['name']) && isset($_FILES['picture']) && isset($_POST['content'])) {
                // Si une nouvelle image a été chargée
                if(isset($_FILES['picture']) && $_FILES['picture']['name'] !== '') {
                    $dossier = "uploads";
                    $errors= [];
                    $model = new Uploads();
                    // On l'uploade et on change la valeur de 'addImage' dans notre tableau
                    $imageName = $model->uploadFile($_FILES['picture'], $dossier, $errors);

                }

                //Instancier un nouveau Fig
                $fig = new Fig();

                //Charger les données POST dans le Fig
                $fig->name = $_POST['name'];
                $fig->picture = $imageName;
                $fig->content = $_POST['content'];
                // Lancer la méthode qui update le Fig
                $fig->update($id);
                // Supprimer les anciennes paints du fig
                $fig->deletePaints($id);
                // Ajouter les nouvelles paints du fig
                $fig->editPaints($id, $_POST["paintChecker"]);
            }
              // Redirection

            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index");
            return;

        }
        Render::render("update-form-fig",["figDetail"=>$figDetail]);
    }


    public static function deleteFig($id) {

        if (isset($id)){
            $fig = new Fig();
            $fig->ID = $id;

            // D'abord on supprime les clés étrangères
            //$fig->deletePaints($id);
            // Ensuite on supprime la figurine
            $fig->deleteFig($id);

            // retour page principale apres delete de la mini
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
            return;
        }

    }




}