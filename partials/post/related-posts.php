<?php
/*
*
 * The template for displaying related posts based on post-categories.
 */
$post_id = get_the_ID();
$categories = wp_get_post_categories( $post_id, ['ids'] );
$cats_str = implode(',', $categories);
$shortcode_str = do_shortcode("[orbit_query posts_per_page='2' style='grid2' cat='".$cats_str."' post__not_in='".$post_id."' orderby='rand']");
if( $cats_str && strlen( $shortcode_str ) > 0 ): ?>
  <div class="related-posts">
    <div class="container">
      <div class="row" style="display: flex; align-items: center; justify-content: space-between; padding-left:27px; padding-right:27px;">
        <div style="flex:1;">
          <h2 class="heading-font heading-3 fw-semibold mt-0" style="margin-bottom:0;">More like this</h2>
        </div>
        <div style="display: flex; align-items: flex-end;">
          <?php
          $first_cat_id = !empty($categories) ? $categories[0] : 0;
          $cat_link = $first_cat_id ? get_category_link($first_cat_id) : '#';
          ?>
          <a href="<?php echo esc_url($cat_link); ?>" class="body-font text-small fw-medium" style="display: flex; align-items: flex-end; text-decoration:none; gap:6px;">
            <span>View All</span>
            <i class='bx bx-right-arrow-alt' style="font-size:1.2em;"></i>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <?php echo $shortcode_str;?>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>
