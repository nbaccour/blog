<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

namespace App\model;

class Project
{
    protected $_id;
    protected $_title;
    protected $_content;
    protected $_detail;
    protected $_mentor;
    protected $_evaluator;
    protected $_validDate;
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

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function detail()
    {
        return $this->_detail;
    }

    public function mentor()
    {
        return $this->_mentor;
    }

    public function evaluator()
    {
        return $this->_evaluator;
    }

    public function validDate()
    {
        return $this->_validDate;
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

    public function setDetail($detail)
    {
        if (is_string($detail)) {
            $this->_detail = $detail;
        }
    }

    public function setMentor($mentor)
    {
        if (is_string($mentor)) {
            $this->_mentor = $mentor;
        }
    }

    public function setEvaluator($evaluator)
    {
        if (is_string($evaluator)) {
            $this->_evaluator = $evaluator;
        }
    }

    public function setValidDate($validDate)
    {
        if (is_string($validDate)) {
            $this->_validDate = $validDate;
        }
    }

    public function setCreateDate($createDate)
    {
        if (is_string($createDate)) {
            $this->_createDate = $createDate;
        }
    }
}