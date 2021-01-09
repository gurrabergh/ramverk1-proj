<?php

namespace Anax\Questions;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;

/**
 * Example test class.
 */
class QuestionsControllerTest extends TestCase
{
    private $controller;
    private $di;
     /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new QuestionsController();
        $this->controller->setDI($this->di);
        $_SESSION["test"] = "test";
        //$this->controller->initialize();
    }

    //
    // /**
    //  * testing index method
    //  */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testAskAction()
    {
        $res = $this->controller->askAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testViewAction()
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $request->setGet("question", "1");
        $session->set("nick", "test");
        $res = $this->controller->viewAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testVoteActionFail()
    {
        $session = $this->di->get("session");
        $session->set("nick", "");
        $res = $this->controller->voteActionPost();
        $this->assertEquals(true, $res);
    }

    public function testVoteAction()
    {
        $types = ["questions", "comments", "answers"];

        foreach ($types as $type) {
            $request = $this->di->get("request");
            $session = $this->di->get("session");
            $request->setPost("id", "1");
            $request->setPost("qid", "1");
            $request->setPost("author", "test");
            $request->setPost("type", $type);
            $request->setPost("action", "up");
            $session->set("nick", "test2");
            $res = $this->controller->voteActionPost();
            $this->assertEquals(true, $res);
            $request->setPost("action", "down");
            $res = $this->controller->voteActionPost();
            $this->assertEquals(true, $res);
        }
    }

    
    public function testAnswerActionFail()
    {
        $session = $this->di->get("session");
        $session->set("nick", "");
        $res = $this->controller->answerActionPost();
        $this->assertEquals(true, $res);
    }

    public function testAnswerAction()
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $request->setPost("id", "1");
        $request->setPost("content", "test");
        $session->set("nick", "test");
        $res = $this->controller->answerActionPost();
        $this->assertEquals(true, $res);
    }

    public function testCommentActionFail()
    {
        $session = $this->di->get("session");
        $session->set("nick", "");
        $res = $this->controller->commentActionPost();
        $this->assertEquals(true, $res);
    }

    public function testCommentAction()
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $request->setPost("id", "1");
        $request->setPost("question", "1");
        $request->setPost("content", "test");
        $session->set("nick", "test");
        $res = $this->controller->commentActionPost();
        $this->assertEquals(true, $res);
    }

    public function testAcceptActionFail()
    {
        $session = $this->di->get("session");
        $session->set("nick", "");
        $res = $this->controller->acceptActionPost();
        $this->assertEquals(true, $res);
    }

    public function testAcceptAction()
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $request->setPost("aid", "1");
        $request->setPost("qid", "1");
        $session->set("nick", "test");
        $res = $this->controller->acceptActionPost();
        $this->assertEquals(true, $res);
    }
}
