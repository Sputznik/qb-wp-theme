<?php
/**
 * The template for displaying archive pages (categories, tags, authors, custom taxonomies)
 */
get_header();

$term      = $wp_query->get_queried_object();
$taxonomy  = is_tax() ? $term->taxonomy : '';
$term_id   = $term->term_id ?? '';
$term_name = $term->name ?? '';

?>
<div class="container">
  <h1 class="page-title text-capitalize text-center">
    <?php
      if (is_author()) {
        echo esc_html(get_the_author_meta('display_name', get_queried_object_id()));
      } elseif (is_tag()) {
        echo esc_html(single_tag_title('', false));
      } elseif (is_category()) {
        echo esc_html(single_cat_title('', false));
      } elseif (is_tax()) {
        echo esc_html($term_name);
      } else {
        echo esc_html__('Archives', 'your-text-domain');
      }
    ?>
  </h1>
</div>

<div class="container">
  <div class="articles-post-list-wrap">
    <?php
      if (is_author()) {
        $author_id = get_queried_object_id();
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' author='{$author_id}' pagination='1']");
      } elseif (is_tag()) {
        $tag_slug = get_queried_object()->slug;
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' tag='{$tag_slug}' pagination='1']");
      } elseif (is_category()) {
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' cat='{$term_id}' pagination='1']");
      } elseif (is_tax()) {
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' tax_query='{$taxonomy}:{$term_id}' pagination='1']");
      } else {
        echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' pagination='1']");
      }
    ?>
  </div>
</div>

<?php get_footer(); ?>
