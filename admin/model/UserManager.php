<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

//namespace admin\model;

class UserManager extends DataBase
//class UserManager
{


    public function checkUser()
    {

//        var_dump($_POST["title"]);
        $login = $_POST["login"];
        $password = $_POST["password"];


        $db = $this->dbconnect();

        $req = $db->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
        $req->bindValue(':login', htmlspecialchars($login));
        $req->bindValue(':password', md5($password));
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
//            echo('Nom utilisateur ou mot de passe invalide');
            return 'Identifiant ou mot de passe invalide';
        }

    }
}