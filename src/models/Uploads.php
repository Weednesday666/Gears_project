<?php



const UPLOADS_DIR = 'public/';


//extensions acceptées pour les images
const FILE_EXT_IMG = ['jpg','jpeg','gif','png'];

//Constante MIME_TYPES permettant de vérifier les fichiers uploadés

const MIME_TYPES = array(

    // images
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',

);

class Uploads {

//Définit le répertoire dans lequel télécharger les fichiers utilisateurs

    public function uploadFile(array $file, string $dossier = '', array &$errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG) {
        $filename = '';
        // On récupère l'extension du fichier pour vérifier si elle est dans $fileExtensions
        $tmpNameArray = explode(".", $file["name"]);
        $tmpExt = end($tmpNameArray);

        if ($file["error"] === UPLOAD_ERR_OK) {
            $tmpName = $file["tmp_name"];

            if(in_array($tmpExt,$fileExtensions)) {
                $filename = uniqid().'-'.basename($file["name"]);
                if(!move_uploaded_file($tmpName, $folder.$dossier."/".$filename)) {
                    $errors[] = "Le fichier n'a pas été enregistré correctement";
                }
                // mime_content_type
                // Détecte le type de contenu d'un fichier.
                // On vérifie le contenue de fichier, pour voir s'il appartient aux MIMES autorises.
                if(!in_array(mime_content_type($folder.$dossier."/".$filename), MIME_TYPES, true)) {
                    // var_dump(mime_content_type($folder.$filename));
                    $errors[] = "Le fichier n'a pas été enregistré correctement car son contenu ne correspond pas à son extension !";
                }
            }
            else{
                $errors[] = "Ce type de fichier n'est pas autorisé !";
            }
        }
        else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
            $errors[] = "Le fichier est trop volumineux";
        }
        else {
            $errors[] = "Une erreur a eu lieu au moment de l'upload";
        }
        return $filename;
    }

}

