<?php
session_start();

$request_method = $_SERVER["REQUEST_METHOD"];

spl_autoload_register(function ($className) {
    $extensions = [".php"];
    $folders = ['', 'model', 'controller'];
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

require('vendor/autoload.php');
require('controller/function.php');


$frontendController = new FrontendController();


$isConnect = false;

if (isset($_SESSION['login']) === true) {
    $isConnect = true;
}

//if (isset($_GET['login']) === true) {
////    if ($_GET['login'] === '1') {
////        $isConnect = true;
////    }
////}
//var_dump($isConnect);
if ($isConnect === false) {
//if (isset($_SESSION['login']) === true) {
    if (isset($_GET['action']) && $_GET['action'] === 'connectAdmin') {

        $checkUser = $frontendController->checkUser();
        echo $checkUser;
        exit();
//        checkUser($login, $pwd)
    } else {
        $contentFormConnect = $frontendController->getFormConnect();
        echo $contentFormConnect;
        exit();
    }

} else {
    try {
//print_r($request_method);
        switch ($request_method) {
            case 'GET':
                if (isset($_GET['action']) && $_GET['action'] === 'connectout') {

                    // Deconnexion
                    $connectOut = $frontendController->connectOut();
                    echo $connectOut;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'formpost') {

                    // Formulaire ajouter un article
                    $id = (isset($_GET['id']) === true) ? $_GET['id'] : '';
                    $contentFormPost = $frontendController->getFormPost($id);
                    echo $contentFormPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'post') {
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
            case 'POST':
                if (isset($_GET['action']) && $_GET['action'] === 'addpost') {
                    // Ajouter un article
                    $contentAddPost = $frontendController->addPost();
                    echo $contentAddPost;
                    exit();
                } elseif (isset($_GET['action']) && $_GET['action'] === 'updatepost') {
                    if (!empty($_GET["id"])) {
                        // Récupérer un seul article
                        $contentPost = $frontendController->updatePost($_GET['id']);
                        echo $contentPost;
                        exit();
                    }
                }

                break;
//    case 'PUT':
//        // Modifier un article
//        $id = intval($_GET["id"]);
//        updatePost($id);
//        break;
            case 'DELETE':
                if (isset($_GET['action']) && $_GET['action'] === 'deletepost') {
                    if (!empty($_GET["id"])) {
//                var_dump($_GET);
                        // Supprimer un article
                        $id = intval($_GET["id"]);
                        $contentDeletePost = $frontendController->deletePost($id);
                        echo $contentDeletePost;
                        exit();
                    }

                }
            default:
                // Requête invalide
                header("HTTP/1.0 405 Method Not Allowed");
                break;
        }
    } catch (Exception $e) { // S'il y a eu une erreur, alors...
        echo 'Erreur : ' . $e->getMessage();

//    $errorMessage = $e->getMessage();
//    require('view/errorView.php');
    }
}

