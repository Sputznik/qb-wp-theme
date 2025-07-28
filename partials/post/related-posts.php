<?php
/*
*
 * The template for displaying related posts based on custom meta fields.
 */
$post_id = get_the_ID();

$related_post_1 = get_post_meta($post_id, 'story1', true);
$related_post_2 = get_post_meta($post_id, 'story2', true);

// Filter out empty or invalid values
$related_ids = array_filter([$related_post_2, $related_post_1]);

if (!empty($related_ids)) {
    $ids_str = implode(',', $related_ids);
    $shortcode_str = do_shortcode("[orbit_query post__in='{$ids_str}' style='grid2']");

    if (!empty($shortcode_str)) : ?>
        <div class="related-posts">
            <div class="container">
                <div class="row" style="display: flex; align-items: center; justify-content: space-between; padding-left:27px; padding-right:27px;">
                    <div style="flex:1;">
                        <h2 class="heading-font heading-3 fw-semibold mt-0" style="margin-bottom:0;">More like this</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $shortcode_str; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
}
?>
