<?php

// declaration de la class Paint
class PaintController {

        public static function getPaints() {
            // Récupère les données
            $paints = Paint::getPaints();
        }
    }


// declaration de la class Fig
class Fig {
    public int $ID;
    public ?string $name = null;
    public ?string $picture;
    public ?string $content = null;
    public $paints;
    //constructor
    public function __construct() {
        $this->ID = 0;
        $this->paints = [];
    }


    // recuperation de toutes les infos des minis
    public static function getFigs () {
        //connexion a la db
        $db = Db::getDb();
        //on prepare une requete ou on selectionne toutes les infos et on les envoi par ordre alphabetique
        $query=$db->prepare("SELECT * FROM Fig  ORDER BY name");
        //on execute la requete
        $query->execute();
        //on recupere dans la db ce dont on a besoin
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());
        //on retourne la requete
        return $query->fetchAll();
    }


    //recuperation des infos d'une mini specifique
    public static function getFig($ID){
        //connexion a la db
        $db = Db::getDb();
        //on prepare une requete pour recuperer toutes les infos d'une mini specifique , ciblé par son id
        $query=$db->prepare("SELECT * FROM Fig WHERE id= :id");
        //on etablit son parametres d'id
        $params= ['id'=> $ID];
        //on execute la requete
        $query->execute($params);
        //on recupere dans la db les infos dont on a besoin
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());
        //on retourne la requete
        $result = $query->fetchAll();
        //si le resultat de la requete ne renvoi rien
        if(empty($result)){
            //on renvoi sur l'index
            header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
                exit();
        }
        //et si elle existe, on la renvoie
        return $result;
    }



    //recuperation des couleurs affectées a la figurine via son ID
     public static function getColorByFig($ID){
         //connexion a la db
        $db = Db::getDb();
        //on prepare une requete ou on va chercher son id via une table de liaison
        //la table va mettre en relation les mini et les peintures
        //ici , on va recuperer l'id de la peinture qui a été liée a l'id de la mini
        $query=$db->prepare("SELECT paint_ID FROM link_fig2paint WHERE fig_ID= :id");
        //on etablit son paramnetre d'id
        $params= ['id'=> $ID];
        //on execute la requete
        $query->execute($params);
        //on retourne la requete
        return $query->fetchAll();
    }


    //recuperation du lien figurine / peinture
    public static function getFigPaints($ID) {
        //connexion a la db
        $db = Db::getDb();
        //on prepare la requete qui va recuperer toutes les données de la peinture
        //on recupere ces donées via la table de liaison mini/peinture
        //ici , on recupere les données liées a l'id de la peinture ET de la mini
        $query=$db->prepare("SELECT Paint.* FROM Paint, link_fig2paint
                WHERE Paint.ID = link_fig2paint.paint_ID AND link_fig2paint.fig_ID = :id");
        //on etablit son parametre d'id
        $params= ['id'=> $ID];
        //on execute la requete
        $query->execute($params);
        //on recupere dans la db les données necessaire
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Paint");
        //on retourne la requete
        return $query->fetchAll();
    }


    // creation d'une nouvelle Fig via le formulaire de crea (vues/form-fig.php)
        public function save(): int {
            //connexion a la db
            $db = Db::getDb();
            //on execute une requete qui va inserer des valeurs données dans une table nommée de la db
            $insertQuery = $db->prepare('INSERT INTO Fig (name , picture , content) VALUES (:name, :picture, :content)');
            //Oon declare et etabli les données
            $pushFig= [
                'name'=> $this->name,
                'picture'=> $this->picture,
                'content'=> $this->content
            ];
            //on execute la requete
            $insertQuery->execute($pushFig);
            // on recupere la derniere id crée
            $this->ID = $db->lastInsertId();
            //on renvoi l'id en question
            return $this->ID;
        }


    //sauvegarde du lien mini/peinture
        public function savePaints(): void {
            //connexion a la db
            $db = Db::getDb();
            //on prepare une requete qui va inserer des données dans la table de liaison peinture/mini
            $insertQuery = $db->prepare('INSERT INTO link_fig2paint (fig_ID , paint_ID) VALUES (:fig_id, :paint_id)');
            //pour chaque peinture selectionnée par son id
            foreach ($this->paints as $paint_id) {
                //on declare et etabli les données
                $pushPaint=[
                    'fig_id'=>$this->ID,
                    'paint_id'=>$paint_id
                ];
                //on execute la requete
                $insertQuery->execute($pushPaint);
            }
        }


    //mise a jour de la mini
    public function update($id) {
        //connexion a la db
        $db = Db::getDb();
        //preparation de la requete qui va mettre a jour les données de la figurine en ciblant son id
        $updateQuery = $db->prepare('UPDATE Fig SET name= :name, picture= :picture, content= :content WHERE id= :id');
        //on etabli les données mais on ne touche pas a son id
        $editFig= [
            'name'=> $this->name,
            'picture'=> $this->picture,
            'content'=> $this->content,
            'id'=> $id
        ];
        //on execute la requete de mise a jour de la mini
        $updateQuery->execute($editFig);
    }


    // MAJ de peinture associé a la mini
    public function editPaints($id, $paintChecker) {
        //connexion ala db
        $db = Db::getDb();
            //on prepare une requete qui va inserer dans la table de liaison les valeurs etablies
            $updateQuery = $db->prepare('INSERT INTO link_fig2paint (fig_ID , paint_ID) VALUES (:fig_id, :paint_id)');
            //pour chaque peinture selectionnée par son id
            foreach ($paintChecker as $paint_id) {
                //on etabli les nouvelles données
                $editPaint=[
                    'fig_id'=>$id,
                    'paint_id'=>$paint_id
                ];
                //on execute la requete
                $updateQuery->execute($editPaint);
            }
    }


     //suppression du lien mini/peinture
    public function deletePaints($id) {
        //connexion a la db
        $db = Db::getDb();
        //on prepare une requete visant a detruire le lien qui unit les peintures a la mini
        //si ce n'est pas fait , la suppression future ne se fera pas a cause des clés etrangeres
        $deleteQuery = $db->prepare('DELETE FROM link_fig2paint WHERE fig_ID = :fig_id');
        //on etabli les donnés
        $deletePaint=[
                'fig_id'=>$id
            ];
        //on execute la requete
        $deleteQuery->execute($deletePaint);
    }


    //supression de la mini
    public function deleteFig($id): void {
        //connexion a la db
        $db = Db::getDb();
        //on prepare la requete de suppression de la mini et de ce qui lui est attribuée
        $deleteQuery = $db->prepare('DELETE FROM Fig WHERE id= :id');
        //on etabli la donnée
        $deleteFig= [
            'id'=> $id
        ];
        //on execute la requete
        $deleteQuery->execute($deleteFig);
    }


    public static function searchAjax($search){
        //on se connecte a la db
        $db = Db::getDb();
        //on prepare une requete qui va comparer le champ a ce qu'il trouve dans la db
        //$gsm mean Get Specific Mini
        $gsm = $db->prepare("SELECT * FROM Fig
                                WHERE name
                                LIKE :find
                                ORDER BY name");
        //on bind les valeur pour eviter une dinguerie
        $gsm->bindValue('find', $search , PDO::PARAM_STR);
        //on execute la requete
        $gsm->execute();
        //on vient recuperer les données des minis
        $Figs = $gsm->fetchAll(PDO::FETCH_ASSOC);
        return $Figs;
    }
}