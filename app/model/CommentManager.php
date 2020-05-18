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
    public function addComment($POST)
    {


        $db = $this->dbconnect();
        try {
            $comment = new Comment();
            $comment->setAttribute($POST);

            $postId = $comment->postid();
            $parentId = $comment->parentid();
            $commentsend = $comment->comment();
            $author = $comment->author();
            $createDate = date('Y-m-d H:i:s');


            $req = $db->prepare('INSERT INTO comments (postid, parentid, comment, author,createDate) VALUE (:postid,:parentid, :comment, :author, :createDate)');

            $req->bindParam(':postid', $postId);
            $req->bindParam(':parentid', $parentId);
            $req->bindParam(':comment', $commentsend);
            $req->bindParam(':author', $author);
            $req->bindParam(':createDate', $createDate);

            return $req->execute();


        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }


    }

    //Get list method
    public function getlist($id)
    {
        $db = $this->dbconnect();
        try {
            $aComments = [];
            $req = $db->prepare('SELECT co.id, co.postid, co.parentid, co.author, co.comment, co.createDate, us.firstname 
FROM comments AS co 
LEFT JOIN users AS us ON (co.author = us.id) WHERE co.postid = :id AND co.statut = 1 AND co.valid = 1 ORDER BY co.id DESC');

            $req->bindValue(':id', $id);
            $req->execute();


            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

                $comment = new Comment();
                $comment->setAttribute($data);
                $comment->firstname = $data['firstname'];
                array_push($aComments, $comment);
            }
            return $aComments;
        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }

    }


    public function getCommentNotValidByIdAuthorByIdPost($id, $postId)
    {
        $db = $this->dbconnect();
        try {
            $aComments = [];
            $req = $db->prepare('select * from comments WHERE author = :author AND postid = :postid AND valid = 0 ORDER BY createDate DESC');

            $req->bindValue(':author', $id);
            $req->bindValue(':postid', $postId);
            $req->execute();


            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

                $comment = new Comment();
                $comment->setAttribute($data);
                array_push($aComments, $comment);
            }


            return $aComments;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }

    }

    public function getCommentValidByIdPost($id)
    {
        $db = $this->dbconnect();
        try {
            $aComments = [];
            $req = $db->prepare('select * from comments WHERE postid = :postid AND valid = 1 ORDER BY createDate DESC');

            $req->bindValue(':postid', $id);
            $req->execute();

            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {

                $comment = new Comment();
                $comment->setAttribute($data);
                array_push($aComments, $comment);
            }

            return $aComments;

        } catch (Exception $e) {

            throw new \Exception($e->getMessage());
        }

    }
//
//    public function countComment()
//    {
//        $db = $this->dbconnect();
//        try {
//            $req = $db->prepare('SELECT COUNT(*) AS statut FROM comments WHERE statut = 0');
//            $req->execute();
//            $data = $req->fetch(\PDO::FETCH_ASSOC);
//            $count = $data['statut'];
//            return $count;
//
//        } catch (Exception $e) {
//
//            throw new \Exception($e->getMessage());
//        }
//
//    }
}