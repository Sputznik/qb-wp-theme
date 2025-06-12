<?php
// Add custom fields to the category edit screen
// 1. Add fields to Add and Edit Category forms
add_action('category_add_form_fields', function () {
    ?>
    <div class="form-field">
        <label for="category_bg_color">Background Color</label>
        <input type="text" name="category_bg_color" id="category_bg_color" class="color-picker" />
    </div>
    <div class="form-field">
        
        <label for="category_icon"><a href="https://boxicons.com/icons/" target="_blank" rel="noopener noreferrer">Click here</a> to find box icon class names.</label>
        <input type="text" name="category_icon" id="category_icon" />
        <p class="description">e.g., bx bx-star. Preview: <i id="bx-icon-preview" class=""></i></p>
    </div>
    <div class="form-field">
        <label for="category_text_color">Icon/Text Color</label>
        <input type="text" name="category_text_color" id="category_text_color" class="color-picker" />
    </div>
    <?php
});

// Add fields to Edit Category form
add_action('category_edit_form_fields', function ($term) {
    $bg_color = get_term_meta($term->term_id, 'category_bg_color', true);
    $icon = get_term_meta($term->term_id, 'category_icon', true);
    $text_color = get_term_meta($term->term_id, 'category_text_color', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_bg_color">Background Color</label></th>
        <td><input type="text" name="category_bg_color" id="category_bg_color" value="<?php echo esc_attr($bg_color); ?>" class="color-picker" /></td>
    </tr>
    <tr class="form-field">
        <th scope="row">
            <label for="category_icon"><a href="https://boxicons.com/icons/" target="_blank" rel="noopener noreferrer">Click here</a> to find box icon class names.</label>
        </th>
        <td>
            <input type="text" name="category_icon" id="category_icon" value="<?php echo esc_attr($icon); ?>" />
            <p class="description">Preview: <i id="bx-icon-preview" class="<?php echo esc_attr($icon); ?>" style="color:<?php echo esc_attr($text_color); ?>;"></i></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="category_text_color">Icon/Text Color</label></th>
        <td><input type="text" name="category_text_color" id="category_text_color" value="<?php echo esc_attr($text_color); ?>" class="color-picker" /></td>
    </tr>
    <?php
}, 10, 1);

// Save the fields
function save_category_meta_fields($term_id) {
    $default_bg_color = '#D9D9D9';
    $default_icon = 'bx bx-star';
    $default_text_color = '#14182D';

    $bg_color = isset($_POST['category_bg_color']) && $_POST['category_bg_color'] !== ''
        ? sanitize_hex_color($_POST['category_bg_color'])
        : $default_bg_color;
    $icon = isset($_POST['category_icon']) && $_POST['category_icon'] !== ''
        ? sanitize_text_field($_POST['category_icon'])
        : $default_icon;
    $text_color = isset($_POST['category_text_color']) && $_POST['category_text_color'] !== ''
        ? sanitize_hex_color($_POST['category_text_color'])
        : $default_text_color;

    update_term_meta($term_id, 'category_bg_color', $bg_color);
    update_term_meta($term_id, 'category_icon', $icon);
    update_term_meta($term_id, 'category_text_color', $text_color);
}
add_action('created_category', 'save_category_meta_fields', 10, 1);
add_action('edited_category', 'save_category_meta_fields', 10, 1);

// Add single custom column to category table
add_filter('manage_edit-category_columns', function ($columns) {
    $columns['category_combined_display'] = 'Preview';
    return $columns;
});

// Display content in the combined column
add_filter('manage_category_custom_column', function ($out, $column, $term_id) {
    if ($column === 'category_combined_display') {
        $bg_color = get_term_meta($term_id, 'category_bg_color', true);
        $icon = get_term_meta($term_id, 'category_icon', true);
        $text_color = get_term_meta($term_id, 'category_text_color', true);

        if ($icon) {
            return sprintf(
                '<div style="width:30px; height:30px; background:%s; display:flex; align-items:center; justify-content:center; border-radius:4px;">
                    <i class="%s" style="color:%s;"></i>
                </div>',
                esc_attr($bg_color),
                esc_attr($icon),
                esc_attr($text_color)
            );
        } else {
            // If no icon, just show the background color
            return sprintf(
                '<div style="width:30px; height:30px; background:%s; border-radius:4px;"></div>',
                esc_attr($bg_color)
            );
        }
    }

    return $out;
}, 10, 3);
