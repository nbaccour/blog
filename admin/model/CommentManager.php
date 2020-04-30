<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 22/04/2020
 * Time: 00:50
 */

//namespace App\model;

class CommentManager extends DataBase
{

    function deleteComment($id)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('DELETE FROM comments WHERE id= :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $id);
        return $req->execute();

    }

    public function getListAllComment(array $aOptions = [])
    {
        $db = $this->dbconnect();
        $sWhere = ' WHERE co.statut = 1 AND co.valid = 1 ';
        if (isset($aOptions['mode']) && $aOptions['mode'] === 'statut') {
            $sWhere = ' WHERE co.statut = 0 AND co.valid = 0 ';
        }
        if (isset($aOptions['mode']) && $aOptions['mode'] === 'valid') {
            $sWhere = ' WHERE co.valid = 0 ';
        }

        $aComments = [];
//        $req = $db->prepare('select * from comments WHERE postid = :id AND statut = 1 AND valid = 1 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));
        $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname, po.title 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) 
LEFT JOIN posts AS po ON (co.postid = po.id) 
' . $sWhere . ' ORDER BY co.id DESC')
        or die(print_r($db > errorInfo()));

//        $req->bindValue(':id', $id);
        $req->execute();


        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $data['mode'] = (isset($aOptions['mode'])) ? $aOptions['mode'] : 'valid';
            array_push($aComments, $data);
        }
        return $aComments;
    }

    //Get list method
    public function getListComment($id)
    {
        $db = $this->dbconnect();

        $aComments = [];
//        $req = $db->prepare('select * from comments WHERE postid = :id AND statut = 1 AND valid = 1 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));
        $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) WHERE co.postid = :id AND co.statut = 1 AND co.valid = 1 ORDER BY co.id DESC') or die(print_r($db > errorInfo()));

        $req->bindValue(':id', $id);
        $req->execute();


        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
    }
    function getComment($id)
    {

        $db = $this->dbconnect();
//        $req = $db->prepare('select * from comments WHERE id = :id') or die(print_r($db->errorInfo()));

        $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname, po.title 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) 
LEFT JOIN posts AS po ON (co.postid = po.id) 
WHERE co.id = :id ORDER BY co.id DESC')
        or die(print_r($db > errorInfo()));

        $req->bindValue(':id', $id);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

//        $comment = new Comment();
//        $comment->setAttribute($data);
//        return $comment;
        return $data;
    }

    //// Valid comment method

    function validComment(array $PUT)
    {
        $db = $this->dbconnect();

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
//            return $req->execute();
            if ($req->execute()) {

                return true;
            } else {
//                return ['error' => $db->errorInfo()];
                return ['result' => $db->errorInfo()];
            }

        }

    }
////Delete Comment method
//    public function delete($id)
//    {
//        $db = $this->dbconnect();
//        $req = $db->prepare('DELETE FROM comments WHERE id = :id');
//        $req->bindValue(':id', $id);
//        $req->execute();
//    }
////Get Status method
//    public function getStatus($status)
//    {
//        $db = $this->dbconnect();
//        $comments = [];
//        $req = $db->prepare('select * from comments WHERE  statut = :status') or die(print_r($db->errorInfo()));
//        $req->bindValue(':status', $status);
//        $req->execute();
//        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
//            $comment = new Cmt();
//            $comment->hydrate($data);
//            array_push($comments, $comment);
//        }
//        return $comments;
//    }



//// Cancel Report method
//    public function cancelReport($id)
//    {
//        $db = $this->dbconnect();
//        $req = $db->prepare('UPDATE comments SET reporting = 0 WHERE id = :id');
//        $req->bindValue(':id', $id);
//        $req->execute();
//    }
//// Get reporting method
//    public function getReporting($reporting)
//    {
//        $db = $this->dbconnect();
//        $comments = [];
//        $req = $db->prepare('select * from comments WHERE  reporting = :reporting') or die(print_r($bdd->errorInfo()));
//        $req->bindValue(':reporting', $reporting);
//        $req->execute();
//        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
//            $comment = new Cmt();
//            $comment->hydrate($data);
//            array_push($comments, $comment);
//        }
//        return $comments;
//    }
// Count comment method
    public function countComment()
    {
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT COUNT(*) AS statut FROM comments WHERE statut = 0') or die(print_r($db->errorInfo()));
        $req->execute();
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $count = $data['statut'];
        return $count;
    }
//// Count reporting comment method
//    public function countReporting()
//    {
//        $db = $this->dbconnect();
//        $req = $db->prepare('SELECT COUNT(*) AS reporting FROM comments WHERE reporting = 1') or die(print_r($bdd->errorInfo()));
//        $req->execute();
//        $data = $req->fetch(PDO::FETCH_ASSOC);
//        $count = $data['reporting'];
//        return $count;
//    }
}