<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */

/**
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class FrontendController
 */
class FrontendController extends DefaultController
{

    /**
     * déconnexion de l'utilisateur
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
     * formulaire de connexion
     *
     *
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function getFormConnect()
    {
        $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin']);
        return $content;
    }


}