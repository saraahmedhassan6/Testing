<?php

return [
    /* You can add your own middleware here */
    'middleware' => [
        'auth', // Laravel's built-in authentication middleware
        'custom.middleware', // Your custom middleware
    ],

    /* You can set your own table prefix here */
    'table_prefix' => 'myapp_', // Use 'myapp_' as the prefix for table names

    /* You can set your own table names */
    'table_name_menus' => 'my_menus', // Use 'my_menus' as the menu table name
    'table_name_items' => 'my_menu_items', // Use 'my_menu_items' as the menu items table name

    /* You can set your route path */
    'route_path' => 'my-custom-menu-route', // Use 'my-custom-menu-route' as the route path

    /* Here you can make menu items visible to specific roles */
    'use_roles' => true, // Enable roles (permissions) on menu items

    /* If use_roles = true above, then you must set the table name, primary key, and title field to get roles details */
    'roles_table' => 'roles', // Use 'roles' as the roles table name
    'roles_pk' => 'id', // Set the primary key of the roles table
    'roles_title_field' => 'name', // Set the field that contains the role display name in the roles table
];
