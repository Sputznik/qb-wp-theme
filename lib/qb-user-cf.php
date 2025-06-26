<?php
// Add to Contact Info section
function add_public_link_contact_field($user_contact) {
    $user_contact['public_link'] = __('Public Link (URL)', 'your-textdomain');
    return $user_contact;
}
add_filter('user_contactmethods', 'add_public_link_contact_field');

// Validate the public_link field before saving
function validate_public_link_url($user_id) {
    if (!current_user_can('edit_user', $user_id)) return;

    if (isset($_POST['public_link']) && !empty($_POST['public_link'])) {
        $url = trim($_POST['public_link']);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            add_action('user_profile_update_errors', function($errors) {
                $errors->add('public_link_error', __('Please enter a valid URL for the Public Link.', 'your-textdomain'));
            }, 10);
        }
    }
}
add_action('personal_options_update', 'validate_public_link_url');
add_action('edit_user_profile_update', 'validate_public_link_url');


