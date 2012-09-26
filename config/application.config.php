<?php
return array(
    'modules' => array(
        'Application',
        'Sticks',
        'Doctrinemod'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            __DIR__.'/../module',
            __DIR__.'/../vendor',
        ),
    ),
);
