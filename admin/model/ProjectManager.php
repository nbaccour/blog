<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */


class ProjectManager extends DataBase
{


    function getListProject()
    {
        $db = $this->dbconnect();
        $projects = [];
        $req = $db->prepare('SELECT * FROM projects ORDER BY id DESC') or die(print_r($db->errorInfo()));
        if ($req->execute()) {

            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                array_push($projects, $data);
            }


            return $projects;
//            return $aData;
        } else {
            throw new Exception('Impossible de trouver les projets !');
        }

    }

    /**
     * @param $idPost
     * @return Post
     */
    function getProject($idPost)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('select * from projects WHERE id = :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $idPost);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        $project = new Project();
        $project->setAttribute($data);
        return $project;
    }

    function deleteProject($id)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('DELETE FROM projects WHERE id= :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $id);
        return $req->execute();

    }

    function updateProject(array $PUT)
    {
        $db = $this->dbconnect();

        $project = new Project();
        $project->setAttribute($PUT);

//        $modifDate = date('Y-m-d H:i:s');


        if (intval($project->id()) !== '') {
            $req = $db->prepare('UPDATE projects SET  title = :title, content = :content, detail = :detail, mentor = :mentor, evaluator = :evaluator, validDate = :validDate WHERE id = :id')
            or die(print_r($db->errorInfo()));

            $req->bindValue(':id', intval($project->id()));
            $req->bindValue(':title', $project->title());
            $req->bindValue(':content', $project->content());
            $req->bindValue(':detail', $project->detail());
            $req->bindValue(':mentor', $project->mentor());
            $req->bindValue(':evaluator', $project->evaluator());
            $req->bindValue(':validDate', $project->validDate());
//            return $req->execute();
            if ($req->execute()) {

                return true;
            } else {
//                return ['error' => $db->errorInfo()];
                return ['result' => $db->errorInfo()];
            }

        }

    }

    function addProject($POST)
    {
        $db = $this->dbconnect();

        $project = new Project();
        $project->setAttribute($POST);

        $title = $project->title();
        $content = $project->content();
        $mentor = $project->mentor();
        $evaluator = $project->evaluator();
        $validDate = $project->validDate();

        $createDate = date('Y-m-d H:i:s');


        $req = $db->prepare('INSERT INTO projects(title, content, mentor, evaluator, validDate, createDate) VALUE (:title,:content,:mentor,:evaluator,:validDate,:createDate)')
        or die(print_r($db->errorInfo()));

        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':mentor', $mentor);
        $req->bindParam(':evaluator', $evaluator);
        $req->bindParam(':validDate', $validDate);
        $req->bindParam(':createDate', $createDate);


        if ($req->execute()) {
            return true;
        } else {
//                return 'erreur';
            return ['error' => $db->errorInfo()];
        }

        $db->close();
    }

}