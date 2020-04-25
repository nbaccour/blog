<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;

use App\model\PostManager;
use App\model\CommentManager;

//namespace App\Blog\Controllers;

//use controller;


class FrontendController extends DefaultController
{

    function connectOut()
    {
        session_unset();
        session_destroy();
        header("Refresh: 1; URL=index.php");

        exit;
    }

    function getCategory()
    {

        $categoryManager = new CategoryManager();
        $gategory = $categoryManager->getCategory();


        $content = $this->_twig->render('base.html.twig', ['navCategory' => $gategory]);
        return $content;

    }

    function getListPost()
    {

        $manager = new PostManager();
        $posts = $manager->getListPost();

        foreach ($posts as $key => $aData) {
            foreach ($aData as $nameColumn => $value) {
                if ($nameColumn === 'createDate') {
                    $posts[$key]['createDate'] = date('d/m/Y', strtotime($value));
                }
            }

        }
//        $content = $this->_twig->render('base.html.twig', ['posts' => $posts]);
//        return $content;

        $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts]);
        return $content;

    }
    //-------------------------------------------------------------------------------------------------------------
    //----------------------------------------     USER -----------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------------
    function getFormUser($id)
    {

        $aDataUser = [];
        $fileName = 'formAddUser.html.twig';
        if ($id !== '') {
            $userManager = new UserManager();
            $user = $userManager->getUser($id);


            $aDataUser = [
                'id'        => $user->id(),
                'lastname'  => $user->lastname(),
                'firstname' => $user->firstname(),
                'email'     => $user->email(),
                'role'      => $user->role(),
                'roleShow'  => ($user->role() === 'user') ? 'Membre' : 'Administrateur',
                'login'     => $user->login(),
                'password'  => $user->password(),
                'title'     => "Modifier les données du membre",
            ];
            $fileName = 'formUpdateUser.html.twig';
        }


        $content = $this->_twig->render($fileName, array_merge([
                'title' => 'Créer un compte',
            ], $aDataUser)
        );
        return $content;
    }

//    function checkUser()
//    {
//        $manager = new UserManager();
//        $checkConnect = $manager->checkUser();
//
//        if (is_array($checkConnect) && isset($checkConnect['error']) === false) {
//
//            $aConnectagent = ['Administrator', 'Moderator', 'user'];
//
//            if (in_array($checkConnect['role'], $aConnectagent) === true) {
//
//                $_SESSION['login'] = true;
//                $_SESSION['ident'] = $checkConnect['login'];
//                $_SESSION['lastnameUser'] = $checkConnect['lastname'];
//                $_SESSION['firstnameUser'] = $checkConnect['firstname'];
//                $_SESSION['mailUser'] = $checkConnect['email'];
//
////                header("Refresh: 1; URL=index.php");
//
////                $manager = new PostManager();
////                $posts = $manager->getListPost();
////
////                $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts]);
////
////                return $content;
//            } else {
////                $content = $this->_twig->render('formConnect.html.twig', [
////                    'title' => 'Admin',
////                    'error' => 'Identifiant ou mot de passe invalide',
////                ]);
//
////                return $content;
//            }
//
//        } else {
////            $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin', 'error' => $checkConnect]);
////
////            return $content;
//        }
//
//    }

    function getFormConnect()
    {
        $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin']);
        return $content;
    }


    /**
     * @param $id
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function getPost($id)
    {

        $commentManager = new CommentManager();
        $aComments = $commentManager->getlist($id);

        $aListCommentParent = [];
        foreach ($aComments as $aData) {
            if ($aData['parentid'] === '0') {
                $aListCommentParent[$aData['id']] = $aData;
            }

        }
        foreach ($aComments as $aData) {
            if ($aData['parentid'] !== '0') {
                foreach ($aListCommentParent as $idcomment => $aCommentData) {
                    if ((int)$aData['parentid'] === $idcomment) {
                        $aListCommentParent[$idcomment]['commentsChild'][] = $aData;
                    }
                }
            }

        }
        $aListCommentParentChild = array_values($aListCommentParent);

        $postManager = new PostManager();
        $post = $postManager->getPost($id);
//        var_dump($post);
        $content = $this->_twig->render('post.html.twig', [
            'title'         => $post['title'],
            'content'       => $post['content'],
            'category'      => $post['name'],
            'author'        => $post['author'],
            'postimg'       => $post['postimg'],
            'createDate'    => date('d/m/Y', strtotime($post['createDate'])),
            'comments'      => $aListCommentParentChild,
            'countcomments' => count($aComments),
//            'postContent' => $post->content(),
        ]);

        return $content;

    }


    function getProject($idProject)
    {


        switch ($idProject) {
            case 1:
                $title = 'Festival des films';
                $content = 'Projeter des films d\'auteur en plein air du 5 au 8 août au parc Monceau à Paris.';
                $comment = 'commentprojet1.jpg';
                $mentor = 'Gaetan De Smet';
                $evaluator = 'Soma-Giuseppe Bini';
                $validDate = 'Projet validé le mercredi 22 janvier 2020';
                break;
            case 2:
                $title = 'Application de restauration en ligne';
                $content = 'Livrer des plats de qualité à domicile en moins de 20 minutes...';
                $comment = 'commentprojet2.jpg';
                $mentor = 'Gaetan De Smet';
                $evaluator = 'Wenceslas Baridon';
                $validDate = 'Projet validé le samedi 14 mars 2020';
                break;
            case 3:
                $title = 'Créez mon premier blog en PHP';
                $content = 'Développer mon blog professionnel sans Framework';
                $comment = '';
                $mentor = 'Gaetan De Smet';
                $evaluator = '';
                $validDate = 'En cours';
                break;
            default:
                $title = '';
                $content = '';
                $comment = '';
                $mentor = '';
                $evaluator = '';
                $validDate = '';
        }
        $content = $this->_twig->render('project.html.twig', [
            'projectTitle'     => $title,
            'projectContent'   => $content,
            'projectComment'   => $comment,
            'projectMentor'    => $mentor,
            'projectEvaluator' => $evaluator,
            'projectValidDat'  => $validDate,
        ]);

        return $content;
    }

//
//    function login()
//    {
//
//        $content = $this->_twig->render('topBar.html.twig', [
//            'login' => $_SESSION['login'],
//        ]);
//
//        return $content;
//    }
//
//
//    function getPage()
//    {
////        $content = $this->_twig->render('base.html.twig', ['urlPage' => $_SERVER['QUERY_STRING']]);
////        $content = $_SERVER['QUERY_STRING'];
//        $content = $this->_twig->render('base.html.twig', ['urlPage' => $_SERVER['QUERY_STRING']]);
//        return $content;
//    }
//
//
//    function getListPostTest()
//    {
//
//        $manager = new PostManager();
//        $posts = $manager->getListPost();
//
//        header('Content-Type: application/json');
//
//        echo json_encode($posts, JSON_PRETTY_PRINT);
////        return $posts;
//
//    }
}