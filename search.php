<?php
/**
 * The template for displaying search results pages
 */
get_header();
global $wp_query;
$search_term = get_search_query();

/* $wp_query->found_posts

this count will not work here as we are using shortcode to display posts. this finds all the results, including pages, 
and the count may be inappropriate. so 
we will do a separate query to count only posts.
 */

$post_type_count = new WP_Query( array(
    's' => $search_term,
    'post_type' => 'post',
    'posts_per_page' => -1,
    'fields' => 'ids',
) );
$post_count = $post_type_count->found_posts;
wp_reset_postdata();
?>

<div class="container">
	<!-- Search form -->
	<div class="custom-search-form-wrap">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="search-field" placeholder="Search …" value="<?php echo esc_attr( $search_term ); ?>" name="s" />
		<button type="submit" class="search-submit">Search</button>
	</form>
	</div>
	
  <h1 class="page-title">
    <?php 
      if ( $post_count > 0 ) {
          printf( __( '(%d) Search Results for: %s' ), $post_count, esc_html( $search_term ) );
      } else {
          echo __( 'Sorry, but nothing matched your search terms. Please try again with different keywords.' );
      }
    ?>
  </h1>
  <hr/>
</div>


<?php if ( $post_count > 0 ) : ?>
  <div class="container">
    <div class="articles-post-list-wrap">
      <?php
        echo do_shortcode("[orbit_query posts_per_page='10' style='grid2' s='" . esc_attr( $search_term ) . "' pagination='1']");
      ?>
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>
