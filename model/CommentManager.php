<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 22/04/2020
 * Time: 00:50
 */

class CommentManager extends DataBase
{
//Add Comment method
    public function add(Cmt $comment)
    {
        $db = $this->dbconnect();
        $req = $db->prepare('INSERT INTO comments(postId, title, comment, author, posted) VALUES(:postId, :title, :comment, :author, :posted)');
        $req->bindValue(':postId', $comment->postId());
        $req->bindValue(':title', htmlspecialchars($comment->title()));
        $req->bindValue(':comment', htmlspecialchars($comment->comment()));
        $req->bindValue(':author', $comment->author());
        $req->bindValue(':posted', $comment->posted());
        $req->execute();
    }

    //Get list method
    public function getlist($id)
    {
        $db = $this->dbconnect();

        $aComments = [];
//        $req = $db->prepare('select * from comments WHERE postid = :id AND statut = 1 AND valid = 1 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));
        $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) WHERE co.postid = :id AND co.statut = 1 AND co.valid = 1 ORDER BY co.id DESC') or die(print_r($db>errorInfo()));

        $req->bindValue(':id', $id);
        $req->execute();



        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
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

//// Valid comment method
//    public function valid($id)
//    {
//        $db = $this->dbconnect();
//        $req = $db->prepare('UPDATE comments SET statut = 1 WHERE id = :id');
//        $req->bindValue(':id', $id);
//        $req->execute();
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
        $req = $db->prepare('SELECT COUNT(*) AS statut FROM comments WHERE statut = 0') or die(print_r($bdd->errorInfo()));
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
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