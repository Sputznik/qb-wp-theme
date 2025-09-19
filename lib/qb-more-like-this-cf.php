<?php

add_action('add_meta_boxes', 'mlt_add_custom_meta_boxes');
function mlt_add_custom_meta_boxes() {
    add_meta_box('mlt_meta_box', 'More Like This', 'mlt_render_meta_box', 'post', 'normal', 'high');
}
function mlt_render_meta_box($post) {
    $mlt1 = get_post_meta($post->ID, 'story1', true);
    $mlt2 = get_post_meta($post->ID, 'story2', true);

    $title1 = $mlt1 ? get_the_title($mlt1) : '';
    $title2 = $mlt2 ? get_the_title($mlt2) : '';

    wp_nonce_field('mlt_save_meta_box', 'mlt_meta_box_nonce');
    ?>
    <p>
        <label for="mlt1">Story One</label><br>
        <input type="hidden" name="story1" id="mlt1_hidden" value="<?php echo esc_attr($mlt1); ?>">
        <input type="text" id="mlt1" placeholder="Start typing a title of a story to search" class="mlt-autocomplete" data-source="posts" data-target="#mlt1_hidden" value="<?php echo esc_attr($title1); ?>" autocomplete="off" style="width: 100%;">
    </p>
    <p>
        <label for="mlt2">Story Two</label><br>
        <input type="hidden" name="story2" id="mlt2_hidden" value="<?php echo esc_attr($mlt2); ?>">
        <input type="text" id="mlt2" placeholder="Start typing a title of a story to search" class="mlt-autocomplete" data-source="posts" data-target="#mlt2_hidden" value="<?php echo esc_attr($title2); ?>" autocomplete="off" style="width: 100%;">
        <!-- to reuse autocomplete for users we can use data-source-"users"a nd data-target="#user_hidden" -->
    </p>
    <?php
}

add_action('save_post', 'mlt_save_meta_box_data');
function mlt_save_meta_box_data($post_id) {
    if (!isset($_POST['mlt_meta_box_nonce']) || !wp_verify_nonce($_POST['mlt_meta_box_nonce'], 'mlt_save_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['story1', 'story2'];
    foreach ($fields as $field) {
        $value = isset($_POST[$field]) ? intval($_POST[$field]) : 0;

        if ($value) {
            update_post_meta($post_id, $field, $value);
        } else {
            delete_post_meta($post_id, $field); // clean up if empty
        }
    }

}

add_action('wp_ajax_mlt_autocomplete', 'mlt_ajax_autocomplete_callback');
function mlt_ajax_autocomplete_callback() {
    check_ajax_referer('mlt_autocomplete_nonce', 'nonce');

    $term = sanitize_text_field($_GET['term'] ?? '');
    $exclude_id = intval($_GET['current_post_id'] ?? 0);
    $source_type = sanitize_text_field($_GET['source_type'] ?? 'posts');

    $results = [];

    switch ($source_type) {
        case 'posts':
            $query = new WP_Query([
                's' => $term,
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'post__not_in' => [$exclude_id],
            ]);
            foreach ($query->posts as $post) {
                $results[] = [
                    'label' => $post->post_title,
                    'value' => $post->ID,
                ];
            }
            break;

        case 'users':
            $users = get_users([
                'search' => "*$term*",
                'number' => 10,
                'fields' => ['ID', 'display_name'],
            ]);
            foreach ($users as $user) {
                $results[] = [
                    'label' => $user->display_name,
                    'value' => $user->ID,
                ];
            }
            break;

        // Add more cases for custom_post_type, taxonomies, etc.
    }

    wp_send_json($results);
}



