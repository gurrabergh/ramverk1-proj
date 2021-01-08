<?php

/**
 * Configuration file for request service.
 */

return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "active" => true,
            "callback" => function () {
                $obj = new \Anax\Weather\Weather();

                $cfg = $this->get("configuration");

                $config = $cfg->load("weather.php");

                $obj->setApiKey($config);

                return $obj;
            }
        ],
    ],
];
