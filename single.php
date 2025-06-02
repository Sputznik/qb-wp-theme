<?php get_header(); ?>
<?php
    global $sp_customize;

    $post_type = get_post_type();
    $template_name = $sp_customize->get_single_template( $post_type );
    $template_path = 'partials/singles/' . $template_name . '.php';

    // Use locate_template to support child theme templates
    $single_template = locate_template( $template_path );

    // Allow filters to override
    $single_template = apply_filters( 'sp_' . $template_name . '_template', $single_template );

    // Load template if found
    if ( $single_template ) {
        require_once( $single_template );
    } else {
        echo '<p>Template not found: ' . esc_html( $template_path ) . '</p>';
    }

    // Optional widget area
    if ( is_active_sidebar( 'single-post-footer' ) ) {
        dynamic_sidebar( 'single-post-footer' );
    }
?>
<?php get_footer(); ?>
