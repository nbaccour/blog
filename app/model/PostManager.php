<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

use App\model\CategoryManager;
use App\model\Post;

class PostManager extends DataBase
{


    function getListPost()
    {
        $db = $this->dbconnect();
        try {
            $posts = [];
            $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.imgPost, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) ORDER BY po.id DESC');

            $req->execute();
            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                $post = new Post();
                $post->setAttribute($data);
                array_push($posts, $post);
            }
            return $posts;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }

    function getListPostByName($name)
    {
        $db = $this->dbconnect();

        $manager = new CategoryManager();
        $category = $manager->getIdCategoryByName($name);

        $posts = [];


        try {
            $req = $db->prepare('SELECT * FROM posts WHERE idcategory =:idcategory ORDER BY id DESC');
            $req->bindValue(':idcategory', (int)$category->id());

            $req->execute();

            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

                $post = new Post();
                $post->setAttribute($data);
                $post->namecategory = $category->name();

                array_push($posts, $post);
            }

            return $posts;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }


    function getPost($id)
    {

        $db = $this->dbconnect();
        try {

            $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.imgPost, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) WHERE po.id = :id');

            $req->bindValue(':id', $id);
            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            $post = new Post();
            $post->setAttribute($data);
            $post->name = $data['name'];

            return $post;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }
}