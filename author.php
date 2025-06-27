<?php
/**
 * The template for displaying author archives
 */
get_header();

// Get author data
$author_id    = get_queried_object_id();
$display_name = get_the_author_meta('display_name', $author_id);
$author_bio   = get_the_author_meta('description', $author_id);
?>

<div class="container">
  <div class="author-header">
    <div class="author-info">
      <h1 class="author-name"><?php echo esc_html($display_name); ?></h1>

        <?php if (!empty($author_bio)) : ?>
        <div class="author-bio">
          <p><?php echo esc_html($author_bio); ?></p>
        </div>
      <?php endif; ?>

      <?php
        $public_link = get_the_author_meta('public_link', $author_id);
        if (!empty($public_link)) :
      ?>
        <div class="author-contact">
          <p>Follow
            <a href="<?php echo esc_url($public_link); ?>" target="_blank" rel="noopener" style="text-transform: capitalize;">
              <strong><?php echo esc_html($display_name); ?> </strong>
            </a>
            here.
          </p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="articles-post-list-wrap">
    <?php
      echo do_shortcode("[orbit_query posts_per_page='9' style='grid2' author='{$author_id}' pagination='1']");
    ?>
  </div>
</div>

<?php get_footer(); ?>
