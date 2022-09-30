<?php

class Signup extends Db {


    protected function setUser($username,$pwd, $email){
        $stmt = $this->connect()->prepare('INSERT INTO user (username , password , email) VALUES (?,?,?);');



        if(!$stmt->execute(array($username, $email))){
            $stmt = null;
            header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=stmtfailed");
            exit();

        }

        $resultCheck;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else{
            $resultCheck = true;
        }
        return $resultCheck;

    }

    protected function checkUser($username, $email){
        $stmt = $this->connect()->prepare('SELECT username FROM user WHERE username = ? OR email = ?;');

        if(!$stmt->execute(array($username, $email))){
            $stmt = null;
            header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=stmtfailed");
            exit();

        }

        $resultCheck;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else{
            $resultCheck = true;
        }
        return $resultCheck;

    }

}