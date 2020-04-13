<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */

//namespace admin\model;

class PostManager extends DataBase
//class PostManager
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

    function updatePost($PUT)
    {
        $db = $this->dbconnect();

        $post = new Post();
        $post->setAttribute($PUT);

        $modifDate = date('Y-m-d H:i:s');
        $errorFilePost = false;

        if ($errorFilePost === false) {
            $req = $db->prepare('UPDATE posts SET  title = :title, content = :content, modifDate = :modifDate, idcategory = :idcategory WHERE id = :id')
            or die(print_r($db->errorInfo()));

//            $req->bindValue(':id', intval($PUT['id']));
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

        } else {
//            return ['error' => $errorFilePost];
            return ['result' => $errorFilePost];
        }

    }

    function updateImgPost($Files, $id)
    {
        $db = $this->dbconnect();

        $modifDate = date('Y-m-d H:i:s');
        $errorFilePost = false;
        $postimg = '';

        if (isset($Files['file'])) {


            $file_name = $Files['file']['name'];
            $file_size = $Files['file']['size'];
            $file_tmp = $Files['file']['tmp_name'];
            $aExplodeImg = explode('.', $file_name);
            $file_ext = strtolower(end($aExplodeImg));

            $extensions = ["jpeg", "jpg", "png"];

            if (in_array($file_ext, $extensions) === false) {
                $errorFilePost = "Le type de l'image est invalide, seuls les fichiers avec extension '.jpg ou .png' sont acceptés";
            }

            if ($file_size > 2097152) {
                $errorFilePost = 'Le poids de l\'image ne doit pas dépasser le 2 MB';
            }

            if (empty($errors) == true) {
//                move_uploaded_file($file_tmp, "../public/images/post/" . $file_name);//blog site
                move_uploaded_file($file_tmp, "public/images/post/" . $file_name);//admin
                $postimg = $file_name;
            }
        }

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

    function addPost()
    {
        $db = $this->dbconnect();

        $title = $_POST["title"];
        $content = $_POST["content"];
        $author = $_SESSION["ident"];
        $idcategory = $_POST["idcategory"];
        $createDate = date('Y-m-d H:i:s');
        $errorFilePost = false;

        if (isset($_FILES['postimg'])) {


            $file_name = $_FILES['postimg']['name'];
            $file_size = $_FILES['postimg']['size'];
            $file_tmp = $_FILES['postimg']['tmp_name'];
//            $file_type = $_FILES['postimg']['type'];
            $aExplodeImg = explode('.', $_FILES['postimg']['name']);
            $file_ext = strtolower(end($aExplodeImg));

            $extensions = ["jpeg", "jpg", "png"];

            if (in_array($file_ext, $extensions) === false) {
                $errorFilePost = "Le type de l'image est invalide, seuls les fichiers avec extension '.jpg ou .png' sont acceptés";
            }

            if ($file_size > 2097152) {
                $errorFilePost = 'Le poids de l\'image ne doit pas dépasser le 2 MB';
            }

            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "../public/images/post/" . $file_name);//blog site
                move_uploaded_file($file_tmp, "public/images/post/" . $file_name);//admin
                $postimg = $file_name;
            }
        }
        if ($errorFilePost === false) {
            $req = $db->prepare('INSERT INTO posts(title, content, author, postimg, idcategory, createDate) VALUE (:title,:content,:author,:postimg,:idcategory,:createDate)')
            or die(print_r($db->errorInfo()));

            $req->bindParam(':title', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':author', $author);
            $req->bindParam(':postimg', $postimg);
            $req->bindParam(':idcategory', $idcategory);
            $req->bindParam(':createDate', $createDate);


            if ($req->execute()) {
//                return 'Votre produit a été ajouté';
                return ['valid' => 'Votre article a été ajouté'];
            } else {
//                return 'erreur';
                return ['error' => $db->errorInfo()];
            }
        } else {
//            return $errorFilePost;
            return ['error' => $errorFilePost];
        }

//close connexion
    }
}