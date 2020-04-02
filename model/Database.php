<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

class DataBase
{
    protected function dbconnect()
    {
//        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
//        return $db;

        try {
            $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            return $db;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}