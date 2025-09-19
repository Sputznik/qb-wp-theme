<?php

/**
 * BOOTSTRAPS THEME SPECIFIC FUNCTIONALITIES
 */
class QUEERBEAT_THEME {

  public function __construct() {

    add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );  // LOAD ASSETS

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
        if (strpos($hook, 'edit-tags.php') !== false || strpos($hook, 'term.php') !== false || $hook === 'post.php' || $hook === 'post-new.php') {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('boxicons', QUEERBEAT_THEME_URI . '/assets/css/boxicons-rounded.min.css', array(), QUEERBEAT_WP_THEME_VERSION);

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

    add_action('admin_enqueue_scripts', 'mlt_enqueue_admin_scripts');
    function mlt_enqueue_admin_scripts($hook) {
        if ($hook !== 'post.php' && $hook !== 'post-new.php') return;

        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script('mlt-autocomplete', QUEERBEAT_THEME_URI . '/assets/js/mlt-autocomplete.js', array('jquery', 'jquery-ui-autocomplete'), QUEERBEAT_WP_THEME_VERSION);

        global $post;
        wp_localize_script('mlt-autocomplete', 'mltAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('mlt_autocomplete_nonce'),
            'current_post_id' => isset($post->ID) ? $post->ID : 0
        ]);
        wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');

        wp_add_inline_style('jquery-ui-css', '
            .mlt-tag {
                background: #e1ecf4;
                border-radius: 3px;
                padding: 3px 6px;
                margin: 2px 2px 0 0;
                display: inline-block;
            }
            .mlt-tag .mlt-remove-tag {
                color: red;
                margin-left: 6px;
                text-decoration: none;
                cursor: pointer;
                font-weight: bold;
            }
        ');

    }


  }

  function assets() {

    // ENQUEUE STYLES
    wp_enqueue_style('boxicons', QUEERBEAT_THEME_URI . '/assets/css/boxicons-rounded.min.css', array(), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('gtc-core-css', QUEERBEAT_THEME_URI.'/assets/css/main.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION );
    wp_enqueue_style( 'sp-fonts', QUEERBEAT_THEME_URI .'/assets/css/fonts.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION );
    wp_enqueue_style('qb-theme-shortcode', QUEERBEAT_THEME_URI . '/assets/css/qb-theme-shortcode.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('qb-theme-singles', QUEERBEAT_THEME_URI . '/assets/css/qb-single-templates.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
    wp_enqueue_style('qb-theme-typography', QUEERBEAT_THEME_URI . '/assets/css/qb-typography.css', array('sp-core-style'), QUEERBEAT_WP_THEME_VERSION);
  }

}

new QUEERBEAT_THEME;
