<?php

/* Add custom taxonomy: Formats */
add_filter( 'orbit_taxonomy_vars', function( $orbit_tax ) {

  $orbit_tax['formats'] = array(
    'label'         => 'Formats',
    'slug'          => 'formats',
    'hierarchical'  => true,
    'post_types'    => array( 'post' ),
    'input_type'    => 'radio'
  );

  return $orbit_tax;
});

/* Add custom fields (meta boxes) for posts */
add_filter('orbit_meta_box_vars', function ($meta_box) {
    $user_options = [];
    foreach (get_users() as $user) {
        $user_options[$user->ID] = $user->display_name;
    }

     $meta_box['post'][] = array(
        'id'     => 'post-language-urls',
        'title'  => 'Language URLs',
        'fields' => array(
          'hindi_post_url' => array(
            'type' => 'text',
            'text' => 'Hindi Post URL'
          ),
          'english_post_url' => array(
            'type' => 'text',
            'text' => 'English Post URL'
          )
        )
      );

    $meta_box['post'][] = array(
        'id'     => 'post-content-warning',
        'title'  => 'Content Warning',
        'fields' => array(
          'post_content_warning' => array(
           'type'  => 'textarea',
            'text'  => 'Warning',
          )
        )
      );

    return $meta_box;
});


add_action('add_meta_boxes', function() {
    remove_meta_box('formatsdiv', 'post', 'side');

    add_meta_box(
        'formats_radio',
        __('Formats', 'textdomain'),
        function($post) {
            $taxonomy = 'formats';
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
            $selected = wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);
            $current = (!empty($selected) && !is_wp_error($selected)) ? $selected[0] : 0;

            echo '<div style="margin-top: 5px;">';
            foreach ($terms as $term) {
                printf(
                    "<label style='display:block; margin-bottom:4px;'>
                        <input type='radio' name='tax_input[%s]' value='%d' %s> %s
                    </label>",
                    esc_attr($taxonomy),
                    esc_attr($term->term_id),
                    checked($current, $term->term_id, false),
                    esc_html($term->name)
                );
            }
            echo '</div>';
        },
        'post',
        'side',
        'default'
    );
});

add_action('save_post', function($post_id) {
    if (!empty($_POST['tax_input']['formats'])) {
        $input = $_POST['tax_input']['formats'];
        $term_ids = (array) $input;
        wp_set_object_terms($post_id, array_map('intval', $term_ids), 'formats', false);
    }
});

add_action('registered_taxonomy', function($taxonomy) {
    if ($taxonomy === 'formats') {
        global $wp_taxonomies;
        $wp_taxonomies[$taxonomy]->meta_box_sanitize_cb = function($input) {
            return array_map('intval', (array) $input);
        };
    }
});


