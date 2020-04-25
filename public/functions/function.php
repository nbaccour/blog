<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 25/04/2020
 * Time: 17:10
 */

function jsonGenerate($aJson)
{
    header('Content-Type: application/json');
    echo json_encode($aJson);
}