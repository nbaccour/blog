<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 03/04/2020
 * Time: 11:11
 */
/**
 * @param $aJson
 */
function jsonGenerate($aJson)
{
    header('Content-Type: application/json');
    echo json_encode($aJson);
}