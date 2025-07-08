<?php
/**
 * The template for displaying tag archives
 */
get_header();

$term = get_queried_object();
$tag_title = single_tag_title('', false);
$tag_description = term_description($term);
?>

<div class="container">
  <div class="tag-header">
    <h1 class="heading-font heading-1 fw-bold mb-32 text-center"><?php echo esc_html($tag_title); ?></h1>

    <?php if (!empty($tag_description)) : ?>
        <div class="body-font text-medium text-center"><?php echo $tag_description; ?></div>
    <?php endif; ?>

    <hr class="mb-32"/>
  </div>
</div>

<div class="container">
  <div class="articles-post-list-wrap">
    <?php echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' tag='{$term->slug}' pagination='1']"); ?>
  </div>
</div>

<?php get_footer(); ?>
