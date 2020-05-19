<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;


/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class FrontendController
 * @package App\controller
 */
class FrontendController extends DefaultController
{

    /**
     * deconnexion
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
     * formulaire de contact
     *
     *
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
     * Récupère une page en fonction du nom
     *
     *
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