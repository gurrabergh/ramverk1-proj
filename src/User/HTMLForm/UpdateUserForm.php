<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\UserData;

/**
 * Example of FormModel implementation.
 */
class UpdateUserForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $user = $this->getProfileDetails();
        $this->form->create(
            [
            "id" => __CLASS__,
            "legend" => "Skapa användare",
            ],
            [
            "nick" => [
                "type"        => "text",
                "required" => "required",
                "readonly" => true,
                "value" => $user->nick,

            ],
            
            "epost" => [
                "type"        => "email",
                "required" => "required",
                "readonly" => true,
                "value" => $user->email,
            ],

            "lösenord" => [
                "type"        => "password",
                "required" => "required",
            ],

            "biografi" => [
                "type"        => "text",
                "required" => "required",
                "value" => $user->bio,
            ],
    
            "submit" => [
                "type" => "submit",
                "value" => "Redigera användare",
                "callback" => [$this, "callbackSubmit"]
            ],
            ]
        );
    }

    public function getProfileDetails() : object
    {
        $session = $this->di->get("session");
        $userDB = new UserData();
        $userDB->di = $this->di;
        $res = $userDB->getProfile($session->get("user"));
        return $res;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $nick       = $this->form->value("nick");
        $password      = $this->form->value("lösenord");
        $bio      = $this->form->value("biografi");
        $db = $this->di->get("dbqb");
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ?, bio = ?  WHERE nick = ?;";
        $db->connect();
        $db->execute($sql, [$password, $bio, $nick]);
        $response = $this->di->get("response");

        $response->redirect("user/profile");
        return true;
    }
}
