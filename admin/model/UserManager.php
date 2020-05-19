<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */


class UserManager extends DataBase
{


    /**
     * @return array
     * @throws Exception
     */
    function getListUser()
    {
        $db = $this->dbconnect();
        $aDataUser = [];


        try {
            $req = $db->prepare('SELECT * FROM users ORDER BY id DESC');

            $req->execute();

            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                $oUser = new User();
                $oUser->setAttribute($data);
                array_push($aDataUser, $oUser);
            }
            return $aDataUser;


        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    function getUser(int $id)
    {
        $db = $this->dbconnect();

        try {
            $req = $db->prepare('select * from users WHERE id = :id');
            $req->bindValue(':id', $id);
            $req->execute();

            $data = $req->fetch(PDO::FETCH_ASSOC);

            $user = new User();
            $user->setAttribute($data);

            return $user;

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param array $POST
     * @return bool
     * @throws Exception
     */
    function addUser(array $POST)
    {
        $db = $this->dbconnect();

        $user = new User();
        $user->setAttribute($POST);

        $lastname = $user->lastname();
        $firstname = $user->firstname();
        $email = $user->email();
        $role = $user->role();
        $login = $user->login();
        $password = md5($user->password());

        $createDate = date('Y-m-d H:i:s');

        try {
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

            throw new Exception($e->getMessage());
        }

    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    function deleteUser(int $id)
    {

        $db = $this->dbconnect();
        try {
            $req = $db->prepare('DELETE FROM users WHERE id= :id');
            $req->bindValue(':id', $id);
            return $req->execute();

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param array $PUT
     * @return bool
     * @throws Exception
     */
    function updateUser(array $PUT)
    {
        $db = $this->dbconnect();

        try {
            $user = new User();
            $user->setAttribute($PUT);

            $modifDate = date('Y-m-d H:i:s');


            if (intval($user->id()) !== '') {
                $req = $db->prepare('UPDATE users SET  lastname = :lastname, firstname = :firstname,email = :email,role = :role,login = :login, modifDate = :modifDate WHERE id = :id');

                $req->bindValue(':id', intval($user->id()));
                $req->bindValue(':lastname', $user->lastname());
                $req->bindValue(':firstname', $user->firstname());
                $req->bindValue(':email', $user->email());
                $req->bindValue(':role', $user->role());
                $req->bindValue(':login', $user->login());
                $req->bindValue(':modifDate', $modifDate);

                return $req->execute();


            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * @return mixed|string
     * @throws Exception
     */
    public function checkUser()
    {

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
            return 'Identifiant ou mot de passe invalide';
        }

    }
}