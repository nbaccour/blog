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
require('../../controller/function.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $postManager = new PostManager();
    $deletePost = $postManager->deletePost(substr($_SERVER['QUERY_STRING'], 3));
    if ($deletePost === true) {
        $return['result'] = 'Success';
        $return['idpost'] = substr($_SERVER['QUERY_STRING'], 3);
        jsonGenerate($return);
    } else {
        $return['result'] = 'Failed';
        jsonGenerate($return);
    }


}

