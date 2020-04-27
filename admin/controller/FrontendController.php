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
                'title' => 'Ajouter un utilisateur',
            ], $aDataUser)
        );
        return $content;
    }

    function getListUser()
    {

        $manager = new UserManager();
        $users = $manager->getListUser();

        foreach ($users as $key => $aData) {
            foreach ($aData as $nameColumn => $value) {
                if ($nameColumn === 'createDate') {
                    $users[$key]['createDate'] = date('d/m/Y', strtotime($value));
                }
                if ($nameColumn === 'role') {
                    $roleShow = ($value === 'user') ? 'Membre' : 'Administrateur';
                    $users[$key]['roleShow'] = $roleShow;
                }
            }

        }


        $content = $this->_twig->render('listUser.html.twig', ['users' => $users, 'login' => $_SESSION['login']]);
        return $content;

    }
    //-------------------------------------------------------------------------------------------------------------
    //----------------------------------------     Comment -----------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------------
    function getListAllComment(array $aOptions = [])
    {

        $manager = new CommentManager();
        $comments = $manager->getListAllComment($aOptions);

        foreach ($comments as $key => $aData) {
            foreach ($aData as $nameColumn => $value) {
                if ($nameColumn === 'createDate') {
                    $comments[$key]['createDate'] = date('d/m/Y', strtotime($value));
                }

            }

        }


        $content = $this->_twig->render('listAllComment.html.twig',
            ['comments' => $comments, 'login' => $_SESSION['login']]);
        return $content;

    }

    function getFormComment($id)
    {


        $commentManager = new CommentManager();
        $comment = $commentManager->getComment($id);

//$test = '';
        $aDataComment = [
            'id'           => $comment['id'],
            'titleComment' => $comment['title'],
            'firstname'    => $comment['firstname'],
            'comment'      => $comment['comment'],
            'author'       => $comment['author'],
//            'createDate' => $comment['createDate'],
            'title'        => "Valider le commentaire",
        ];
        $fileName = 'formUpdateComment.html.twig';


        $content = $this->_twig->render($fileName, $aDataComment);
        return $content;
    }
    //-------------------------------------------------------------------------------------------------------------
    //----------------------------------------     POST -----------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------------
    function getFormPost($id)
    {
        $manager = new CategoryManager();
        $aCategory = $manager->getCategory();
        $aDataPost = [];
        $fileName = 'formAddPost.html.twig';
        if ($id !== '') {
            $postManager = new PostManager();
            $post = $postManager->getPost($id);


            $aDataCategory = $manager->getCategoryData($post->idcategory());

            $aDataPost = [
                'postId'       => $post->id(),
                'postTitle'    => $post->title(),
                'postContent'  => $post->content(),
                'idcategory'   => $post->idcategory(),
                'postImg'      => $post->postImg(),
                'namecategory' => $aDataCategory->name(),
                'title'        => "Modifier l'article",
            ];
            $fileName = 'formPost.html.twig';
        }


        $content = $this->_twig->render($fileName, array_merge([
                'title'        => 'Ajouter un article',
                'categoryList' => $aCategory,
            ], $aDataPost)
        );
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
//    function getPost($idPost)
//    {
//
////    $commentManager = new CommentManager();
////    $comment = $commentManager->getListComment();
//
//        $postManager = new PostManager();
//        $post = $postManager->getPost($idPost);
////        var_dump($post);
//        $content = $this->_twig->render('post.html.twig', [
//            'postTitle'   => $post->title(),
//            'postContent' => $post->content(),
//        ]);
//
//        return $content;
//
//    }

    function updatePost($id)
    {

        $postManager = new PostManager();
        $postUpdate = $postManager->updatePost($id);


        $manager = new CategoryManager();
        $aCategory = $manager->getCategory();
        $aDataPost = [];
        if ($id !== '') {
            $postManager = new PostManager();
            $post = $postManager->getPost($id);


            $aDataCategory = $manager->getCategoryData($post->idcategory());

            $aDataPost = [
                'postId'       => $post->id(),
                'postTitle'    => $post->title(),
                'postContent'  => $post->content(),
                'idcategory'   => $post->idcategory(),
                'postImg'      => $post->postImg(),
                'namecategory' => $aDataCategory->name(),
            ];
        }


        $content = $this->_twig->render('formPost.html.twig', array_merge([
                'title'        => 'Modifier',
                'valid'        => (isset($postUpdate['valid']) === true) ? $postUpdate['valid'] : '',
                'error'        => (isset($postUpdate['error']) === true) ? $postUpdate['error'] : '',
                'categoryList' => $aCategory,
            ], $aDataPost)
        );

//        $content = $this->_twig->render('formPost.html.twig', [
//            'valid' => (isset($post['valid']) === true ) ? $postUpdate['valid'] : '',
//            'error' => (isset($post['error']) === true ) ? $postUpdate['error'] : '',
//        ]);

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
        $manager = new PostManager();
        $addpost = $manager->addPost();

//        $content = $this->_twig->render('formPost.html.twig', ['title' => 'Ajouter un article']);
        $content = $this->_twig->render('formAddPost.html.twig', $addpost);
        return $content;

//        $content = $this->_twig->render('returnMessage.html.twig', [
//            'Message' => $addpost,
//        ]);
//        return $content;
    }

}