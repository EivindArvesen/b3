<?php

return [
    // Basic author information
    'site-name' => 'Site Name',
    'user' => 'John Doe',
    'email' => 'email@provider.com',
    'theme' => 'default',
    'status' => 'live', // live, maintenance, unavailable, landing, prelaunch
    'debug' => False, // echo DEBUG pages + debug info on failure
    'date-format' => 'MDY', // some combination of DMY
    'backend' => 'db',
    'cache-age' => 24, // max cache age in hours
    // Front page
    'header' => 'Hello, world',
    'lead' => 'This is a lead',
    'text' => ['And here is some text.'],
    // Blog sidebar
    'about' => [
        "This appears in the blog sidebar.",
        "So does this."
    ],
    // Meta description
    'description' => "A site built using B3",
    'keywords' => [
        'Website',
        'Blog'
    ],
    // Social media accounts (usernames for links)
    'github' => '',
    'twitter' => '',
    'facebook' => ''
];
