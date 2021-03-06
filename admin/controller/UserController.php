<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 15:26
 */

/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class UserController
 */
class UserController extends DefaultController
{


    /**
     * vérifie les identifiants de connexion d'un utilisateur
     *
     *
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function checkUser()
    {
        $manager = new UserManager();
        $checkConnect = $manager->checkUser();

        if (is_array($checkConnect)) {

            $aConnectagent = ['Administrator', 'Moderator'];

            if (in_array($checkConnect['role'], $aConnectagent) === true) {

                $_SESSION['login'] = true;
                $_SESSION['ident'] = $checkConnect['login'];
                $_SESSION['lastnameUser'] = $checkConnect['lastname'];
                $_SESSION['firstnameUser'] = $checkConnect['firstname'];
                $_SESSION['mailUser'] = $checkConnect['email'];

                header("Refresh: 1; URL=index.php");

                $manager = new PostManager();
                $posts = $manager->getListPost();

                $content = $this->_twig->render('listPost.html.twig', ['posts' => $posts]);

                return $content;
            } else {
                $content = $this->_twig->render('formConnect.html.twig', [
                    'title' => 'Admin',
                    'error' => 'Identifiant ou mot de passe invalide',
                ]);

                return $content;
            }

        } else {
            $content = $this->_twig->render('formConnect.html.twig', ['title' => 'Admin', 'error' => $checkConnect]);

            return $content;
        }

    }


    /**
     * Récupère les données d'un utilisateur
     *
     * @param int $id
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function getFormUser(int $id)
    {

        $aDataUser = [];
        $fileName = 'formAddUser.html.twig';
        if ($id !== 0) {
            $userManager = new UserManager();
            $user = $userManager->getUser((int)$id);


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
                'title' => 'Ajouter un utilisateur',
            ], $aDataUser)
        );
        return $content;
    }

    /**
     * Récupère les données des utilisateurs
     *
     *
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function getListUser()
    {

        $manager = new UserManager();
        $users = $manager->getListUser();


        foreach ($users as $key => $aData) {

            $aData->createDateFormat = date('d/m/Y', strtotime($aData->createDate()));
            $aData->roleShow = ($aData->role() === 'user') ? 'Membre' : 'Administrateur';

        }


        $content = $this->_twig->render('listUser.html.twig', ['users' => $users, 'login' => $_SESSION['login']]);
        return $content;

    }


}