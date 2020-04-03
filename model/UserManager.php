<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

//class UserManager extends DataBase
class UserManager
{

    protected function dbconnect()
    {
//        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
//        return $db;

        try {
            if (strpos($_SERVER['REQUEST_URI'], 'blog-02') !== false) {//DEV
                $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            } else {
                $db = new PDO('mysql:host=db5000322164.hosting-data.io;dbname=dbs314235;charset=utf8',
                    'dbu413698',
                    '!ProjetBlogOC01!');

            }
            return $db;


        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function checkUser($login, $password)
    {
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
        $req->bindValue(':login', htmlspecialchars($login));
        $req->bindValue(':password', md5($password));
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            echo('Nom utilisateur ou mot de passe invalide');
        }

    }
}