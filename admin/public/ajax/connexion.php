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
//    $folders = ['', '../../model', '../../controller'];
//    $folders = ['', 'model', 'admin\controller'];

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

//$frontendController = new FrontendController();


//$contentPost = $frontendController->getPost('4');


$username = "test";
$password = "test";
if (isset($_POST['username']) && isset($_POST['password'])) {

    if ($_POST['username'] == $username && $_POST['password'] == $password) { // Si les infos correspondent...
//        session_start();
//        $_SESSION['user'] = $username;
        $return['result'] = 'Success';
        jsonGenerate($return);
//        echo "Success";
    } else { // Sinon
//        echo "Failed";
        $return['result'] = 'Failed';
        jsonGenerate($return);
    }
}