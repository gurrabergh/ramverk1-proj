<?php

namespace Anax\Questions;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\HTMLForm\CreateQuestionForm;
use Anax\Questions\QM;
use Anax\User\UserData;

class QuestionsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : object
    {
        $title = "Frågor";
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

    public function voteActionPost() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $user = $session->get("nick");
        if (empty($user)) {
            return $response->redirect("user/login");
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

        return $response->redirect("questions/view?question={$qid}#{$type[0]}{$id}");
    }

    public function answerActionPost() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        $email = $session->get("user");
        if (empty($user)) {
            return $response->redirect("user/login");
        }

        $questionManager = new QM();
        $userData = new UserData;
        $questionManager->di = $this->di;
        $userData->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("id");
        $content = $request->getPost("content");

        $last = $questionManager->answer($id, $user, $content, $email);
        $userData->changeRep(1, $user);

        return $response->redirect("questions/view?question={$id}#a{$last}");
    }

    public function commentActionPost() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        $email = $session->get("user");
        if (empty($user)) {
            return $response->redirect("user/login");
        }

        $questionManager = new QM();
        $userData = new UserData;
        $questionManager->di = $this->di;
        $userData->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("id");
        $question = $request->getPost("question");
        $content = $request->getPost("content");

        $last = $questionManager->comment($id, $user, $content, $question, $email);
        $userData->changeRep(1, $user);

        return $response->redirect("questions/view?question={$question}#c{$last}");
    }

    public function acceptActionPost() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $user = $session->get("nick");
        if (empty($user)) {
            return $response->redirect("user/login");
        }

        $questionManager = new QM();
        $questionManager->di = $this->di;
        $request = $this->di->get("request");
        $id = $request->getPost("aid");
        $question = $request->getPost("qid");

        $questionManager->acceptAnswer($id, $question);

        return $response->redirect("questions/view?question={$question}#a{$id}");
    }
}
