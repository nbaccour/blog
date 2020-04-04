<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

//namespace admin\model;

class Post
{
    protected $_id;
    protected $_title;
    protected $_content;
    protected $_author;
    protected $_postImg;
    protected $_idcategory;
    protected $_createDate;
    protected $_modifDate;

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

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function author()
    {
        return $this->_author;
    }

    public function postImg()
    {
        return $this->_postImg;
    }

    public function idcategory()
    {
        return $this->_idcategory;
    }

    public function createDate()
    {
        return $this->_createDate;
    }

    public function modifDate()
    {
        return $this->_modifDate;
    }

    //Setter

    public function setId($id)
    {
        if ((int)$id) {
            $this->_id = $id;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->_author = $author;
        }
    }

    public function setPostImg($postImg)
    {
        $this->_postImg = $postImg;
    }

    public function setIdcategory($idcategory)
    {
        $this->_idcategory = $idcategory;
    }

    public function setCreateDate($createDate)
    {
        if (is_string($createDate)) {
            $this->_createDate = $createDate;
        }
    }

    public function setModifDate($modifDate)
    {
        if (is_string($modifDate)) {
            $this->_modifDate = $modifDate;
        }
    }
}