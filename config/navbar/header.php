<?php
/**
 * Supply the basis for the navbar as an array.
 */

if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",
     
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
                "url" => "user/profile",
                "title" => "login",
            ],
            [
                "text" => "Om",
                "url" => "om",
                "title" => "Om denna webbplats.",
            ]
        ],
    ];
}
        

return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
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
            "text" => "Logga in",
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
