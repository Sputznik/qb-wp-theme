<?php

    /*  CONSTANTS */
    if( !defined( 'QUEERBEAT_WP_THEME_VERSION' ) ) {
        define( 'QUEERBEAT_WP_THEME_VERSION', time() );
    }
    
    if( !defined( 'QUEERBEAT_THEME_URI' ) ) {
        define( 'QUEERBEAT_THEME_URI', get_stylesheet_directory_uri() );
    }
    
    if( !defined( 'QUEERBEAT_THEME_PATH' ) ) {
        define( 'QUEERBEAT_THEME_PATH', get_stylesheet_directory() );
    }

    $inc_files = array(
        'lib/class-queerbeat-theme.php',
        'lib/customize-theme/main.php',
        'lib/qb-orbit-cf.php',
        'lib/qb-category-cf.php',
        'lib/shortcodes/qb-themes.php',
        'lib/qb-user-cf.php',
    );

    foreach ($inc_files as $inc_file) {
        require_once $inc_file;
    }














