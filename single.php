<?php get_header(); ?>
<?php
    global $sp_customize;

    $post_type = get_post_type();

    // Check for per-post template selection
    $post_template = get_post_meta(get_the_ID(), '_qb_single_template', true);
    if ($post_template) {
        $template_name = $post_template;
    } else {
        $template_name = $sp_customize->get_single_template( $post_type );
    }
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
?>
<?php get_footer(); ?>
