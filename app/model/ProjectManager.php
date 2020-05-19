<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */


/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class ProjectManager
 * @package App\model
 */
class ProjectManager extends DataBase
{


    /**
     * Récupère les données des projets
     *
     *
     * @param $id
     * @return Project
     * @throws \Exception
     */
    function getProject($id)
    {

        $db = $this->dbconnect();
        try {
            $req = $db->prepare('select * from projects WHERE id = :id');
            $req->bindValue(':id', $id);
            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);

            $project = new Project();
            $project->setAttribute($data);
            return $project;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }

    }


}