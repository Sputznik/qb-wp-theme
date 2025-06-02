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
        <label for="category_icon">Boxicons Icon</label>
        <input type="text" name="category_icon" id="category_icon" />
        <p class="description">e.g., bx bx-star. Preview: <i id="bx-icon-preview" class=""></i></p>
    </div>
    <?php
});

// Add fields to Edit Category form
add_action('category_edit_form_fields', function ($term) {
    $bg_color = get_term_meta($term->term_id, 'category_bg_color', true);
    $icon = get_term_meta($term->term_id, 'category_icon', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_bg_color">Background Color</label></th>
        <td><input type="text" name="category_bg_color" id="category_bg_color" value="<?php echo esc_attr($bg_color); ?>" class="color-picker" /></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="category_icon">Boxicons Icon</label></th>
        <td>
            <input type="text" name="category_icon" id="category_icon" value="<?php echo esc_attr($icon); ?>" />
            <p class="description">Preview: <i id="bx-icon-preview" class="<?php echo esc_attr($icon); ?>"></i></p>
        </td>
    </tr>
    <?php
}, 10, 1);

// Save the fields
function save_category_meta_fields($term_id) {
    if (isset($_POST['category_bg_color'])) {
        update_term_meta($term_id, 'category_bg_color', sanitize_hex_color($_POST['category_bg_color']));
    }
    if (isset($_POST['category_icon'])) {
        update_term_meta($term_id, 'category_icon', sanitize_text_field($_POST['category_icon']));
    }
}
add_action('created_category', 'save_category_meta_fields', 10, 1);
add_action('edited_category', 'save_category_meta_fields', 10, 1);

// Add columns to table
add_filter('manage_edit-category_columns', function ($columns) {
    $columns['category_bg_color'] = 'BG Color';
    $columns['category_icon'] = 'Icon';
    return $columns;
});

// Display column content
add_filter('manage_category_custom_column', function ($out, $column, $term_id) {
    if ($column === 'category_bg_color') {
        $color = get_term_meta($term_id, 'category_bg_color', true);
        if ($color) {
            return '<div style="width:20px; height:20px; background:' . esc_attr($color) . ';"></div>';
        }
    }
    if ($column === 'category_icon') {
        $icon = get_term_meta($term_id, 'category_icon', true);
        if ($icon) {
            return '<i class="' . esc_attr($icon) . '"></i>';
        }
    }
    return $out;
}, 10, 3);

