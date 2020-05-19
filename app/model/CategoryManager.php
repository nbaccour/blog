<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */



/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class CategoryManager
 * @package App\model
 */
class CategoryManager extends DataBase
{


    /**
     * Récupère les gategorie
     *
     * @param string $name
     * @return Category
     * @throws \Exception
     */
    function getIdCategoryByName(string $name)
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