<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */

//namespace admin\controller;

//use \admin\model\PostManager;


class FrontendController extends DefaultController
{

    function connectOut()
    {
        session_unset();
        session_destroy();
        header("Refresh: 1; URL=index.php");

        exit;
    }

    function checkUser()
    {
        $manager = new UserManager();
        $checkConnect = $manager->checkUser();

        if (is_array($checkConnect)) {

            $aConnectagent = ['Administrator', 'Moderator'];

            if (in_array($checkConnect['role'], $aConnectagent) === true) {

                $_SESSION['login'] = true;
                $_SESSION['ident'] = $checkConnect['login'];
                $_SESSION['lastnameUser'] = $checkConnect['lastname'];
                $_SESSION['firstnameUser'] = $checkConnect['firstname'];
                $_SESSION['mailUser'] = $checkConnect['email'];

                header("Refresh: 1; URL=index.php");

                $manager = new PostManager();
                $posts = $manager->getListPost();

                $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts]);

                return $content;
            } else {
                $content = $this->_twig->render('formConnect.html.twig', [
                    'title' => 'Admin',
                    'error' => 'Identifiant ou mot de passe invalide',
                ]);

                return $content;
            }

        } else {
            $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin', 'error' => $checkConnect]);

            return $content;
        }

    }

    function getFormConnect()
    {
        $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin']);
        return $content;
    }

    function getFormPost()
    {
        $manager = new CategoryManager();
        $aCategory = $manager->getCategory();
        $content = $this->_twig->render('formPost.html.twig',
            ['title' => 'Ajouter un article', 'categoryList' => $aCategory]);
        return $content;
    }

    function getListPost()
    {

        $manager = new PostManager();
        $posts = $manager->getListPost();
//        $aPosts = json_decode(json_encode($posts), true);
//        foreach ($posts as $key => $post) {
////            if ($key === 'createDate') {
//                $posts[$key]['_createDate'] = date_format($post['_createDate'], 'd/m/Y');
////            }
//
//        }
        $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts, 'login' => $_SESSION['login']]);
        return $content;

    }

    /**
     * @param $idPost
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function getPost($idPost)
    {

//    $commentManager = new CommentManager();
//    $comment = $commentManager->getListComment();

        $postManager = new Postmanager();
        $post = $postManager->getPost($idPost);
//        var_dump($post);
        $content = $this->_twig->render('post.html.twig', [
            'postTitle'   => $post->title(),
            'postContent' => $post->content(),
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


    function addPost()
    {
        $manager = new Postmanager();
        $addpost = $manager->addPost();

//        $content = $this->_twig->render('formPost.html.twig', ['title' => 'Ajouter un article']);
        $content = $this->_twig->render('formPost.html.twig', $addpost);
        return $content;

//        $content = $this->_twig->render('returnMessage.html.twig', [
//            'Message' => $addpost,
//        ]);
//        return $content;
    }

    function deletePost($id)
    {
        $manager = new Postmanager();
        $deletePost = $manager->deletePost($id);
        $content = $this->_twig->render('returnMessage.html.twig', [
            'Message' => $deletePost,
        ]);
        header("Refresh: 1; URL=index.php");
        return $content;

    }
}