<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;

use App\model\ProjectManager;


class ProjectController extends DefaultController
{


    function getProject($id)
    {


        $manager = new ProjectManager();
        $project = $manager->getProject($id);


        $content = $this->_twig->render('project.html.twig', ['project' => $project]);
        return $content;


    }

}