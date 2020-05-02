<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

namespace App\model;

class CategoryManager extends DataBase
//class CategoryManager
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

    function getCategory()
    {
        $db = $this->dbconnect();
        $aCategory = [];
        $req = $db->prepare('SELECT * FROM category ORDER BY name ASC') or die(print_r($db->errorInfo()));

        if ($req->execute()) {
            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

                $category = new Category();
                $category->setAttribute($data);
                array_push($aCategory, $category);
            }

            return $aCategory;
        } else {
            throw new \Exception('Impossible trouver les catégories !');
        }

    }

    function getIdCategoryByName($name)
    {
        $db = $this->dbconnect();
        $aCategory = [];
        $req = $db->prepare('SELECT * FROM category WHERE name =:name ORDER BY name ASC') or die(print_r($db->errorInfo()));

        $req->bindValue(':name', $name);

        if ($req->execute()) {
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            return $data;
//            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
//
//                $category = new Category();
//                $category->setAttribute($data);
//                array_push($aCategory, $category);
//            }
//            return $aCategory;
        } else {
            throw new \Exception('Impossible de trouver les catégories !');
        }

    }
}