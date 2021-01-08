<?php

/**
 * Load the ip controller.
 */

return [
    "routes" => [
        [
            "info" => "question-controller",
            "mount" => "questions",
            "handler" => "\Anax\Questions\QuestionsController",
        ],
    ]
];
