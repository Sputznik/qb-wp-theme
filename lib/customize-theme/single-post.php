<?php
add_action('customize_register', function( $wp_customize ){

  global $sp_customize;

  $sp_customize->section( $wp_customize, 'sp_theme_panel', 'sp_single_post_section', 'Single Post Section', 'Change Template For Single Post');

 /** SINGLE POST TYPE TEMPLATES */
  $templates_arr = apply_filters( 'sp_single_template_options', array(
    'single1' => 'Default',
    'single2' => 'Overlay featured image',
    'single3' => 'Blog Post',
    'single4' => 'SiteOrigin Template',
    'single5'	=> 'Resource',
    'single6'	=> 'Medium',
    'single7' => 'Template with Download Button',
    'single8' => 'QueerBeat Single Template', // Added by child theme
  ) );

  // For Post Types
  $args = array( 'public' => true,);
  $post_types = get_post_types( $args );
  foreach ( $post_types as $slug => $value ) {
      if( !( in_array( $value, array( 'orbit-fep', 'attachment', 'page' ) ) ) ){

        $key = "[single_".$value."_template]";
        $label = "Template Type for $value";

        $sp_customize->dropdown( $wp_customize, 'sp_single_post_section', $key, $label, 'single1', $templates_arr );
      }
  }

},20);

// Add meta box for single post template selection
add_action('add_meta_boxes', function() {
    add_meta_box(
        'qb_single_template',
        __('Single Post Template', 'qb-wp-theme'),
        function($post) {
            $templates = array(
                'single8' => 'Title below Featured Image',
                'single9' => 'Title above Featured Image',
            );
            $selected = get_post_meta($post->ID, '_qb_single_template', true);
            echo '<select name="qb_single_template" id="qb_single_template">';
            foreach ($templates as $key => $label) {
                printf('<option value="%s" %s>%s</option>', esc_attr($key), selected($selected, $key, false), esc_html($label));
            }
            echo '</select>';
        },
        'post',
        'side',
        'default'
    );
});

// Save selected template
add_action('save_post', function($post_id) {
    if (isset($_POST['qb_single_template'])) {
        $template = sanitize_text_field($_POST['qb_single_template']);
        if ($template) {
            update_post_meta($post_id, '_qb_single_template', $template);
        } else {
            delete_post_meta($post_id, '_qb_single_template');
        }
    }
});

