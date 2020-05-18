<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;



class FrontendController extends DefaultController
{

    function connectOut()
    {
        session_unset();
        session_destroy();
        header("Refresh: 1; URL=index.php");

        exit;
    }

    function getFormConnect()
    {
        $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin']);
        return $content;
    }

    function getPage($namePage)
    {
        $content = $this->_twig->render($namePage . '.html.twig', ['title' => 'Admin']);
        return $content;
    }


}