<?php
function qb_filters_shortcode($atts) {
    // defaults attributes
    $atts = shortcode_atts([
        'style' => 'grid2',
        'posts_per_page' => '10',
        'pagination' => '0',
        'pagination_style' => 'default',
    ], $atts, 'qb_filters');


    $selected_format = isset($_GET['formats']) ? sanitize_text_field($_GET['formats']) : '';
    // $selected_format = get_query_var('formats') ? sanitize_text_field(get_query_var('formats')) : '';
    $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    // $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $format_terms = get_terms([
        'taxonomy' => 'formats',
        'hide_empty' => true,
    ]);

    $theme_terms = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => true,
    ]);

    $tax_query_parts = [];

    if ($selected_format) {
        $tax_query_parts[] = "formats:$selected_format";
    }

    if ($selected_category) {
        $tax_query_parts[] = "category:$selected_category";
    }

    $tax_query_string = implode('AND', $tax_query_parts);

    $shortcode = '[orbit_query';
    $shortcode .= ' style="' . esc_attr($atts['style']) . '"';
    $shortcode .= ' posts_per_page="' . esc_attr($atts['posts_per_page']) . '"';
    $shortcode .= ' pagination="' . esc_attr($atts['pagination']) . '"';
    $shortcode .= ' pagination_style="' . esc_attr($atts['pagination_style']) . '"';
    // $shortcode .= ' paged="' . esc_attr($paged) . '"';

    if (!empty($tax_query_string)) {
        $shortcode .= ' tax_query="' . esc_attr($tax_query_string) . '"';
    }

    $shortcode .= ']';

    $orbit_output = do_shortcode($shortcode);

    // echo '<pre>';
    // print_r($shortcode);
    // echo '</pre>';

    ob_start();
    ?>

    <div class="qb-filters-wrapper">

        <!-- FILTER SECTION -->
        <div class="filters-wrapper mb-32">
            <div class="body-font text-tiny">FILTERS</div>
            <form method="GET" action="<?php echo esc_url( get_permalink() ); ?>" class="filters-form">
                <select name="formats" class="filter-select text-tiny" onchange="this.form.submit()">
                    <option value="">BY FORMAT</option>
                    <?php foreach ($format_terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected_format, $term->slug); ?>>
                            <?php echo esc_html($term->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="category" class="filter-select text-tiny" onchange="this.form.submit()">
                    <option value="">BY THEME</option>
                    <?php foreach ($theme_terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected_category, $term->slug); ?>>
                            <?php echo esc_html($term->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($selected_format || $selected_category): ?>
                <div class="clear-filters mt-2">
                    <a href="<?php echo esc_url(remove_query_arg(['formats', 'category'])); ?>" class="clear-filters-link">Clear Filters</a>
                </div>
            <?php endif; ?>
        </div>

        <hr class="mb-32" />

        <!-- QUERY OUTPUT OR EMPTY MESSAGE -->
        <div class="orbit-query-output">
            <?php
                if (trim(strip_tags($orbit_output)) === '') {
                    echo '<p class="no-results-message">No results found for the selected filters.</p>';
                } else {
                    echo $orbit_output;
                }
            ?>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('qb_filters', 'qb_filters_shortcode');
