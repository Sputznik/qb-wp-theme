<?php
get_header();

$selected_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
$selected_format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
?>
<div class="category-header archive-header wrapper-margin gtc-page-header-bg">
  <div class="container">
    <h1 class="page-title text-capitalize text-center">
      <?php echo $selected_format ? ucfirst(str_replace('-', ' ', $selected_format)) : 'All Formats'; ?>
    </h1>
  </div>
</div>

<div class="container">
  <form method="get" id="filter-form" style="margin-bottom: 30px;">
    <label for="format">Filters :</label>
    <select name="format" id="format" onchange="document.getElementById('filter-form').submit();">
      <option value="">Format</option>
      <?php
      $formats = get_terms(array(
        'taxonomy' => 'formats',
        'hide_empty' => false
      ));
      foreach ( $formats as $format ) {
        $selected = ($selected_format === $format->slug) ? 'selected' : '';
        echo "<option value='{$format->slug}' $selected>{$format->name}</option>";
      }
      ?>
    </select>

    <label for="tag" style="margin-left: 20px;">Tag:</label>
    <select name="tag" id="tag" onchange="document.getElementById('filter-form').submit();">
      <option value="">Theme</option>
      <?php
      $tags = get_tags();
      foreach ( $tags as $tag ) {
        $selected = ($selected_tag === $tag->slug) ? 'selected' : '';
        echo "<option value='{$tag->slug}' $selected>{$tag->name}</option>";
      }
      ?>
    </select>
  </form>

  <div class="articles-post-list-wrap">
    <?php
    $shortcode = "[orbit_query posts_per_page='6' style='grid2' pagination='1'";

    if ( $selected_tag ) {
      $shortcode .= " tag='" . esc_attr($selected_tag) . "'";
    }

    if ( $selected_format ) {
      $shortcode .= " tax_query='formats:" . esc_attr($selected_format) . "'";
    }

    $shortcode .= "]";

    echo do_shortcode($shortcode);
    ?>
  </div>
</div>

<?php get_footer(); ?>
