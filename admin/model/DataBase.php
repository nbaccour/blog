<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 08/04/2020
 * Time: 13:13
 */

/**
 * Class DataBase
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 */
class DataBase
{
    protected function dbconnect()
    {


        try {
            if (strpos($_SERVER['REQUEST_URI'], 'blog-02') !== false) {//DEV
                $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            } else {
                $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

            }
            return $db;


        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }
}