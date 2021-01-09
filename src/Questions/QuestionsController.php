<?php

namespace Anax\Questions;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\HTMLForm\CreateQuestionForm;
use Anax\Questions\QM;
use Anax\User\UserData;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class QuestionsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    // /**
    //  * This is the index method action, it handles:
    //  * ANY METHOD mountpoint
    //  * ANY METHOD mountpoint/
    //  * ANY METHOD mountpoint/index
    //  *
    //  * @return string
    //  */
    // public function initAction() : object
    // {
    //     // init session for game start

    //     $this->app->session->set("game", new DiceGame());

    //     return $this->app->response->redirect("diceC/play");
    // }

    // /**
    //  * This is the index method action, it handles:
    //  * ANY METHOD mountpoint
    //  * ANY METHOD mountpoint/
    //  * ANY METHOD mountpoint/index
    //  *
    //  * @return string
    //  */
    public function indexAction() : object
    {
        $title = "Start";
        $questionManager = new QM();
        $questionManager->di = $this->di;
        $data = array();
        $data["questions"] = $questionManager->getQuestions();
        $page = $this->di->get("page");
        $page->add('questions/index', $data);

        return $page->render([
            "title" => $title
        ]);
    }

    public function askAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di);
        $form->check();

        $page->add("questions/ask", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa",
        ]);
    }

    public function viewAction() : object
    {
        $title = "Fråga";
        $questionManager = new QM();
        $questionManager->di = $this->di;
        $request = $this->di->get("request");
        $id = htmlEntities($request->getGet("question"), ENT_QUOTES);
        $order = htmlEntities($request->getGet("order", "rating"), ENT_QUOTES);
        $session = $this->di->get("session");
        $user = $session->get("nick");
        $data = array();
        $data["order"] = $order;
        $data["question"] = $questionManager->getQuestion($id);
        $data["answers"] = $questionManager->getAnswers($id, $order);
        $data["comments"] = $questionManager->getComments($id);
        $data["user"] = $user;

        $page = $this->di->get("page");
        $page->add('questions/view', $data);

        return $page->render([
            "title" => $title
        ]);
    }

    public function voteActionPost()
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $user = $session->get("nick");
        if (empty($user)) {
            $response->redirect("user/login");
            return null;
        }
        $questionManager = new QM();
        $userData = new UserData;
        $questionManager->di = $this->di;
        $userData->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("id");
        $qid = $request->getPost("qid");
        $author = $request->getPost("author");
        $type = $request->getPost("type");
        $action = $request->getPost("action");
        if ($action === "up") {
            $score = 1;
        } else {
            $score = -1;
        }

        $questionManager->updateScore($type, $id, $score);
        $userData->changeRep($score, $author);
        $userData->changeRep(1, $user);
        $userData->castVote($user);

        $response->redirect("questions/view?question={$qid}#{$type[0]}{$id}");
        return null;
    }

    public function answerActionPost()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        if (empty($user)) {
            $response->redirect("user/login");
            return null;
        }

        $questionManager = new QM();
        $userData = new UserData;
        $questionManager->di = $this->di;
        $userData->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("id");
        $content = $request->getPost("content");

        $last = $questionManager->answer($id, $user, $content);
        $userData->changeRep(1, $user);

        $response->redirect("questions/view?question={$id}#a{$last}");
        return null;
    }

    public function commentActionPost()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        if (empty($user)) {
            $response->redirect("user/login");
            return null;
        }

        $questionManager = new QM();
        $userData = new UserData;
        $questionManager->di = $this->di;
        $userData->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("id");
        $question = $request->getPost("question");
        $content = $request->getPost("content");

        $last = $questionManager->comment($id, $user, $content, $question);
        $userData->changeRep(1, $user);

        $response->redirect("questions/view?question={$question}#c{$last}");
        return null;
    }

    public function acceptActionPost()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        if (empty($user)) {
            $response->redirect("user/login");
            return null;
        }

        $questionManager = new QM();
        $questionManager->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("aid");
        $question = $request->getPost("qid");

        $questionManager->acceptAnswer($id, $question);

        $response->redirect("questions/view?question={$question}#a{$id}");
        return null;
    }
}
