<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */


include_once('../../connect/DataBase.php');
include_once('../../app/model/UserManager.php');

require('../../vendor/autoload.php');
require('../../public/functions/function.php');


if (isset($_POST['login']) && isset($_POST['password'])) {

    $user = new App\model\UserManager();
    $averifConnect = $user->checkUser();

    if (isset($averifConnect['login']) === true && $_POST['login'] == $averifConnect['login']) { // Si les infos correspondent...
        session_start();
        $_SESSION['firstname'] = $averifConnect['firstname'];
        $_SESSION['iduser'] = $averifConnect['id'];

        $return['result'] = 'Success';
        jsonGenerate($return);
    } else { // Sinon

        $return['result'] = 'Failed';
        $return['error'] = $averifConnect['error'];
        jsonGenerate($return);
    }
}