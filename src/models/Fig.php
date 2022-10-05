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

    public function __construct() {
        $this->ID = 0;
        $this->paints = [];
    }


    // recuperation de toutes les infos des minis
    //tri des minis pour un affichage par ordre alphabetique
    //permet le tri automatique lors de l'affichage apres création des minis
    public static function getFigs () {
        $db = Db::getDb();

        $query=$db->prepare("SELECT * FROM Fig ORDER BY name");
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());
        return $query->fetchAll();
    }

    //recuperation des infos d'une mini specifique
    public static function getFig($ID){
        $db = Db::getDb();
        $query=$db->prepare("SELECT * FROM Fig WHERE id= :id");

        $params= ['id'=> $ID];
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());

        return $query->fetchAll();
    }
    //recuperation des couyleurs affectées a la figurine via son ID
     public static function getColorByFig($ID){
        $db = Db::getDb();
        $query=$db->prepare("SELECT paint_ID FROM link_fig2paint WHERE fig_ID= :id");

        $params= ['id'=> $ID];
        $query->execute($params);
        
        return $query->fetchAll();
    }

    //recuperation du lien figurine / peinture
    public static function getFigPaints($ID) {
        $db = Db::getDb();

        $query=$db->prepare("SELECT Paint.* FROM Paint, link_fig2paint
                WHERE Paint.ID = link_fig2paint.paint_ID AND link_fig2paint.fig_ID = :id");
        $params= ['id'=> $ID];
        $query->execute($params);

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Paint");
        return $query->fetchAll();
    }

    // creation d'une nouvelle Fig via le formulaire de crea (vues/form-fig.php)
        public function save(): int {
            $db = Db::getDb();
            $insertQuery = $db->prepare('INSERT INTO Fig (name , picture , content) VALUES (:name, :picture, :content)');


            $pushFig= [
                'name'=> $this->name,
                'picture'=> $this->picture,
                'content'=> $this->content
            ];

            $insertQuery->execute($pushFig);


            // Last insert ID
            $this->ID = $db->lastInsertId();
            return $this->ID;
        }
    //sauvegarde du lien mini/peinture
        public function savePaints(): void {
            $db = Db::getDb();

            $insertQuery = $db->prepare('INSERT INTO link_fig2paint (fig_ID , paint_ID) VALUES (:fig_id, :paint_id)');
            foreach ($this->paints as $paint_id) {
                $pushPaint=[
                    'fig_id'=>$this->ID,
                    'paint_id'=>$paint_id
                ];

                $insertQuery->execute($pushPaint);
            }
        }

    //mise a jour de la mini
    public function update($id) {
        $db = Db::getDb();

        $updateQuery = $db->prepare('UPDATE Fig SET name= :name, picture= :picture, content= :content WHERE id= :id');

        $editFig= [
            'name'=> $this->name,
            'picture'=> $this->picture,
            'content'=> $this->content,
            'id'=> $id
        ];

        $updateQuery->execute($editFig);
    }

    //suppression du lien mini/peinture
    public function deletePaints($id) {
        $db = Db::getDb();

        $deleteQuery = $db->prepare('DELETE FROM link_fig2paint WHERE fig_ID = :fig_id');
        $deletePaint=[
                'fig_id'=>$id
            ];
        $deleteQuery->execute($deletePaint);
    }

    // MAJ de peinture associé a la mini
    public function editPaints($id, $paintChecker) {
        $db = Db::getDb();

            $updateQuery = $db->prepare('INSERT INTO link_fig2paint (fig_ID , paint_ID) VALUES (:fig_id, :paint_id)');
            foreach ($paintChecker as $paint_id) {
                $editPaint=[
                    'fig_id'=>$id,
                    'paint_id'=>$paint_id
                ];

                $updateQuery->execute($editPaint);
            }

    }

    //supression de la mini
    public function deleteFig($id): void {
        $db = Db::getDb();

        $deleteQuery = $db->prepare('DELETE FROM Fig WHERE id= :id');

        $deleteFig= [
            'id'=> $id
        ];

        $deleteQuery->execute($deleteFig);
    }


}





