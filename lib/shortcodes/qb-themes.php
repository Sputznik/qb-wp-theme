<?php
function qb_themes_shortcode($atts) {
    $atts = shortcode_atts([
        'per_page' => 10,
    ], $atts);

    $categories = get_categories([
        'hide_empty' => false,
        'number' => intval($atts['per_page']),
    ]);

    ob_start();

    echo '<div class="qb-themes-wrapper">';
    foreach ($categories as $category) {
        $bg_color   = get_term_meta($category->term_id, 'category_bg_color', true);
        $icon_class    = get_term_meta($category->term_id, 'category_icon', true);
        $text_color = get_term_meta($category->term_id, 'category_text_color', true);
        $category_url = get_category_link($category->term_id);
        ?>
        <a href="<?= esc_url($category_url); ?>" class="qb-theme-tile" style="background-color: <?= esc_attr($bg_color); ?>; color: <?= esc_attr($text_color); ?>">
            <div class="qb-theme-inner">
                <div class="qb-theme-icon">
                    <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                </div>
                <div class="qb-theme-title"><?= esc_html($category->name); ?></div>
            </div>
        </a>
        <?php
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('qb_themes', 'qb_themes_shortcode');

