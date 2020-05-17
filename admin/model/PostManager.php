<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */


class PostManager extends DataBase
{


    function getListPost()
    {
        $db = $this->dbconnect();
        $posts = [];
        $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.postimg, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) ORDER BY po.id DESC') or die(print_r($db->errorInfo()));
//        $req = $db->prepare('SELECT * FROM posts ORDER BY id DESC') or die(print_r($db->errorInfo()));
        if ($req->execute()) {

            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                array_push($posts, $data);
            }


            return $posts;
//            return $aData;
        } else {
            throw new Exception('Impossible trouver les articles !');
        }

    }

    /**
     * @param $idPost
     * @return Post
     */
    function getPost($idPost)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('select * from posts WHERE id = :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $idPost);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        $post = new Post();
        $post->setAttribute($data);
        return $post;
    }

    function deletePost($id)
    {

        $db = $this->dbconnect();
        $req = $db->prepare('DELETE FROM posts WHERE id= :id') or die(print_r($db->errorInfo()));
        $req->bindValue(':id', $id);
        return $req->execute();

    }

    function updatePost(array $PUT)
    {
        $db = $this->dbconnect();

        $post = new Post();
        $post->setAttribute($PUT);

        $modifDate = date('Y-m-d H:i:s');


        if (intval($post->id()) !== '') {
            $req = $db->prepare('UPDATE posts SET  title = :title, content = :content, modifDate = :modifDate, idcategory = :idcategory WHERE id = :id')
            or die(print_r($db->errorInfo()));

            $req->bindValue(':id', intval($post->id()));
            $req->bindValue(':title', $post->title());
            $req->bindValue(':content', $post->content());
            $req->bindValue(':idcategory', intval($post->idcategory()));
            $req->bindValue(':modifDate', $modifDate);
//            return $req->execute();
            if ($req->execute()) {

                return true;
            } else {
//                return ['error' => $db->errorInfo()];
                return ['result' => $db->errorInfo()];
            }

        }

    }

    function uploadFile(array $Files)
    {
        $errorFilePost = false;

        if (isset($Files['file'])) {


            $file_name = $Files['file']['name'];
            $file_size = $Files['file']['size'];
            $aExplodeImg = explode('.', $file_name);
            $file_ext = strtolower(end($aExplodeImg));

            $extensions = ["jpeg", "jpg", "png"];

            if (in_array($file_ext, $extensions) === false) {
                $errorFilePost = "Le type de l'image est invalide, seuls les fichiers avec extension '.jpg ou .png' sont acceptés";
            }

            if ($file_size > 2097152) {
                $errorFilePost = 'Le poids de l\'image ne doit pas dépasser le 2 MB';
            }

            $uploaddir = $_SERVER['DOCUMENT_ROOT'] . substr($_SERVER['REQUEST_URI'], 0, 14) . 'images/post/';
            $pathImg = $_SERVER['DOCUMENT_ROOT'] . substr($_SERVER['REQUEST_URI'], 6, 8) . 'images/post/';

            if (strpos($_SERVER['REQUEST_URI'], 'blog-02') !== false) {//DEV
                $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/openclassroom/projet-blog/blog-02/admin/public/images/post/';
                $pathImg = $_SERVER['DOCUMENT_ROOT'] . '/openclassroom/projet-blog/blog-02/public/images/post/';;
            }
            $uploadfile = $uploaddir . basename($Files['file']['name']);


            if (move_uploaded_file($Files['file']['tmp_name'], $uploadfile) === true) {

                copy($pathImg . basename($Files['file']['name']),
                    $pathImg . basename($Files['file']['name']));

            } else {
                $errorFilePost = true;
            }
        }

        return $errorFilePost;
    }

    function updateImgPost(array $Files, $id)
    {
        $db = $this->dbconnect();

        $modifDate = date('Y-m-d H:i:s');
        $postimg = $Files['file']['name'];

        $errorFilePost = $this->uploadFile($Files);

        if ($errorFilePost === false) {
            $req = $db->prepare('UPDATE posts SET  postimg = :postimg, modifDate = :modifDate  WHERE id = :id')
            or die(print_r($db->errorInfo()));

            $req->bindValue(':id', intval($id));
            $req->bindValue(':postimg', $postimg);
            $req->bindValue(':modifDate', $modifDate);

            if ($req->execute()) {
                return true;
            } else {
                return 'Erreur : SQL';
            }
        } else {
            return $errorFilePost;
        }
    }


    function addPost(array $FILES, array $POST)
    {
        $db = $this->dbconnect();

        $post = new Post();
        $post->setAttribute($POST);

        $title = $post->title();
        $content = $post->content();
        $idcategory = $post->idcategory();
        $author = $_SESSION["ident"];

        $createDate = date('Y-m-d H:i:s');
        $postimg = $FILES['file']['name'];

        $errorFilePost = $this->uploadFile($FILES);


        if ($errorFilePost === false) {
            $req = $db->prepare('INSERT INTO posts(title, content, author, postimg, idcategory, createDate) VALUE (:title,:content,:author,:postimg,:idcategory,:createDate)')
            or die(print_r($db->errorInfo()));

            $req->bindParam(':title', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':idcategory', $idcategory);
            $req->bindParam(':author', $author);
            $req->bindParam(':postimg', $postimg);
            $req->bindParam(':createDate', $createDate);


            if ($req->execute()) {
//                return 'Votre produit a été ajouté';
//                return ['valid' => 'Votre article a été ajouté'];
                return true;
            } else {
//                return 'erreur';
                return ['error' => $db->errorInfo()];
            }
        } else {
//            return $errorFilePost;
            return ['error' => $errorFilePost];
        }

        $db->close();

    }

}