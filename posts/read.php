<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 21/03/2020
 * Time: 23:22
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../model/Database.php';
include_once '../model/Post.php';
include_once '../model/PostManager.php';
include_once '../controller/DefaultController.php';
include_once '../controller/FrontendController.php';

require('../vendor/autoload.php');

$frontendController = new FrontendController();

// show products data in json format
$contentListPost = $frontendController->getListPostTest();
echo json_encode($contentListPost);