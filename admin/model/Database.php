<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

//namespace admin\model;

class DataBase
{
    protected function dbconnect()
    {

        try {

            if (strpos($_SERVER['REQUEST_URI'], 'blog-02') !== false) {//DEV
                $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            } else {
                $db = new PDO('mysql:host=db5000322164.hosting-data.io;dbname=dbs314235;charset=utf8',
                    'dbu413698',
                    '!ProjetBlogOC01!');

            }

            return $db;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}