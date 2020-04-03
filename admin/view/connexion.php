<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 02/04/2020
 * Time: 18:01
 */
/**
 * Nous créons deux variables : $username et $password qui valent respectivement "Sdz" et "salut"
 */

$username = "Sdz";
$password = "salut";

if( isset($_POST['username']) && isset($_POST['password']) ){

    if($_POST['username'] == $username && $_POST['password'] == $password){ // Si les infos correspondent...
        session_start();
        $_SESSION['user'] = $username;
        echo "Success";
    }
    else{ // Sinon
        echo "Failed";
    }
}