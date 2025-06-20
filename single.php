<?php get_header(); ?>
<?php
    // Only use per-post template selection
    $post_template = get_post_meta(get_the_ID(), '_qb_single_template', true);
    $template_name = $post_template ? $post_template : 'single8'; // fallback to a default if not set
    $template_path = 'partials/singles/' . $template_name . '.php';

    // Use locate_template to support child theme templates
    $single_template = locate_template( $template_path );

    // Load template if found
    if ( $single_template ) {
        require_once( $single_template );
    } else {
        echo '<p>Template not found: ' . esc_html( $template_path ) . '</p>';
    }
?>
<?php get_footer(); ?>
