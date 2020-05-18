<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


class CommentController extends DefaultController
{

    function getListAllComment(array $aOptions = [])
    {

        $manager = new CommentManager();
        $comments = $manager->getListAllComment($aOptions);


        foreach ($comments as $key => $aData) {

            $aData->createDateFormat = date('d/m/Y', strtotime($aData->createDate()));

        }


        $content = $this->_twig->render('listAllComment.html.twig',
            ['comments' => $comments, 'login' => $_SESSION['login']]);
        return $content;

    }

    function getFormComment($id, $mode)
    {


        $commentManager = new CommentManager();
        $comment = $commentManager->getComment($id);

        $aDataComment = [
            'id'           => $comment->id(),
            'titleComment' => $comment->title,
            'firstname'    => $comment->firstname,
            'comment'      => $comment->comment(),
            'author'       => $comment->author(),
            'mode'         => $mode,
            'title'        => ($mode === 'statut') ? "Modérer le commentaire" : "Valider le commentaire",
            'texteBt'      => ($mode === 'statut') ? "Modérer" : "Valider",
        ];
        $fileName = 'formUpdateComment.html.twig';


        $content = $this->_twig->render($fileName, $aDataComment);
        return $content;
    }


}