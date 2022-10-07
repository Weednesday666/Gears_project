<?php
//declaration de la classe signup quii herite de db
class Signup extends Db {

    //methode de creation de compte
    protected function setUser($username,$pwd, $email){
        //on prepare une requete pour inserer dans la table user les données necessaires
        $stmt = $this->connect()->prepare('INSERT INTO user (username , password , email) VALUES (?,?,?);');
        //on hash le password , il ne faut jamais laisser de password en clair , ni dans le code , ni ailleurs
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        //si la requete ne rempli pas les condition demandée, elle devient null et rien ne se crée dans la db
        //cela affichera un message d'erreur grace au controller
        if(!$stmt->execute(array($username,$hashedPwd, $email))){
            $stmt = null;
            exit();
        }
        $stmt = null;

    }
    //methode de verification de doublon dans la db (utilisée dans le usernameTakenCheck)
    protected function checkUser($username, $email){
        //on prepate une requeite qui selectionne les données dans la table user
        $stmt = $this->connect()->prepare('SELECT username FROM user WHERE username = ? OR email = ?;');
        //si elle sont presente , la requete ne passe pas ( un message d'erreur sera afficher par le controller)
        if(!$stmt->execute(array($username, $email))){
            $stmt = null;
            exit();
        }
        //verification du retour de données
        $resultCheck;
        //on verifie que le retour de resultat soit plus grand que 0 CAD qu'un utilisateur existe
        if($stmt->rowCount() > 0) {
            //si il existe , il renvoi false
            $resultCheck = false;
            //sinon
        }else{
            //il renvoi true
            $resultCheck = true;
        }
        //on retourne le resultat
        return $resultCheck;
    }
}