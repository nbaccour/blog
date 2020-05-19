<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */

include_once('../../connect/DataBase.php');
include_once('../../app/model/UserManager.php');
include_once('../../app/model/User.php');
include_once('../../app/model/CommentManager.php');
include_once('../../app/model/Comment.php');
include_once('../../app/model/ContactManager.php');
include_once('../../app/model/Contact.php');

require('../../vendor/autoload.php');
require('../../public/functions/function.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'contactadmin') {

        $addMessage = false;
        if ($_POST['content'] !== '' && $_POST['email'] !== '') {
            $messageManager = new ContactManager();
            $addMessage = $messageManager->sendMessage($_POST);
        }


        if ($addMessage === true) {
            $return['result'] = 'Success';
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }

    if ($_POST['action'] === 'addcomment') {


        $_POST['postid'] = (int)$_POST['postid'];
        $_POST['parentid'] = (int)$_POST['parentid'];
        $_POST['author'] = (int)$_POST['author'];

        $addComment = false;
        if ($_POST['comment'] !== '') {
            $commentManager = new CommentManager();
            $addComment = $commentManager->addComment($_POST);
        }


        if ($addComment === true) {
            $return['parentid'] = (int)$_POST['parentid'];
            $return['result'] = 'Success';
            jsonGenerate($return);
        } else {
            $return['parentid'] = (int)$_POST['parentid'];
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }
    if ($_POST['action'] === 'adduser' && $_POST['email'] !== '') {

        $userManager = new UserManager();
        $addUser = $userManager->addUser($_POST);

        if ($addUser === true) {
            session_start();
            $_SESSION['firstname'] = $_POST['firstname'];
            $return['result'] = 'Success';
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }


}


