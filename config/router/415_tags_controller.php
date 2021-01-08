<?php

/**
 * Load the ip controller.
 */

return [
    "routes" => [
        [
            "info" => "tags-controller.",
            "mount" => "tags",
            "handler" => "\Anax\Tags\TagsController",
        ],
    ]
];
