<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

class PostManager extends DataBase
//class PostManager
{

//    protected function dbconnect()
//    {
////        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
////        return $db;
//
//        try {
//            if (strpos($_SERVER['REQUEST_URI'], 'blog-02') !== false) {//DEV
//                $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
//            } else {
//                $db = new PDO('mysql:host=db5000322164.hosting-data.io;dbname=dbs314235;charset=utf8',
//                    'dbu413698',
//                    '!ProjetBlogOC01!');
//
//            }
//            return $db;
//
//
//        } catch (Exception $e) {
//            die('Erreur : ' . $e->getMessage());
//        }
//    }


    function getListPost()
    {
        $db = $this->dbconnect();
        $posts = [];
        $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.postimg, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) ORDER BY po.id DESC') or die(print_r($db->errorInfo()));
//        $req = $db->prepare('SELECT * FROM posts ORDER BY id DESC') or die(print_r($db->errorInfo()));
        if ($req->execute()) {

            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                array_push($posts, $data);
            }


            return $posts;
//            return $aData;
        } else {
            throw new Exception('Impossible de trouver les articles !');
        }

    }

    /**
     * @param $idPost
     * @return Post
     */
    function getPost($idPost)
    {

        $db = $this->dbconnect();
//        $req = $db->prepare('select * from posts WHERE id = :id') or die(print_r($db->errorInfo()));

        $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.postimg, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) WHERE po.id = :id ORDER BY po.id DESC') or die(print_r($db->errorInfo()));

        $req->bindValue(':id', $idPost);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data;

//        $post = new Post();
//        $post->setAttribute($data);
//        return $post;
    }
}