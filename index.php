<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App;


use App\controller\FrontendController;

//use App\controller\DefaultController;
//use App\model\Post;
//use App\model\PostManager;
//use App\model\DataBase;


define('DS', DIRECTORY_SEPARATOR); // meilleur portabilité sur les différents systeme.
define('ROOT', dirname(__FILE__) . DS); // pour se simplifier la vie
session_start();

include_once('connect/DataBase.php');

require_once'app/Autoloader.php';
Autoloader::register();



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


require('vendor/autoload.php');
require('public/functions/function.php');


$frontendController = new FrontendController();


$request_method = $_SERVER["REQUEST_METHOD"];
//print_r($request_method);

//$category = $frontendController->getCategory();
//echo $category;

switch ($request_method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'post') {
            if (!empty($_GET["id"])) {
                // Récupérer un seul article
                $contentPost = $frontendController->getPost($_GET['id']);
                echo $contentPost;
                exit();
            }
        }
        if (isset($_GET['action']) && $_GET['action'] === 'connectout') {

            // Deconnexion
            $connectOut = $frontendController->connectOut();
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

        } else {
            // Récupérer tous les articles
            $contentListPost = $frontendController->getListPost();
            echo $contentListPost;
            exit();
        }
        break;
//    case 'POST':
//        // Ajouter un article
//        AddPost();
//        break;
//    case 'PUT':
//        // Modifier un article
//        $id = intval($_GET["id"]);
//        updatePost($id);
//        break;
//    case 'DELETE':
//        // Supprimer un article
//        $id = intval($_GET["id"]);
//        deletePost($id);
//        break;
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


