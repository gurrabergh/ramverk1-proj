<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Start",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Frågor",
            "url" => "questions",
            "title" => "Frågor",
        ],
        [
            "text" => "Taggar",
            "url" => "tags",
            "title" => "taggar",
        ],
        [
            "text" => "Användare",
            "url" => "user/all",
            "title" => "Användare",
        ],
        [
            "text" => "Profil",
            "url" => "user/login",
            "title" => "login",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ]
    ],
];
