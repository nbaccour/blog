<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */

spl_autoload_register(function ($className) {
    $extensions = [".php"];
    $folders = ['', '../../model'];

    foreach ($folders as $folder) {
        foreach ($extensions as $extension) {
            if ($folder == '') {
                $path = $folder . $className . $extension;
            } else {
                $path = $folder . DIRECTORY_SEPARATOR . $className . $extension;
            }

            if (is_readable($path)) {
                include_once($path);
            }
        }
    }
});

require('../../vendor/autoload.php');
require('../../controller/function.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    parse_str(file_get_contents("php://input"), $putVars);

    $postManager = new PostManager();
    $addPost = $postManager->addPost($_FILES, $_POST);

    if ($addPost === true) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
        $return['result'] = 'Success';
        jsonGenerate($return);
    } else {
        $return['result'] = 'Failed';
        jsonGenerate($return);
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
