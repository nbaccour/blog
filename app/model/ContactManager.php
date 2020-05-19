<?php
/**
 * Created by PhpStorm.
 * User: msi-n
 * Date: 12/03/2020
 * Time: 11:22
 */

namespace App\model;

/**
 *
 *
 * @author nizar BACCOUR <nbaccour@gmail.com>
 * Class ContactManager
 * @package App\model
 */
class ContactManager extends DataBase
{


    /**
     * envoi un email de contact à l'administrateur du site
     *
     *
     * @param $POST
     * @return bool
     */
    function sendMessage($POST)
    {


        $contact = new Contact();
        $contact->setAttribute($POST);

        $lastname = $contact->lastname();
        $firstname = $contact->firstname();
        $email = $contact->email();
        $content = $contact->content();


        $to = 'contact@oc-blog.com';
        $subject = '[OC-BLOG][CONTACT]';
        $message = 'Nom : ' . $lastname . ' Prénom : ' . $firstname . ' Email : ' . $email . ' Message : ' . $content;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';


        // Envoi
        return mail($to, $subject, $message, implode("\r\n", $headers));

    }
}