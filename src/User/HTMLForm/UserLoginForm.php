<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Logga in för att få åtkomst."
            ],
            [
                "epost" => [
                    "type"        => "email",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],
                        
                "lösenord" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
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
        $acronym       = $this->form->value("epost");
        $password      = $this->form->value("lösenord");

        // Try to login
        $db = $this->di->get("dbqb");
        $db->connect();
        $user = $db->select("*")
                ->from("Users")
                ->where("email = ?")
                ->execute([$acronym])
                ->fetch();

        // $user is null if user is not found
        if (!$user || !password_verify($password, $user->password)) {
            $this->form->rememberValues();
            $this->form->addOutput("Epost eller lösenord matchade inte.");
            return false;
        }

        $session = $this->di->get("session");
        $session->set("user", $acronym);
        $session->set("nick", $user->nick);
        $_SESSION["logged"] = true;
        $response = $this->di->get("response");
        $response->redirect("user/profile");
        return true;
    }
}
