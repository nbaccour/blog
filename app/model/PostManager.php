<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

use App\model\CategoryManager;

class PostManager extends DataBase
{


    function getListPost()
    {
        $db = $this->dbconnect();
        $posts = [];
        $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.postimg, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) ORDER BY po.id DESC') or die(print_r($db->errorInfo()));
//        $req = $db->prepare('SELECT * FROM posts ORDER BY id DESC') or die(print_r($db->errorInfo()));
        if ($req->execute()) {

            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                array_push($posts, $data);
            }


            return $posts;
//            return $aData;
        } else {
            throw new \Exception('Impossible de trouver les articles !');
        }

    }

    function getListPostByName($name)
    {
        $db = $this->dbconnect();

        $manager = new CategoryManager();
        $category = $manager->getIdCategoryByName($name);

        $posts = [];

        if (count($category) !== 0) {
            $req = $db->prepare('SELECT * FROM posts WHERE idcategory =:idcategory ORDER BY id DESC') or die(print_r($db->errorInfo()));
            $req->bindValue(':idcategory', (int)$category['id']);
            if ($req->execute()) {

                while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $data['namecategory'] = $category['name'];

                    array_push($posts, $data);
                }


                return $posts;
//            return $aData;
            } else {
                throw new \Exception('Impossible de trouver les articles !');
            }
        } else {
            throw new \Exception('Impossible de trouver les articles !');
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
        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return $data;

//        $post = new Post();
//        $post->setAttribute($data);
//        return $post;
    }
}