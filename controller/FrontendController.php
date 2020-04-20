<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */

class FrontendController extends DefaultController
{


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

        $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts]);
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

        $postManager = new PostManager();
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