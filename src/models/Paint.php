<?php

//decalaration de la class paint
class Paint {
    public int $ID;
    public string $color_name;
    public string $color_picture;

    //recuperation de toute les infos de la peinture
    public static function getPaints() {
        //connexion a la db
        $db = Db::getDb();
        //preparation d'une requete qui va selectionner toutes les données de la table paint
        $query=$db->prepare("SELECT * FROM Paint");
        // execution de la requete
        $query->execute();
        //recupertion des données dans la db
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());
        //on retourne le resultat
        return $query->fetchAll();
    }



}