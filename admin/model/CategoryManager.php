<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

/**
 * Class CategoryManager
 */
class CategoryManager extends DataBase
{

    /**
     * @return array
     * @throws Exception
     */
    function getCategory()
    {
        $db = $this->dbconnect();
        $aCategory = [];
        $req = $db->prepare('SELECT * FROM category ORDER BY id ASC') or die(print_r($db->errorInfo()));

        if ($req->execute()) {
            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {

                $category = new Category();
                $category->setAttribute($data);
                array_push($aCategory, $category);
            }

            return $aCategory;
        } else {
            throw new Exception('Impossible trouver les catégories !');
        }

    }

    /**
     * @param int $id
     * @return Category
     * @throws Exception
     */
    function getCategoryData(int $id)
    {
        $db = $this->dbconnect();

        $req = $db->prepare('select * from category WHERE id = :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $id);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        $category = new Category();
        $category->setAttribute($data);
        return $category;

    }
}