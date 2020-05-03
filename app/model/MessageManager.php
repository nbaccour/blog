<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

namespace App\model;

class MessageManager extends DataBase
//class UserManager
{


    function addMessage($POST)
    {
        $db = $this->dbconnect();

        $message = new Message();
        $message->setAttribute($POST);

        $lastname = $message->lastname();
        $firstname = $message->firstname();
        $email = $message->email();
        $content = $message->content();

        $createDate = date('Y-m-d H:i:s');


        $req = $db->prepare('INSERT INTO message(lastname, firstname, email, content, createDate) VALUE (:lastname,:firstname,:email,:content,:createDate)')
        or die(print_r($db->errorInfo()));

        $req->bindParam(':lastname', $lastname);
        $req->bindParam(':firstname', $firstname);
        $req->bindParam(':email', $email);
        $req->bindParam(':content', $content);
        $req->bindParam(':createDate', $createDate);


        if ($req->execute()) {
            return true;
        } else {
//                return 'erreur';
            return ['error' => $db->errorInfo()];
        }

        $db->close();
    }
}