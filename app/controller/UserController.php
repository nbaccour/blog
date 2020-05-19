<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */


namespace App\controller;


/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class UserController
 * @package App\controller
 */
class UserController extends DefaultController
{


    /**
     * Récupère les données d'un utilisateur
     *
     *
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function getFormUser($id)
    {

        $aDataUser = [];
        $fileName = 'formAddUser.html.twig';
        if ($id !== '') {
            $userManager = new UserManager();
            $user = $userManager->getUser($id);


            $aDataUser = [
                'id'        => $user->id(),
                'lastname'  => $user->lastname(),
                'firstname' => $user->firstname(),
                'email'     => $user->email(),
                'role'      => $user->role(),
                'roleShow'  => ($user->role() === 'user') ? 'Membre' : 'Administrateur',
                'login'     => $user->login(),
                'password'  => $user->password(),
                'title'     => "Modifier les données du membre",
            ];
            $fileName = 'formUpdateUser.html.twig';
        }


        $content = $this->_twig->render($fileName, array_merge([
                'title' => 'Créer un compte',
            ], $aDataUser)
        );
        return $content;
    }


}