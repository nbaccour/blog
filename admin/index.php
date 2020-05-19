<?php


session_start();

$request_method = $_SERVER["REQUEST_METHOD"];


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
require('public/functions/function.php');


$frontendController = new FrontendController();
$userController = new UserController();
$postController = new PostController();
$commentController = new CommentController();

$isConnect = false;

if (isset($_SESSION['login']) === true) {
    $isConnect = true;
}


if ($isConnect === false) {
    if (isset($_GET['action']) && $_GET['action'] === 'connectAdmin') {

        $checkUser = $userController->checkUser();
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
                    $contentFormPost = $postController->getFormPost((int)$id);
                    echo $contentFormPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'posts') {
                    $contentListPost = $postController->getListPost();
                    echo $contentListPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'formuser') {

                    // Formulaire ajouter un membre
                    $id = (isset($_GET['id']) === true) ? $_GET['id'] : '';
                    $contentFormPost = $userController->getFormUser((int)$id);
                    echo $contentFormPost;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'users') {
                    $contentListUser = $userController->getListUser();
                    echo $contentListUser;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'formcomment') {

                    // Formulaire mettre à jour un commentaire
                    $id = (isset($_GET['id']) === true) ? $_GET['id'] : '';
                    $contentFormComment = $commentController->getFormComment($id, $_GET['mode']);
                    echo $contentFormComment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'comment') {
                    $contentListomment = $commentController->getListAllComment();
                    echo $contentListomment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'statutcomment') {
                    $contentListomment = $commentController->getListAllComment(['mode' => 'statut']);
                    echo $contentListomment;
                    exit();

                } elseif (isset($_GET['action']) && $_GET['action'] === 'validcomment') {
                    $contentListomment = $commentController->getListAllComment(['mode' => 'valid']);
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
                    $contentListPost = $postController->getListPost();
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

    }
}

