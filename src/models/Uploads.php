<?php


//on etablit ou le fichier doit etre uplaod
const UPLOADS_DIR = 'public/';
//extensions acceptées pour les images
const FILE_EXT_IMG = ['jpg','jpeg','gif','png'];
//Constante MIME_TYPES permettant de vérifier les fichiers uploadés
const MIME_TYPES = array(
    // images
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg'
);

class Uploads {
//Définit le répertoire dans lequel télécharger les fichiers utilisateurs
    public function uploadFile(array $file, string $dossier = '', array $errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG) {
        $filename = '';
        // On récupère l'extension du fichier pour vérifier si elle est dans $fileExtensions
        $tmpNameArray = explode(".", $file["name"]);
        $tmpExt = end($tmpNameArray);
        //si le fichier est conforme , il n'y a aucune erreur d'upload
        if ($file["error"] === UPLOAD_ERR_OK) {
            $tmpName = $file["tmp_name"];
            //on rajopute un id unique avant le nom du fichier pour eviter les conflits de nommage des fichiers upload par l'utilisateur
            if(in_array($tmpExt,$fileExtensions)) {
                $filename = uniqid().'-'.basename($file["name"]);
                //si le dossier ou le fichier n'est pas conforme aux demandes
                if(!move_uploaded_file($tmpName, $folder.$dossier."/".$filename)) {
                    //le tableau d'erreurs envoi un message d'ereur
                    $errors[] = "Le fichier n'a pas été enregistré correctement";
                }
                // mime_content_type
                // Détecte le type de contenu d'un fichier.
                // On vérifie le contenue de fichier, pour voir s'il appartient aux MIMES autorises.
                if(!in_array(mime_content_type($folder.$dossier."/".$filename), MIME_TYPES, true)) {
                    //si probleme , le tableau d'erreur envoi un message d'erreur
                    $errors[] = "Le fichier n'a pas été enregistré correctement car son contenu ne correspond pas à son extension !";
                }
            //sinon
            }else{
                //le tableau renvoi un message d'erreur
                $errors[] = "Ce type de fichier n'est pas autorisé !";
            }
            //si le fichier est trop volumineux
        }else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
            //le tableau renvoi une erreur 
            $errors[] = "Le fichier est trop volumineux";
        //sinon
        }else{
            //le tableau renvoi une erreur
            $errors[] = "Une erreur a eu lieu au moment de l'upload";
        }
        //renvoi le nom de l'image
        return $filename;
    }

}

