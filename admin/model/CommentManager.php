<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 22/04/2020
 * Time: 00:50
 */

/**
 * CommentManager est une classe pour gérer les commentaires (ajout, suppression et mise à jour)
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class CommentManager
 */
class CommentManager extends DataBase
{

    /**
     * supprime un commentaire
     *
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    function deleteComment($id)
    {

        $db = $this->dbconnect();
        try {
            $req = $db->prepare('DELETE FROM comments WHERE id= :id');
            $req->bindValue(':id', $id);
            return $req->execute();
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * Récupère la liste des commentaires de la table comments
     *
     *
     * @param array $aOptions
     * @return array
     * @throws Exception
     */
    public function getListAllComment(array $aOptions = [])
    {
        $db = $this->dbconnect();

        try {
            $sWhere = ' WHERE co.statut = 1 AND co.valid = 1 ';
            if (isset($aOptions['mode']) && $aOptions['mode'] === 'statut') {
                $sWhere = ' WHERE co.statut = 0 AND co.valid = 0 ';
            }
            if (isset($aOptions['mode']) && $aOptions['mode'] === 'valid') {
                $sWhere = ' WHERE co.valid = 0 ';
            }

            $aComments = [];
            $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname, po.title 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) 
LEFT JOIN posts AS po ON (co.postid = po.id) 
' . $sWhere . ' ORDER BY co.id DESC');


            $req->execute();
            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                $comment = new Comment();
                $comment->setAttribute($data);
                $comment->firstname = $data['firstname'];
                $comment->title = $data['title'];

                array_push($aComments, $comment);
            }
            return $aComments;


        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }

    }


    /**
     * Récupère un commentaire en fonction de son id
     *
     *
     * @param $id
     * @return Comment
     * @throws Exception
     */
    function getComment($id)
    {

        $db = $this->dbconnect();

        try {
            $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname, po.title 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) 
LEFT JOIN posts AS po ON (co.postid = po.id) 
WHERE co.id = :id ORDER BY co.id DESC');

            $req->bindValue(':id', $id);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);

            $comment = new Comment();
            $comment->setAttribute($data);
            $comment->firstname = $data['firstname'];
            $comment->title = $data['title'];

            return $comment;

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }

    }


    /**
     * valide un commentaire
     *
     *
     * @param array $PUT
     * @return bool
     * @throws Exception
     */
    function validComment(array $PUT)
    {
        $db = $this->dbconnect();
        try {
            $comment = new Comment();
            $comment->setAttribute($PUT);

            $updateDate = date('Y-m-d H:i:s');


            if (intval($comment->id()) !== '') {
                $req = $db->prepare('UPDATE comments SET  comment = :comment, statut = :statut, valid = :valid, updateDate = :updateDate WHERE id = :id')
                or die(print_r($db->errorInfo()));

                $req->bindValue(':id', intval($comment->id()));
                $req->bindValue(':comment', $comment->comment());
                $req->bindValue(':statut', 1);
                $req->bindValue(':valid', 1);
                $req->bindValue(':updateDate', $updateDate);

                return $req->execute();

            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * Récupère le nombre des commentaires
     *
     *
     * @return mixed
     * @throws Exception
     */
    public function countComment()
    {
        $db = $this->dbconnect();
        try {
            $req = $db->prepare('SELECT COUNT(*) AS statut FROM comments WHERE statut = 0');
            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            $count = $data['statut'];
            return $count;
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }

    }
}