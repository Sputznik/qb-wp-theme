<?php
get_header();
?>
<div class="container">
  <h1 class="heading-font heading-1 fw-bold mb-32">
    <?php
      // Remove the 'Category:' or similar prefix from archive title
      $title = single_cat_title('', false);
      if (!$title) {
        $title = get_the_archive_title();
      }
      echo esc_html($title);
    ?>
  </h1>
  <hr class="mb-32"/>
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
  <div class="qb-search-pagination-wrapper">
  <div class="qb-search-pagination">
    <?php
      the_posts_pagination([
        'mid_size'  => 1,
        'prev_text' => '<i class="bx bx-arrow-left-stroke"></i> <span>PREVIOUS</span>',
        'next_text' => '<span>NEXT</span> <i class="bx bx-arrow-right-stroke"></i>',
        'screen_reader_text' => ' ',
      ]);
    ?>
  </div>
</div>

<?php get_footer(); ?>
