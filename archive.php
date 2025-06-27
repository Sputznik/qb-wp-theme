<?php
get_header();
?>
<div class="container">
  <h1 class="page-title text-center">
    <?php
      // Remove the 'Category:' or similar prefix from archive title
      $title = single_cat_title('', false);
      if (!$title) {
        $title = get_the_archive_title();
      }
      echo esc_html($title);
    ?>
  </h1>
  <?php if (have_posts()) : ?>
  <?php
    global $wp_query;
    $total_posts = $wp_query->post_count;
    $show_grid2_sidebar = is_active_sidebar('archive-inline-widget');
    $mid = $total_posts / 2;
    if ($mid % 2 == 0) {
      $widget_after = (int) $mid;
    } else {
      $lower_even = floor($mid) % 2 == 0 ? floor($mid) : floor($mid) - 1;
      $higher_even = ceil($mid) % 2 == 0 ? ceil($mid) : ceil($mid) + 1;
      $widget_after = (abs($mid - $lower_even) <= abs($higher_even - $mid)) ? $lower_even : $higher_even;
    }
    $count = 0;
  ?>
  <ul class="orbit-two-grid">
    <?php while (have_posts()) : the_post(); $count++; ?>
      <li class="orbit-article-db orbit-list-db">
        <?php get_template_part('partials/post', 'common'); ?>
      </li>
      <?php if ($count == $widget_after && $show_grid2_sidebar): ?>
        <li class="archive-inline-widget-full">
          <div class="archive-inline-widget-area">
            <?php dynamic_sidebar('archive-inline-widget'); ?>
          </div>
        </li>
      <?php endif; ?>
    <?php endwhile; ?>
  </ul>
<?php else : ?>
  <p class="text-center">No posts found.</p>
<?php endif; ?>
</div>
<!-- PAGINATION -->
  <div class="container search-pagination">
      <div class="container text-center">
        <?php
          the_posts_pagination(
            array(
              'mid_size' 	=> 1,
              'prev_text' => __( '&laquo;' ),
              'next_text' => __( '&raquo;' ),
              'screen_reader_text' => __( ' ' ),
            )
          );
        ?>
      </div>
  </div>
<?php get_footer(); ?>
