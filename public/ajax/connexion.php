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



if (isset($_POST['login']) && isset($_POST['password'])) {

    $user = new UserManager();
    $averifConnect = $user->checkUser();

    if (isset($averifConnect['login']) === true && $_POST['login'] == $averifConnect['login']) { // Si les infos correspondent...
        session_start();
        $_SESSION['firstname'] = $averifConnect['firstname'];

        $return['result'] = 'Success';
        jsonGenerate($return);
    } else { // Sinon

        $return['result'] = 'Failed';
        $return['error'] = $averifConnect['error'];
        jsonGenerate($return);
    }
}