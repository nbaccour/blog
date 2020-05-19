<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 22/04/2020
 * Time: 00:50
 */


class Comment
{
    protected $_id;
    protected $_postid;
    protected $_parentid;
    protected $_statut;
    protected $_comment;
    protected $_author;
    protected $_valid;
    protected $_createDate;
    protected $_updateDate;

    public function setAttribute(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //Getter
    public function id()
    {
        return $this->_id;
    }

    public function postid()
    {
        return $this->_postid;
    }

    public function parentid()
    {
        return $this->_parentid;
    }

    public function statut()
    {
        return $this->_statut;
    }

    public function comment()
    {
        return $this->_comment;
    }

    public function author()
    {
        return $this->_author;
    }

    public function valid()
    {
        return $this->_valid;
    }

    public function createDate()
    {
        return $this->_createDate;
    }

    public function updateDate()
    {
        return $this->_updateDate;
    }

    //Setter
    public function setId($id)
    {
        if ((int)$id) {
            $this->_id = $id;
        }
    }

    public function setPostid($postid)
    {
        if (is_numeric($postid) === true) {
            $this->_postid = $postid;
        }
    }

    public function setParentid($parentid)
    {
        if (is_numeric($parentid) === true) {
            $this->_parentid = $parentid;
        }
    }

    public function setStatut($statut)
    {
        if ((int)$statut) {
            $this->_statut = $statut;
        }
    }

    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->_comment = $comment;
        }
    }

    public function setAuthor($author)
    {
        if (is_numeric($author) === true) {
            $this->_author = $author;
        }
    }

    public function setValid($valid)
    {
        if ((int)$valid) {
            $this->_valid = $valid;
        }
    }

    public function setCreateDate($createDate)
    {
        if (is_string($createDate)) {
            $this->_createDate = $createDate;
        }
    }

    public function setUpdateDate($updateDate)
    {
        if (is_string($updateDate)) {
            $this->_updateDate = $updateDate;
        }
    }
}