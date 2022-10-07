<?php
//declaration de la class login qui herite de la class db
class Login extends Db {

    //recuperation des infos de l'utilisateur
    public function getUser($username, $pwd){
        //on prepare une requete qui va selectionner tout de la table user ou il existe un champ username ou un champ mail
        $stmt = $this->connect()->prepare('SELECT * FROM user WHERE username = ? OR email = ?;');
        //on execute la requete
        $stmt->execute(array($username , $username));
        //on va chercher dans la db les données necessaire
        $result= $stmt->fetch(PDO::FETCH_ASSOC);

        //si les données sont correctes alors
        if($result !== false && password_verify($pwd, $result['password'])) {
            //on crée une session lié a l'utilisateur
            $_SESSION['user'] = [
                'id'=> $result['id'],
                'username'=> $result['username'],
                'email'=> $result['email']
            ];
            //on renvoi l'utilisateur sur la page d'acceuil
            header('location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index');
            exit();
                //sinon
            }else{
            //on lui envoi un message d'erreur sans preciser quelle donnée est incorrecte
            echo "username or password invalid";
            exit();
        }
    }
}

