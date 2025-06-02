<?php

/* <div class="container" style="margin-top: 80px;">
  <div class="row">
    <div class='col-sm-12'>
      <?php if (have_posts()) : ?>
      <ul class='orbit-two-grid' style='margin-bottom:50px; padding-left: 0;'>
        <?php while (have_posts()) : the_post(); ?>
        <li class="orbit-article-db orbit-list-db">
          <?php get_template_part('partials/post', 'common');?>
        </li>
        <?php endwhile; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>  
</div>

*/

/**
 * The template for displaying category page
 */
get_header();
$category = $wp_query->get_queried_object();
?>
<div class="category-header archive-header wrapper-margin gtc-page-header-bg">
  <div class="container">
    <h1 class="page-title text-capitalize text-center"><?php _e( $category->name ); ?></h1>
  </div>
</div>
<div class="container">
  <div class="articles-post-list-wrap">
    <?php echo do_shortcode("[orbit_query posts_per_page='6' style='grid2' cat='".$category->term_id."' pagination='1']"); ?>
  </div>
</div>
<?php get_footer(); ?>
