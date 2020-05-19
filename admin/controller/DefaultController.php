<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:24
 */


class DefaultController
{
    /**
     * @var Twig_Environment
     */
    protected $_twig;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem([
            'view',
            'public/template',
        ]); // Dossier contenant les templates
        $this->_twig = new Twig_Environment($loader, [
            'cache' => false,
        ]);

        $this->_twig->addGlobal('session', $_SESSION);
        //

    }


}