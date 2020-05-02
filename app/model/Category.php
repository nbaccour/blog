<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

class Category
{
    protected $_id;
    protected $_name;
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

    public function name()
    {
        return $this->_name;
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

    public function setName($name)
    {
        if (is_string($name)) {
            $this->_name = $name;
        }
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