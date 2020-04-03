<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 18/03/2020
 * Time: 22:49
 */

$url = 'http://127.0.0.1/openclassroom/projet-blog/blog-02/api/articles/3';// modifier l article 1
$data = [
    'title'   => 'modif titre article',
    'content' => 'modifier article contenu',
    'author'  => 'baccour',
    'postimg' => 'image3',
];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
var_dump($response);
if (!$response) {
    return false;
}
