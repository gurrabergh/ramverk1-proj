<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Tags\TM;

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
class TagsController implements ContainerInjectableInterface
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
        $title = "Taggar";
        $tagManager = new TM();
        $tagManager->di = $this->di;
        $data = array();
        $data["tags"] = $tagManager->getTags();
        $page = $this->di->get("page");
        $page->add('tags/index', $data);

        return $page->render([
            "title" => $title
        ]);
    }

    public function viewAction() : object
    {
        $title = "Frågor";
        $request = $this->di->get("request");
        $tagManager = new TM();
        $tagManager->di = $this->di;
        $tag = htmlEntities($request->getGet("tag"), ENT_QUOTES);
        $data = array();
        $data["questions"] = $tagManager->getQuestions($tag);
        $data["tag"] = $tag;
        $page = $this->di->get("page");
        $page->add('tags/view', $data);

        return $page->render([
            "title" => $title
        ]);
    }
}
