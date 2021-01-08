<?php

namespace Anax\Home;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Tags\TM;
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
class HomeController implements ContainerInjectableInterface
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
        $userDB = new UserData();
        $userDB->di = $this->di;
        $data = array();
        $data["users"] = $userDB->getTopProfiles();
        $questionManager = new QM();
        $questionManager->di = $this->di;
        $data["questions"] = $questionManager->getLatestQuestions();
        $tagManager = new TM();
        $tagManager->di = $this->di;
        $data["tags"] = $tagManager->getTopTags();

        $page = $this->di->get("page");
        $page->add('home/index', $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}
