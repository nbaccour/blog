<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 18/03/2020
 * Time: 22:47
 */

// Se connecter à la base de données
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

print_r($request_method);
switch ($request_method) {
    case 'GET':
        var_dump('test2');
        if (!empty($_GET["id"])) {
            // Récupérer un seul article
            $id = intval($_GET["id"]);
            getPosts($id);
        } else {
            // Récupérer tous les articles
            getPosts();
        }
        break;
    case 'POST':
        // Ajouter un article
        AddPost();
        break;
    case 'PUT':
        // Modifier un article
        $id = intval($_GET["id"]);
        updatePost($id);
        break;
    case 'DELETE':
        print_r('test3');
        // Supprimer un article
        $id = intval($_GET["id"]);
        deletePost($id);
        break;
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

/**
 * @param int $id
 */
function getPosts($id = 0)
{
    global $conn;
    $query = "SELECT * FROM posts";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = [];
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result, true)) {

        $response[] = $row;

    }
    header('Content-Type: application/json');

    echo json_encode($response, JSON_PRETTY_PRINT);

}

/**
 * @param $id
 */
function updatePost($id)
{
    global $conn;
    $_PUT = []; //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);
    $title = $_PUT["title"];
    $content = $_PUT["content"];
    $author = $_PUT["author"];
    $postimg = $_PUT["postimg"];
    $modifDate = date('Y-m-d H:i:s');
    //construire la requête SQL
    $query = "UPDATE posts SET title='" . $title . "', content='" . $content . "', author='" . $author . "', postimg='" . $postimg . "', modifDate='" . $modifDate . "' WHERE id=" . $id;

    if (mysqli_query($conn, $query)) {
        $response = [
            'status'         => 1,
            'status_message' => 'Article mis a jour avec succes.',
        ];
    } else {
        $response = [
            'status'         => 0,
            'status_message' => 'Echec de la mise a jour de l\'article. ' . mysqli_error($conn),
        ];

    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function deletePost($id)
{
    global $conn;
    $query = "DELETE FROM posts WHERE id=" . $id;
    if (mysqli_query($conn, $query)) {
        $response = [
            'status'         => 1,
            'status_message' => 'Article supprime avec succes.',
        ];
    } else {
        $response = [
            'status'         => 0,
            'status_message' => 'La suppression de l\'article a echoue. ' . mysqli_error($conn),
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}


/**
 *
 */
function addPost()
{
    global $conn;
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_POST["author"];
    $postimg = $_POST["postimg"];
    $createDate = date('Y-m-d H:i:s');

    echo $query = "INSERT INTO posts(title, content, author, postimg, createDate) 
    VALUES('" . $title . "', '" . $content . "', '" . $author . "', '" . $postimg . "', '" . $createDate . "')";

    if (mysqli_query($conn, $query)) {
        $response = [
            'status'         => 1,
            'status_message' => 'Article ajoute avec succes.',
        ];
    } else {
        $response = [
            'status'         => 0,
            'status_message' => 'ERREUR!.' . mysqli_error($conn),
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);


}


