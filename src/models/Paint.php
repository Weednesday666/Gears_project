<?php

//decalaration de la class paint
class Paint {
    public int $ID;
    public string $color_name;
    public string $color_picture;

    //recuperation de toute les infos de la peinture
    public static function getPaints() {
        $db = Db::getDb();

        $query=$db->prepare("SELECT * FROM Paint");
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,get_class());
        return $query->fetchAll();
    }



}