<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

namespace App\model;

class CategoryManager extends DataBase
{


    function getCategory()
    {
        $db = $this->dbconnect();
        try {
            $aCategory = [];
            $req = $db->prepare('SELECT * FROM category ORDER BY name ASC');

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
        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }

    function getIdCategoryByName($name)
    {
        $db = $this->dbconnect();
        try {
            $aCategory = [];
            $req = $db->prepare('SELECT * FROM category WHERE name =:name ORDER BY name ASC') or die(print_r($db->errorInfo()));

            $req->bindValue(':name', $name);

            if ($req->execute()) {
                $data = $req->fetch(\PDO::FETCH_ASSOC);
                return $data;
//                while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
//
//                    $category = new Category();
//                    $category->setAttribute($data);
//                    array_push($aCategory, $category);
//                }
//                $test = '';
//            return $aCategory;
            } else {
                throw new \Exception('Impossible de trouver les catégories !');
            }
        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }
}