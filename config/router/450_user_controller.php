<?php
/**
 * Load the ip controller.
 */
return [
    "routes" => [
        [
            "info" => "users-controller.",
            "mount" => "user",
            "handler" => "\Anax\User\UserController",
        ],
    ]
];
