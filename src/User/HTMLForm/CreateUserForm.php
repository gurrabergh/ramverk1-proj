<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
            "id" => __CLASS__,
            "legend" => "Skapa användare",
            ],
            [
            "nick" => [
                "type"        => "text",
                "required" => "required"
            ],
            
            "epost" => [
                "type"        => "email",
                "required" => "required"
            ],

            "lösenord" => [
                "type"        => "password",
                "required" => "required"
            ],

            "biografi" => [
                "type"        => "textarea",
                "required" => "required"
            ],
    
            "submit" => [
                "type" => "submit",
                "value" => "Skapa användare",
                "callback" => [$this, "callbackSubmit"]
            ],
            ]
        );
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
        $email       = $this->form->value("epost");
        $password      = $this->form->value("lösenord");
        $bio      = $this->form->value("biografi");
        $db = $this->di->get("dbqb");
        $password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $db->connect()
            ->insert("users", ["nick", "password", "email", "bio"])
            ->execute([$nick, $password, $email, $bio]);
        } catch (\Throwable $th) {
            $this->form->rememberValues();
            $this->form->addOutput("Epost eller nick existerar redan, försök igen.");
            return false;
        }
        

        $response = $this->di->get("response");

        $response->redirect("user/login");
    }
}
