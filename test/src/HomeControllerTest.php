<?php

namespace Anax\Home;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;

/**
 * Example test class.
 */
class HomeControllerTest extends TestCase
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
        $this->controller = new HomeController();
        $this->controller->setDI($this->di);
        $request = $this->di->get("request");
        $request->setServer("SERVER_NAME", "test");
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
}
