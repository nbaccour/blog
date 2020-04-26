<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */
session_start();
include_once('../../connect/DataBase.php');
include_once('../../app/model/UserManager.php');

require('../../vendor/autoload.php');
require('../../public/functions/function.php');


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
//    parse_str(file_get_contents("php://input"), $putVars);
//
//    if (isset($putVars['updateuser'])) {
//        $userManager = new UserManager();
//        $updateUser = $userManager->updateUser($putVars);
//
//        if ($updateUser === true) {
//            $return['result'] = 'Success';
//            jsonGenerate($return);
//        } else {
//            $return['result'] = 'Failed';
//            jsonGenerate($return);
//        }
//    }
//    if (isset($putVars['updatepost'])) {
//
//        $postManager = new PostManager();
//        $updatePost = $postManager->updatePost($putVars);
//
//        if ($updatePost === true) {
//            $return['result'] = 'Success';
//            jsonGenerate($return);
//        } else {
//            $return['result'] = 'Failed';
//            jsonGenerate($return);
//        }
//
//    }


}

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
//    $postManager = new PostManager();
//    $updateImgPost = $postManager->updateImgPost($_FILES, $_POST['id']);
//
//
//    if ($updateImgPost === true) {
//        $return['result'] = 'Success';
//        $return['filename'] = $_FILES['file']['name'];
//
//        jsonGenerate($return);
//    } else {
//        $return['result'] = 'Failed';
//        jsonGenerate($return);
//    }
//
//}

