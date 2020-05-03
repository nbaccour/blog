<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App;

use App\controller\FrontendController;


define('DS', DIRECTORY_SEPARATOR); // meilleur portabilité sur les différents systeme.
define('ROOT', dirname(__FILE__) . DS); //
session_start();

include_once('connect/DataBase.php');

require_once 'app/Autoloader.php';
Autoloader::register();


require('vendor/autoload.php');
require('public/functions/function.php');


$frontendController = new FrontendController();

//$menu = $frontendController
$request_method = $_SERVER["REQUEST_METHOD"];
//print_r($request_method);

switch ($request_method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'post') {
            if (!empty($_GET["id"])) {
                // Récupérer un seul article
                $contentPost = $frontendController->getPost($_GET['id']);
                echo $contentPost;
                exit();
            }
        } elseif (isset($_GET['action']) && $_GET['action'] === 'connectout') {

            // Deconnexion
            $connectOut = $frontendController->connectOut();
            echo $connectOut;
            exit();

        } elseif (isset($_GET['action']) && $_GET['action'] === 'about') {

            // about
            $connectOut = $frontendController->getPage('about');
            echo $connectOut;
            exit();

        } elseif (isset($_GET['action']) && $_GET['action'] === 'contact') {

            // about
            $connectOut = $frontendController->getPage('contact');
            echo $connectOut;
            exit();

        } elseif (isset($_GET['action']) && $_GET['action'] === 'project') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $contentProject = $frontendController->getProject($_GET['id']);
                echo $contentProject;
                exit;
            }
        } elseif (isset($_GET['action']) && $_GET['action'] === 'connect') {
            $contentFormConnect = $frontendController->getFormConnect();
            echo $contentFormConnect;
            exit();

        } elseif (isset($_GET['action']) && $_GET['action'] === 'reg') {
            $id = '';
            $contentFormUser = $frontendController->getFormUser($id);
            echo $contentFormUser;
            exit();

        } elseif (isset($_GET['action']) && $_GET['action'] === 'cat') {
            if (isset($_GET['name']) && $_GET['name'] !== '') {
                $contentProject = $frontendController->getListPostByName($_GET['name']);
                echo $contentProject;
                exit;
            }

        } else {
            // Récupérer tous les articles
            $contentListPost = $frontendController->getListPost();
            echo $contentListPost;
            exit();
        }
        break;
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}



//spl_autoload_register(function ($className) {
//    $extensions = [".php"];
////    $folders = ['', 'app/model', 'app/controller'];
//    $folders = ['app/model', 'app/controller'];
//
//    foreach ($folders as $folder) {
//        foreach ($extensions as $extension) {
//            if ($folder == '') {
//                $path = $folder . $className . $extension;
//            } else {
//                $path = $folder . DIRECTORY_SEPARATOR . $className . $extension;
//            }
//            var_dump($path);
//            if (is_readable($path)) {
//                include_once($path);
//            }
//        }
//    }
//});
