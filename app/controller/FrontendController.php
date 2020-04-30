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
use App\model\CategoryManager;
use App\model\ProjectManager;

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

//        return $gategory;
//        $content = $this->_twig->render('base.html.twig', ['navCategory' => $gategory]);
        $content = $this->_twig->render('nav.html.twig', ['navCategory' => $gategory]);
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
            'idauthorcomment' => (isset($_SESSION['iduser']) === true) ? $_SESSION['iduser'] : '',
            'postid'          => $post['id'],
            'title'           => $post['title'],
            'content'         => $post['content'],
            'category'        => $post['name'],
            'author'          => $post['author'],
            'postimg'         => $post['postimg'],
            'createDate'      => date('d/m/Y', strtotime($post['createDate'])),
            'comments'        => $aListCommentParentChild,
            'countcomments'   => count($aComments),
//            'postContent' => $post->content(),
        ]);

        return $content;

    }
    //-------------------------------------------------------------------------------------------------------------
    //----------------------------------------     PROJECT  -----------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------------

    function getProject($id)
    {



        $manager = new ProjectManager();
        $project = $manager->getProject($id);



        $content = $this->_twig->render('project.html.twig', ['project' => $project]);
        return $content;


    }

}