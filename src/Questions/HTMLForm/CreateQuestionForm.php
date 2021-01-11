<?php

namespace Anax\Questions\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\UserData;

/**
 * Example of FormModel implementation.
 */
class CreateQuestionForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
            "id" => __CLASS__,
            "legend" => "Ställ fråga",
            ],
            [
            "titel" => [
                "type"        => "text",
                "required" => "required"
            ],

            "fråga" => [
                "type"        => "textarea",
                "required" => "required"
            ],
            
            "taggar" => [
                "type"        => "text",
            ],
    
            "submit" => [
                "type" => "submit",
                "value" => "Skicka",
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
        $title       = $this->form->value("titel");
        $content       = $this->form->value("fråga");
        $tags      = explode(" ", $this->form->value("taggar"));
        $tag = $this->form->value("taggar");
        $db = $this->di->get("dbqb");
        $session = $this->di->get("session");
        $epost = $session->get("user");
        $db->connect();
        $author = $db->select("nick")
                ->from("users")
                ->where("email = ?")
                ->execute([$epost])
                ->fetch();
        $db->connect()
        ->insert("questions", ["title", "content", "author", "tags"])
        ->execute([$title, $content, $author->nick, $tag]);
        $qID = $db->lastInsertId();

        $userData = new UserData();
        $userData->di = $this->di;
        $userData->changeRep(1, $author->nick);

        foreach ($tags as $tag) {
            $db->connect()
            ->insert("tags", ["tag", "question"])
            ->execute([$tag, $qID]);
        }

        $response = $this->di->get("response");

        return $response->redirect("questions");
    }
}
