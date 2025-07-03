<?php

/**
 * BOOTSTRAPS THEME SPECIFIC FUNCTIONALITIES
 */
class QUEERBEAT_THEME {

  public function __construct() {

    add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );  // LOAD ASSETS
    add_filter('the_posts', array( $this, 'show_scheduled_posts' ) ); // SHOW SCHEDULED POSTS IN SINGLE.PHP

    /* ADD SOW FROM THE THEME */
    add_action('siteorigin_widgets_widget_folders', function( $folders ){
      $folders[] = QUEERBEAT_THEME_PATH.'/so-widgets/';
      return $folders;
    } );


    function add_user_id_column($columns) {
        $columns['user_id'] = 'User ID';
        return $columns;
    }
    add_filter('manage_users_columns', 'add_user_id_column');

    function show_user_id_column_content($value, $column_name, $user_id) {
        if ($column_name === 'user_id') {
            return $user_id;
        }
        return $value;
    }
    add_action('manage_users_custom_column', 'show_user_id_column_content', 10, 3);

    function make_user_id_column_sortable($columns) {
        $columns['user_id'] = 'ID';
        return $columns;
    }
    add_filter('manage_users_sortable_columns', 'make_user_id_column_sortable');

    
    // Load scripts (color picker + live icon preview)
    add_action('admin_enqueue_scripts', function ($hook) {
        if (strpos($hook, 'edit-tags.php') !== false || strpos($hook, 'term.php') !== false) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('boxicons', 'https://pro.boxicons.com/fonts/3.0.1/basic/rounded/400/boxicons-rounded.min.css?sig=7128fd87b9be0e56ca3bc7c681f7f01f6da119ff687204ab230f0ed33d3f1304');

            wp_add_inline_script('wp-color-picker', "
                jQuery(document).ready(function($){
                    $('.color-picker').wpColorPicker();
                    $('#category_icon').on('input', function(){
                        $('#bx-icon-preview').attr('class', $(this).val());
                    });
                });
            ");
        }
    });

    // Add custom post type support for scheduled posts
    add_filter('pre_get_posts', function($query) {
      if (is_single() && $query->is_main_query()) {
        $query->set('post_status', array('publish', 'future'));
      }
    });

    // Register archive Inline Widget area
    add_action('widgets_init', function() {
        register_sidebar([
            'name'          => __('Archive Inline Widget', 'qb-wp-theme'),
            'id'            => 'archive-inline-widget',
            'description'   => __('Widget area for inline support in archive article loop.', 'qb-wp-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s archive-inline-widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    });

  }

  function assets() {

    // ENQUEUE STYLES
    wp_enqueue_style('gtc-core-css', QUEERBEAT_THEME_URI.'/assets/css/main.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION );
    wp_enqueue_style( 'sp-fonts', QUEERBEAT_THEME_URI .'/assets/css/fonts.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION );
    wp_enqueue_style('qb-theme-shortcode', QUEERBEAT_THEME_URI . '/assets/css/qb-theme-shortcode.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('qb-theme-singles', QUEERBEAT_THEME_URI . '/assets/css/qb-single-templates.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('boxicons', 'https://pro.boxicons.com/fonts/3.0.1/basic/rounded/400/boxicons-rounded.min.css?sig=7128fd87b9be0e56ca3bc7c681f7f01f6da119ff687204ab230f0ed33d3f1304', array(), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('qb-theme-typography', QUEERBEAT_THEME_URI . '/assets/css/qb-typography.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
  }

  function show_scheduled_posts( $posts ){
    global $wp_query, $wpdb;

    if( is_single() && $wp_query->post_count == 0 ){
      $posts = $wpdb->get_results( $wp_query->request );
    }

    return $posts;
  }

}

new QUEERBEAT_THEME;
