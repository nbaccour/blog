<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


class PostController extends DefaultController
{

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


        return $content;

    }


    function addPost()
    {
        $manager = new PostManager();
        $addpost = $manager->addPost();

        $content = $this->_twig->render('formAddPost.html.twig', $addpost);
        return $content;

    }

}