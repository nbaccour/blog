<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;


/**
 * Class FrontendController
 * @package App\controller
 */
class FrontendController extends DefaultController
{

    /**
     *
     */
    function connectOut()
    {
        session_unset();
        session_destroy();
        header("Refresh: 1; URL=index.php");

        exit;
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function getFormConnect()
    {
        $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin']);
        return $content;
    }

    /**
     * @param $namePage
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function getPage($namePage)
    {
        $content = $this->_twig->render($namePage . '.html.twig', ['title' => 'Admin']);
        return $content;
    }


}