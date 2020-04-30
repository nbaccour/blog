<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

class ProjectManager extends DataBase
{


    /**
     * @param $id
     * @return Project
     */
    function getProject($id)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('select * from projects WHERE id = :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $id);
        $req->execute();
        $data = $req->fetch(\PDO::FETCH_ASSOC);

        $project = new Project();
        $project->setAttribute($data);
        return $project;
    }


//    function getListProject()
//    {
//        $db = $this->dbconnect();
//        $projects = [];
//        $req = $db->prepare('SELECT * FROM projects ORDER BY id DESC') or die(print_r($db->errorInfo()));
//        if ($req->execute()) {
//
//            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
//                array_push($projects, $data);
//            }
//
//
//            return $projects;
////            return $aData;
//        } else {
//            throw new Exception('Impossible de trouver les projets !');
//        }
//
//    }


}