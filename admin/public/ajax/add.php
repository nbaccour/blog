<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */
session_start();
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
require('../../public/functions/function.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    parse_str(file_get_contents("php://input"), $putVars);


    if ($_POST['action'] === 'addpost') {
        $postManager = new PostManager();
        $addPost = $postManager->addPost($_FILES, $_POST);

        if ($addPost === true) {
            $return['result'] = 'Success';
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }
    if ($_POST['action'] === 'adduser') {

        $userManager = new UserManager();
        $addUser = $userManager->addUser($_POST);

        if ($addUser === true) {
            $return['result'] = 'Success';
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }


}


