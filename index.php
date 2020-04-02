<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */


session_start();

spl_autoload_register(function ($className) {
    $extensions = [".php"];
    $folders = ['', 'model', 'controller'];

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

require('vendor/autoload.php');


$frontendController = new FrontendController();


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
        } elseif (isset($_GET['action']) && $_GET['action'] === 'project') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $contentProject = $frontendController->getProject($_GET['id']);
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


//if (isset($_GET['action'])) {
//
//    if ($_GET['action'] == 'connect') {
//        if (!isset($_SESSION['login'])) {
//            connect();
//        }
//    }
//    if ($_GET['action'] == 'verifUser') {
//        verifConnectUser();
//
//    }
//    if ($_GET['action'] == 'project') {
//        if (isset($_GET['id']) && $_GET['id'] > 0) {
//            $contentProject = $frontendController->getProject($_GET['id']);
//            echo $contentProject;
//            exit;
//        }
//    }
//
//    if ($_GET['action'] == 'post') {
//        if (isset($_GET['id']) && $_GET['id'] > 0) {
//            $contentPost = $frontendController->getPost($_GET['id']);
//            echo $contentPost;
//            exit;
//        } else {
//            echo("Erreur, aucun ID de billet envoyé");
//            header("Refresh: 2; URL=index.php");
//        }
//    }
//
//} else {
//    $contentListPost = $frontendController->getListPost();
//    echo $contentListPost;
//    exit();
//}