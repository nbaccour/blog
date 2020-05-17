<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 25/04/2020
 * Time: 16:45
 */

namespace App;


class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {


        // on explose notre variable $class par \
        $parts = preg_split('#\\\#', $class);

        // on extrait le dernier element
        $className = array_pop($parts);

        // on créé le chemin vers la classe

        $path = implode(DS, $parts);
        $file = $className . '.php';

        $filepath = ROOT . strtolower($path) . DS . $file;

        require $filepath;

    }


}