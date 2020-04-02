<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

//namespace admin\model;

class CategoryManager extends DataBase
{
    function getCategory()
    {
        $db = $this->dbconnect();
        $aCategory = [];
        $req = $db->prepare('SELECT * FROM category ORDER BY id ASC') or die(print_r($db->errorInfo()));

        if ($req->execute()) {
            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {

                $category = new Category();
                $category->hydrate($data);
                array_push($aCategory, $category);
            }

            return $aCategory;
        } else {
            throw new Exception('Impossible trouver les articles !');
        }

    }
}