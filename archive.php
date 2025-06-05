<?php
/**
 * The template for displaying archive pages (categories, custom taxonomies)
 */
get_header();

$term = $wp_query->get_queried_object();
$taxonomy = $term->taxonomy;
$term_id = $term->term_id;
$term_name = $term->name;

?>
<div class="container">
  <h1 class="page-title text-capitalize text-center"><?php echo esc_html($term_name); ?></h1>
</div>

<div class="container">
  <div class="articles-post-list-wrap">
    <?php
      if ($taxonomy === 'category') {
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' cat='{$term_id}' pagination='1']");
      } else {
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' tax_query='{$taxonomy}:{$term_id}' pagination='1']");
      }
    ?>
  </div>
</div>

<?php get_footer(); ?>
