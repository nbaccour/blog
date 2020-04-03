<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 18/03/2020
 * Time: 22:48
 */

$url = 'http://127.0.0.1/openclassroom/projet-blog/blog-02/api/articles';
$data = ['title' => 'chapitre 11', 'content' => 'contenu article 11', 'author' => 'BACCOUR Nizar', 'postimg' => ''];
// utilisez 'http' même si vous envoyez la requête sur https:// ...
$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === false) { /* Handle error */
}
var_dump($result);
