<?php

namespace Anax\User;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;

/**
 * Example test class.
 */
class UserControllerTest extends TestCase
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
        $this->controller = new UserController();
        $this->controller->setDI($this->di);
        $_SESSION["test"] = "test";
        //$this->controller->initialize();
    }

    public function testAllAction()
    {
        $res = $this->controller->allActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testViewAction()
    {
        $request = $this->di->get("request");
        $request->setGet("user", "test");
        $res = $this->controller->viewAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testLoginAction()
    {
        $res = $this->controller->loginAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testCreateAction()
    {
        $res = $this->controller->createAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testProfileAction()
    {
        $session = $this->di->get("session");
        $session->set("user", "test@test.com");
        $res = $this->controller->profileAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testEditAction()
    {
        $res = $this->controller->editAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
    public function testLogoutAction()
    {
        $res = $this->controller->logoutActionGet();
        $this->assertEquals(true, $res);
    }
}
