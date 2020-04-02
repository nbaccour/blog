<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:01
 */


function connect()
{
    require('view/frontend/connect.php');
}


function verifConnectUser()
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        $manager = new UserManager();
        $datas = $manager->checkUser($login, $password);
        $_SESSION['id'] = $datas['id'];
        $_SESSION['login'] = $datas['login'];
        $_SESSION['role'] = $datas['role'];
        header("Refresh: 2; URL=index.php");
        echo '<br /><center>Bienvenue ' . $_SESSION['login'] . '</center>';
        exit;
    } else {
        header("Refresh: 2; URL=index.php?action=connect");
        echo('<center>Veuillez renseignez tous les champs du formulaire !</center>');
        exit;
    }
}

function getListPost()
{

    $manager = new PostManager();
    $posts = $manager->getListPost();
    require('view/frontend/listPostView.php');
}

function getPost($idPost)
{
    $postManager = new Postmanager();
//    $commentManager = new CommentManager();

    $post = $postManager->getPost($idPost);
//    $comment = $commentManager->getListComment();

    $loader = new Twig_Loader_Filesystem('view/frontend'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, [
        'cache' => false,
    ]);

    $content = $twig->render('postView.twig', [
        'postTitle'   => $post->title(),
        'postContent' => $post->content(),
    ]);

    $titlePage = 'Page Article : ' . $post->title();

    require('view/frontend/template.php');
}