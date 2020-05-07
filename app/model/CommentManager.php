<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 22/04/2020
 * Time: 00:50
 */

namespace App\model;

class CommentManager extends DataBase
{
//Add Comment method
    public function addComment($POST)
    {


        $db = $this->dbconnect();

        $comment = new Comment();
        $comment->setAttribute($POST);

        $postId = $comment->postid();
        $parentId = $comment->parentid();
        $commentsend = $comment->comment();
        $author = $comment->author();
        $createDate = date('Y-m-d H:i:s');


        $req = $db->prepare('INSERT INTO comments (postid, parentid, comment, author,createDate) VALUE (:postid,:parentid, :comment, :author, :createDate)')
        or die(print_r($db->errorInfo()));

        $req->bindParam(':postid', $postId);
        $req->bindParam(':parentid', $parentId);
        $req->bindParam(':comment', $commentsend);
        $req->bindParam(':author', $author);
        $req->bindParam(':createDate', $createDate);


        if ($req->execute()) {
            return true;
        } else {
//                return 'erreur';
            return ['error' => $db->errorInfo()];
        }

        $db->close();

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



        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
    }

    public function getCommentNotValidByIdAuthor($id)
    {
        $db = $this->dbconnect();

        $aComments = [];
        $req = $db->prepare('select * from comments WHERE author = :author AND valid = 0 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));

        $req->bindValue(':author', $id);
        $req->execute();



        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
    }
    public function getCommentNotValidByIdAuthorByIdPost($id, $postId)
    {
        $db = $this->dbconnect();

        $aComments = [];
        $req = $db->prepare('select * from comments WHERE author = :author AND postid = :postid AND valid = 0 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));

        $req->bindValue(':author', $id);
        $req->bindValue(':postid', $postId);
        $req->execute();



        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
    }

    public function getCommentValidByIdPost($id)
    {
        $db = $this->dbconnect();

        $aComments = [];
        $req = $db->prepare('select * from comments WHERE postid = :postid AND valid = 1 ORDER BY createDate DESC') or die(print_r($db>errorInfo()));

        $req->bindValue(':postid', $id);
        $req->execute();



        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

            array_push($aComments, $data);
        }
        return $aComments;
    }

// Count comment method
    public function countComment()
    {
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT COUNT(*) AS statut FROM comments WHERE statut = 0') or die(print_r($bdd->errorInfo()));
        $req->execute();
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $count = $data['statut'];
        return $count;
    }
}