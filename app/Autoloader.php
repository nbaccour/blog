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
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){


        //---------------------------
//        $extensions = [".php"];
////        $folders = ['', 'model', 'controller'];
//        $folders = [''];
//
//        foreach ($folders as $folder) {
//            foreach ($extensions as $extension) {
//                if ($folder == '') {
//                    $path = $folder . $class . $extension;
//                } else {
//                    $path = $folder . DIRECTORY_SEPARATOR . $class . $extension;
//                }
////                var_dump($path);
//                if (is_readable($path)) {
//                    include_once($path);
//                }
//            }
//        }
        //---------------------------

        // on explose notre variable $class par \
        $parts = preg_split('#\\\#', $class);

        // on extrait le dernier element
        $className = array_pop($parts);

        // on créé le chemin vers la classe
        // on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux)

        $path = implode(DS, $parts);
        $file = $className.'.php';

        $filepath = ROOT.strtolower($path).DS.$file;

         var_dump($filepath);
        //
        require $filepath;

        //----------------------
    }



}