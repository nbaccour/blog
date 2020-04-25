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
require('../../controller-old/function.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $aExplode = explode('&', $_SERVER['QUERY_STRING']);

    if ($aExplode[0] === 'deleteuser') {
        $userManager = new UserManager();
        $deletePost = $userManager->deleteUser($aExplode[1]);
        if ($deletePost === true) {
            $return['result'] = 'Success';
            $return['iduser'] = $aExplode[1];
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }

    if ($aExplode[0] === 'deletepost') {
        $postManager = new PostManager();
        $deletePost = $postManager->deletePost($aExplode[1]);
        if ($deletePost === true) {
            $return['result'] = 'Success';
            $return['idpost'] = $aExplode[1];
            jsonGenerate($return);
        } else {
            $return['result'] = 'Failed';
            jsonGenerate($return);
        }
    }


}

