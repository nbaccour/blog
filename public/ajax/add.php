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
include_once('../../app/model/MessageManager.php');
include_once('../../app/model/Message.php');

require('../../vendor/autoload.php');
require('../../public/functions/function.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'contactadmin') {

        $addMessage = false;
        if ($_POST['content'] !== '' && $_POST['email'] !== '') {
            $messageManager = new App\model\MessageManager();
            $addMessage = $messageManager->addMessage($_POST);
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
            $commentManager = new App\model\CommentManager();
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

        $userManager = new App\model\UserManager();
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

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
//    $postManager = new PostManager();
//    $updateImgPost = $postManager->updateImgPost($_FILES, $_POST['id']);
//
//
//    if ($updateImgPost === true) {
//        header('Location: ' . $_SERVER['REQUEST_URI']);
////        location . reload();
//        $return['result'] = 'Success';
//        jsonGenerate($return);
//    } else {
//        $return['result'] = 'Failed';
//        jsonGenerate($return);
//    }
//
////    $return['result'] = 'Success';
////    jsonGenerate($return);
//}

