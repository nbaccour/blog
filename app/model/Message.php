<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

class Message
{

    protected $_id;
    protected $_lastname;
    protected $_firstname;
    protected $_email;
    protected $_content;
    protected $_valid;
    protected $_createDate;


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

    public function lastname()
    {
        return $this->_lastname;
    }

    public function firstname()
    {
        return $this->_firstname;
    }

    public function email()
    {
        return $this->_email;
    }

    public function content()
    {
        return $this->_content;
    }

    public function valid()
    {
        return $this->_valid;
    }

    public function createDate()
    {
        return $this->_createDate;
    }


    //Setter
    public function setId($id)
    {
        if ((int)$id) {
            $this->_id = $id;
        }
    }


    public function setLastname($lastname)
    {
        if (is_string($lastname)) {
            $this->_lastname = $lastname;
        }
    }

    public function setFirstname($firstname)
    {
        if (is_string($firstname)) {
            $this->_firstname = $firstname;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
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


}