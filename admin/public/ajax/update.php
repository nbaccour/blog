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

if (isset($_POST['action']) === true && $_POST['action'] === 'updatePost') {
    $postManager = new Postmanager();
    $updatePost = $postManager->updatePost($_POST);

//    if ($updatePost === true) {
//        $return['result'] = 'Success';
//        jsonGenerate($return);
//    } else {
//        $return['result'] = 'Failed';
//        jsonGenerate($return);
//    }
}

