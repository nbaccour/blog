<?php
session_start();


// User data to send using HTTP POST method in curl
//print_r($_SESSION['firstnameUser']);
$data = [];
//print_r($_GET);
// Data should be passed as json format
$data_json = json_encode($data);

// API URL to send data
$url = 'http://127.0.0.1/openclassroom/projet-blog/blog-02/admin/index.php/?action=' . $_GET['action'] . '&id=' . $_GET['id'] . '&login=' . $_GET['login'];// supprimer l'article 1
//$timeout = 1000;
// curl intitite
$curl_handle = curl_init();

curl_setopt($curl_handle, CURLOPT_URL, $url);
//curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, true);
//curl_setopt($curl_handle, CURLOPT_TIMEOUT, $timeout);
//curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);

// Set json header to received json response properly
curl_setopt($curl_handle, CURLOPT_HTTPHEADER,
    ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)]);

// SET Method as a DELETE
curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "DELETE");

// Pass user data in POST command
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data_json);

curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data into
$response = curl_exec($curl_handle);

// Close curl
curl_close($curl_handle);

// See response if data is posted successfully or any error
print_r($response);