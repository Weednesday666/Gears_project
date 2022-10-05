<?php

class Login extends Db {


    public function getUser($username, $pwd){
        $stmt = $this->connect()->prepare('SELECT * FROM user WHERE username = ? OR email = ?;');
        $stmt->execute(array($username , $username));
        $result= $stmt->fetch(PDO::FETCH_ASSOC);


        if($result !== false && password_verify($pwd, $result['password'])) {

            $_SESSION['user'] = [
                'id'=> $result['id'],
                'username'=> $result['username'],
                'email'=> $result['email']];
                header('location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index');
                exit();

            }else{
                echo "username or password invalid";
                //header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=stmtfailed");
                exit();

            }
    }
}

