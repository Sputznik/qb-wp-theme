<?php
add_action('customize_register', function( $wp_customize ){

  global $sp_customize;

  $sp_customize->section( $wp_customize, 'sp_theme_panel', 'sp_taxonomy_section', 'Taxonomy Section', 'Change Template For Taxonomies');

  /** POST LIST TEMPLATES */
  $templates_arr = apply_filters( 'sp_single_template_options', array(
    'tax1' => 'Three Grid',
    'tax2' => 'Row Based Layout',
    'tax3' => 'Two Grid',
    // 'single3' => 'Blog Post',
    //'template4'	=> 'Template 4'
  ) );

  //$sp_customize->dropdown( $wp_customize, 'sp_single_post_section', '[single_template]', 'Template Type', 'template1', $templates_arr);

  // For Post Types
  // $args = array( 'public' => true,);
  $taxonomies = get_taxonomies();
  // echo "<pre>";
  // print_r( $taxonomies );
  // echo "<pre>";
  foreach ( $taxonomies as $slug => $value ) {
      if( !( in_array( $value, array( 'nav_menu', 'link_category', 'post_format', 'orbit_taxonomy' ) ) ) ){

        $key = "[tax_".$value."_template]";
        $label = "Template Type for $value";

        $sp_customize->dropdown( $wp_customize, 'sp_taxonomy_section', $key, $label, 'tax1', $templates_arr );
      }
  }

},20);
