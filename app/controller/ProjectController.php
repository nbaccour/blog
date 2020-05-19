<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */





/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class ProjectController
 * @package App\controller
 */
class ProjectController extends DefaultController
{


    /**
     * Récupère les données d'un projet
     *
     *
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function getProject($id)
    {


        $manager = new ProjectManager();
        $project = $manager->getProject($id);


        $content = $this->_twig->render('project.html.twig', ['project' => $project]);
        return $content;


    }

}