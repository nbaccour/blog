<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:24
 */

namespace App\controller;

/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class DefaultController
 * @package App\controller
 */
class DefaultController
{
    /**
     * @var \Twig_Environment
     */
    protected $_twig;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(['view', 'public/template']); // Dossier contenant les templates
        $this->_twig = new \Twig_Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);

        $this->_twig->addGlobal('session', $_SESSION);
        //var_dump($_SESSION);
        $this->_twig->addExtension(new \Twig\Extension\DebugExtension());


    }

    /**
     * @return mixed
     */
    function getUrlPage()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return $requestUri;

    }
}