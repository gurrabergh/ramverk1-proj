<?php
/**
 * Load the user controller.
 */
return [
    "routes" => [
        [
            "info" => "user-controller.",
            "mount" => "user",
            "handler" => "\Anax\User\UserController",
        ],
    ]
];
