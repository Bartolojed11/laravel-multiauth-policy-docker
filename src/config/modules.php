<?php

return [
        'blogs' => [
            // This is what is being saved in the database
            'db' => [
                'name' => 'blogs',
                'active' => true
            ],
            // This will be the one that will be used in cache for checking the users actions
            'permissions' => [
                'read' => 'read',
                'write' => 'write',
                'update' => 'update',
                'delete' => 'delete'
            ]
        ]
];
