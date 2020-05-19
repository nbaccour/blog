<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 09/03/2020
 * Time: 16:02
 */


/**
 * PostManager est une classe pour gérer les articles (ajout, suppression et mise à jour)
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class PostManager
 */
class PostManager extends DataBase
{


    /**
     * récuperer la liste des articles de la table posts sous forme d'un tableau d'objet
     *
     * @return array
     * @throws Exception
     */
    function getListPost()
    {
        $db = $this->dbconnect();

        try {
            $posts = [];
            $req = $db->prepare('SELECT po.id, po.title, po.content, po.author, po.imgPost, po.idcategory, po.createDate, cat.name 
FROM posts AS po 
LEFT JOIN category AS cat ON (cat.id = po.idcategory) ORDER BY po.id DESC');
            $req->execute();
            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                $post = new Post();
                $post->setAttribute($data);
                array_push($posts, $post);
            }
            return $posts;

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * Récupère un article
     *
     *
     * @param int $idPost
     * @return Post
     * @throws Exception
     */
    function getPost(int $idPost)
    {

        $db = $this->dbconnect();
        try {
            $req = $db->prepare('select * from posts WHERE id = :id');
            $req->bindValue(':id', $idPost);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);

            $post = new Post();
            $post->setAttribute($data);
            return $post;

        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }

    }

    /**
     * supprime un article
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    function deletePost(int $id)
    {

        $db = $this->dbconnect();
        try {
            $req = $db->prepare('DELETE FROM posts WHERE id= :id');
            $req->bindValue(':id', $id);
            return $req->execute();
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * met à jour un article
     *
     * @param array $PUT
     * @return bool
     * @throws Exception
     */
    function updatePost(array $PUT)
    {
        $db = $this->dbconnect();
        try {
            $post = new Post();
            $post->setAttribute($PUT);

            $modifDate = date('Y-m-d H:i:s');


            if (intval($post->id()) !== '') {
                $req = $db->prepare('UPDATE posts SET  title = :title, content = :content, modifDate = :modifDate, idcategory = :idcategory WHERE id = :id');

                $req->bindValue(':id', intval($post->id()));
                $req->bindValue(':title', $post->title());
                $req->bindValue(':content', $post->content());
                $req->bindValue(':idcategory', intval($post->idcategory()));
                $req->bindValue(':modifDate', $modifDate);

                return $req->execute();


            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * Telecharge un fichier (image de l'article)
     *
     *
     * @param array $Files
     * @return bool|string
     */
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

    /**
     * Met à jour l'image de l'article
     *
     *
     * @param array $Files
     * @param $id
     * @return bool
     * @throws Exception
     */
    function updateImgPost(array $Files, $id)
    {
        $db = $this->dbconnect();

        $modifDate = date('Y-m-d H:i:s');
        $imgPost = $Files['file']['name'];

        $errorFilePost = $this->uploadFile($Files);

        if ($errorFilePost === false) {
            try {
                $req = $db->prepare('UPDATE posts SET  imgPost = :imgPost, modifDate = :modifDate  WHERE id = :id');

                $req->bindValue(':id', intval($id));
                $req->bindValue(':imgPost', $imgPost);
                $req->bindValue(':modifDate', $modifDate);
                return $req->execute();

            } catch (Exception $e) {

                throw new Exception($e->getMessage());
            }

        } else {
            throw new Exception($errorFilePost);
        }
    }

    /**
     * Ajoute un article
     *
     *
     * @param array $FILES
     * @param array $POST
     * @return bool
     * @throws Exception
     */
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
        $imgPost = $FILES['file']['name'];

        $errorFilePost = $this->uploadFile($FILES);


        if ($errorFilePost === false) {
            try {
                $req = $db->prepare('INSERT INTO posts(title, content, author, imgPost, idcategory, createDate) VALUE (:title,:content,:author,:imgPost,:idcategory,:createDate)');

                $req->bindParam(':title', $title);
                $req->bindParam(':content', $content);
                $req->bindParam(':idcategory', $idcategory);
                $req->bindParam(':author', $author);
                $req->bindParam(':imgPost', $imgPost);
                $req->bindParam(':createDate', $createDate);

                return $req->execute();

            } catch (Exception $e) {

                throw new Exception($e->getMessage());
            }

        } else {

            throw new Exception($errorFilePost);
        }


    }

}