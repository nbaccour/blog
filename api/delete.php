<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 18/03/2020
 * Time: 22:49
 */

$url = 'http://127.0.0.1/openclassroom/projet-blog/blog-02/api/articles/5';// supprimer l'article 1
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
//var_dump($response);
curl_close($ch);