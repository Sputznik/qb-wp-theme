<?php
add_action('customize_register', function( $wp_customize ){

  global $sp_customize;

  $templates_arr = apply_filters( 'sp_single_template_options', array(
    'archive1' => 'Three Grid',
    'archive2' => 'Two Grid',
  ) );

  $args = array( 'public' => true,);
  $post_types = get_post_types( $args );

  foreach ( $post_types as $slug => $value ) {
      if( !( in_array( $value, array( 'orbit-fep', 'attachment', 'page' ) ) ) ){

        $key = "[archive_".$value."_template]";
        $label = "Template Type for $value";

        $sp_customize->dropdown( $wp_customize, 'sp_archive_section', $key, $label, 'archive1', $templates_arr );
      }
  }

},20);

// add_filter('template_include', 'load_custom_archive_template');
// function load_custom_archive_template($template) {
//     if (is_post_type_archive()) {
//         $post_type = get_post_type();

//         $options = get_option('sp_theme');
//         $template_key = isset($options["archive_{$post_type}_template"]) ? $options["archive_{$post_type}_template"] : 'archive1';

//         if ($template_key === 'archive2') {
//             $custom_template = get_stylesheet_directory() . 'partials/archives/archive2.php';

//             if (file_exists($custom_template)) {
//                 return $custom_template;
//             }
//         }
//     }

//     return $template;
// }

