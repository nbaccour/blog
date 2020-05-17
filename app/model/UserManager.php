<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

namespace App\model;

class UserManager extends DataBase
{

    public function checkUser()
    {


        $db = $this->dbconnect();
        try {
            $req = $db->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
            $req->bindValue(':login', htmlspecialchars($_POST['login']));
            $req->bindValue(':password', md5($_POST['password']));
            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            if ($data) {
                return $data;
            } else {
                return ['error' => 'Nom utilisateur ou mot de passe invalide'];
            }

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }

    function addUser($POST)
    {
        $db = $this->dbconnect();
        try {
            $user = new User();
            $user->setAttribute($POST);

            $lastname = $user->lastname();
            $firstname = $user->firstname();
            $email = $user->email();
            $role = $user->role();
            $login = $user->login();
            $password = md5($user->password());

            $createDate = date('Y-m-d H:i:s');


            $req = $db->prepare('INSERT INTO users(lastname, firstname, email, role, login,password, createDate) VALUE (:lastname,:firstname,:email,:role,:login,:password,:createDate)');

            $req->bindParam(':lastname', $lastname);
            $req->bindParam(':firstname', $firstname);
            $req->bindParam(':email', $email);
            $req->bindParam(':role', $role);
            $req->bindParam(':login', $login);
            $req->bindParam(':password', $password);
            $req->bindParam(':createDate', $createDate);

            return $req->execute();


        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }

    }
}