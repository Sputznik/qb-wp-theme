<?php
add_action('customize_register', function( $wp_customize ){

  global $sp_customize;

  $sp_customize->section( $wp_customize, 'sp_theme_panel', 'sp_author_section', 'Author Section', 'Change Template For Authors');

  /** POST LIST TEMPLATES */
  $templates_arr = apply_filters( 'sp_single_template_options', array(
    'tax1' => 'Three Grid',
    'tax2' => 'Row Based Layout',
    // 'single3' => 'Blog Post',
    //'template4'	=> 'Template 4'
  ) );

  $sp_customize->dropdown( $wp_customize, 'sp_author_section', '[author_template]', 'Template Type', 'tax1', $templates_arr );



});
