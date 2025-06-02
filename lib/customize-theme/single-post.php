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

