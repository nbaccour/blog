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


if ($isConnect === false) {
    if (isset($_GET['action']) && $_GET['action'] === 'connectAdmin') {

        $checkUser = $frontendController->checkUser();
        print_r($checkUser);
        exit();
    } else {
        $contentFormConnect = $frontendController->getFormConnect();
        echo $contentFormConnect;
        exit();
    }

} else {
    try {
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

                } elseif (isset($_GET['action']) && $_GET['action'] === 'posts') {
                    $contentListPost = $frontendController->getListPost();
                    echo $contentListPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'formuser') {

                    // Formulaire ajouter un membre
                    $id = (isset($_GET['id']) === true) ? $_GET['id'] : '';
                    $contentFormPost = $frontendController->getFormUser($id);
                    echo $contentFormPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'users') {
                    $contentListUser = $frontendController->getListUser();
                    echo $contentListUser;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'formcomment') {

                    // Formulaire mettre à jour un commentaire
                    $id = (isset($_GET['id']) === true) ? $_GET['id'] : '';
                    $contentFormComment = $frontendController->getFormComment($id, $_GET['mode']);
                    echo $contentFormComment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'comment') {
                    $contentListomment = $frontendController->getListAllComment();
                    echo $contentListomment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'statutcomment') {
                    $contentListomment = $frontendController->getListAllComment(['mode' => 'statut']);
                    echo $contentListomment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'validcomment') {
                    $contentListomment = $frontendController->getListAllComment(['mode' => 'valid']);
                    echo $contentListomment;
                    exit();

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

