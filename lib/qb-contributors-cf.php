<?php
add_action('add_meta_boxes', function () {
    add_meta_box(
        'post_contributors_meta',
        'Contributors',
        'render_contributors_meta_box',
        'post',
        'normal',
        'default'
    );
});

function render_contributors_meta_box($post) {
    wp_nonce_field('contributors_nonce_action', 'contributors_nonce');

    $roles = ['author', 'editor', 'illustrator', 'photographer', 'producer'];

    foreach ($roles as $role) {
        $stored_ids = get_post_meta($post->ID,  $role, true);
        $id_array = array_filter(array_map('intval', explode(',', $stored_ids)));
        ?>
        <p>
            <label for="mlt_<?php echo $role; ?>"><?php echo ucfirst($role); ?>s</label><br>
            <input type="hidden" name="<?php echo $role; ?>" id="mlt_<?php echo $role; ?>_hidden" value="<?php echo esc_attr($stored_ids); ?>">
            <input type="text"
                id="mlt_<?php echo $role; ?>"
                class="mlt-autocomplete-multi"
                data-source="users"
                data-target="#mlt_<?php echo $role; ?>_hidden"
                placeholder="Start typing usernames..."
                autocomplete="off"
                style="width:100%;">
            <div class="mlt-tags" id="mlt_<?php echo $role; ?>_tags">
                <?php foreach ($id_array as $uid):
                    $user = get_userdata($uid);
                    if ($user): ?>
                        <span class="mlt-tag" data-id="<?php echo $uid; ?>">
                            <?php echo esc_html($user->display_name); ?>
                            <a href="#" class="mlt-remove-tag">&times;
                                <!-- <i class='bxr  bx-trash-alt' ></i> -->
                            </a>
                        </span>
                    <?php endif;
                endforeach; ?>
            </div>
        </p>
        <?php
    }
}

add_action('save_post', function ($post_id) {
    if (!isset($_POST['contributors_nonce']) || !wp_verify_nonce($_POST['contributors_nonce'], 'contributors_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $roles = ['author', 'editor', 'illustrator', 'photographer', 'producer'];

    foreach ($roles as $role) {
        if (isset($_POST[$role])) {
            update_post_meta($post_id, $role, sanitize_text_field($_POST[$role]));
        }
    }

});

