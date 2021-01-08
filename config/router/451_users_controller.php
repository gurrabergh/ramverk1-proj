<?php
/**
 * Load the ip controller.
 */
return [
    "routes" => [
        [
            "info" => "users-controller",
            "mount" => "users",
            "handler" => "\Anax\Users\UsersController",
        ],
    ]
];
