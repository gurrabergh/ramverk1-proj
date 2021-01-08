<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\UpdateUserForm;
use Anax\User\UserData;
use Anax\Questions\QM;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function allActionGet() : object
    {
        $title = "Start";
        $useranagerM = new UserData();
        $useranagerM->di = $this->di;
        $data = array();
        $data["users"] = $useranagerM->getUsers();
        $page = $this->di->get("page");
        $page->add('user/all', $data);

        return $page->render([
            "title" => $title
        ]);
    }

    public function viewAction() : object
    {
        $request = $this->di->get("request");
        $nick = htmlEntities($request->getGet("user"), ENT_QUOTES);
        $page = $this->di->get("page");
        $userDB = new UserData();
        $questionManager = new QM();
        $userDB->di = $this->di;
        $questionManager->di = $this->di;
        $data = array();
        $data["user"] = $userDB->getUser($nick);
        $data["questions"] = $questionManager->getUserQuestions($nick);
        $data["answers"] = $questionManager->getUserAnswers($nick);
        $data["comments"] = $questionManager->getUserComments($nick);
        $page->add("user/view", $data);

        return $page->render([
            "title" => "Profil",
        ]);
    }

    public function loginAction()
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $response = $this->di->get("response");

            $response->redirect("user/profile");
            return null;
        }
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("user/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }

    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa",
        ]);
    }

    public function profileAction() : object
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $userDB = new UserData();
        $userDB->di = $this->di;
        $page->add("user/index", [
            "user" => $userDB->getProfile($session->get("user")),
        ]);

        return $page->render([
            "title" => "Profil",
        ]);
    }

    public function editAction() : object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Redigera",
        ]);
    }

    public function logoutAction()
    {

        $session = $this->di->get("session");

        $session->destroy();
        $response = $this->di->get("response");

        $response->redirect("user/login");
        return null;
    }
}
