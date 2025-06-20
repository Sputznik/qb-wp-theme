<?php
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

