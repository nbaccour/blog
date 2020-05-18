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


    function getIdCategoryByName($name)
    {
        $db = $this->dbconnect();
        try {

            $req = $db->prepare('SELECT * FROM category WHERE name =:name ORDER BY name ASC') or die(print_r($db->errorInfo()));

            $req->bindValue(':name', $name);

            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            $category = new Category();
            $category->setAttribute($data);


            return $category;


        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }
}