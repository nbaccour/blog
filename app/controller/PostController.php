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


class PostController extends DefaultController
{

    function getListPost()
    {

        $manager = new PostManager();
        $posts = $manager->getListPost();


        foreach ($posts as $key => $aData) {

            $aData->createDateFormat = date('d/m/Y', strtotime($aData->createDate()));

            $commentManager = new CommentManager();
            $aComments = $commentManager->getCommentValidByIdPost($aData->id());
            $aData->nbrcomment = count($aComments);
        }

        $urlPage = $this->getUrlPage();
        $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts, 'requestUri' => $urlPage]);
        return $content;

    }

    function getListPostByName($name)
    {

        $manager = new PostManager();
        $posts = $manager->getListPostByName($name);

        foreach ($posts as $key => $aData) {

            $aData->createDateFormat = date('d/m/Y', strtotime($aData->createDate()));

            $commentManager = new CommentManager();
            $aComments = $commentManager->getCommentValidByIdPost($aData->id());
            $aData->nbrcomment = count($aComments);
        }


        $content = $this->_twig->render('listPostByName.html.twig', ['posts' => $posts, 'Category' => $name]);
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

        $disableBtSendComment = 0;
        if (isset($_SESSION['iduser'])) {
            $aCommentsAuthorNotValid = $commentManager->getCommentNotValidByIdAuthorByIdPost($_SESSION['iduser'], $id);
            if (count($aCommentsAuthorNotValid) !== 0) {
                $disableBtSendComment = 1;
            }
        }

        $aListCommentParent = [];
        foreach ($aComments as $key => $aData) {

            if ($aData->parentid() === '0') {
                $aListCommentParent[$aData->id()] = $aData;
            }

        }

        foreach ($aComments as $aData) {
            if ($aData->parentid() !== '0') {
                foreach ($aListCommentParent as $idcomment => $aCommentData) {
                    if ((int)$aData->parentid() === $idcomment) {

                        $aListCommentParent[$idcomment]->commentsChild[] = $aData;
                    }
                }
            }

        }
        $aListCommentParentChild = array_values($aListCommentParent);

        $postManager = new PostManager();
        $post = $postManager->getPost($id);

        $content = $this->_twig->render('post.html.twig', [
            'idauthorcomment' => (isset($_SESSION['iduser']) === true) ? (int)$_SESSION['iduser'] : '',
            'connectid'       => (isset($_SESSION['iduser'])) ? $_SESSION['iduser'] : '',
            'postid'          => $post->id(),
            'disabledBt'      => $disableBtSendComment,
            'title'           => $post->title(),
            'content'         => $post->content(),
            'category'        => $post->name,
            'author'          => $post->author(),
            'postimg'         => $post->imgPost(),
            'createDate'      => date('d/m/Y', strtotime($post->createDate())),
            'comments'        => $aListCommentParentChild,
            'countcomments'   => count($aComments),
        ]);

        return $content;

    }


}