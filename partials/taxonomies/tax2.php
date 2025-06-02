<?php $term = $wp_query->get_queried_object();?>
<div class="container" style="margin-top: 80px;">
  <div class="row">
    <div class='col-sm-12'>
      <h1 class="text-center" style="text-transform: capitalize;">
        <?php _e( $term->name );?>
      </h1>
      <br>
      <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
        <div class="row" style="margin-bottom:30px;">
          <div class="col-md-4" style="margin-top:20px;">
            <?php
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );

            $img_class = "orbit-thumbnail-bg";

            if( !has_post_thumbnail() || !is_array( $thumbnail ) || !$thumbnail[0] ){
              $img_class .= " no-thumbnail";
            }
            ?>
            <div class='<?php _e( $img_class );?>' style='background-image: url( "<?php _e( $thumbnail[0] );?> ");position: relative;'>
            	<a href='<?php the_permalink();?>' style="position: absolute; top:0;left:0;width:100%;height: 100%;"></a>
            </div>
          </div>
          <div class="col-md-8 orbit-content">
            <h3 class='orbit-title'><a href='<?php the_permalink();?>'><?php the_title();?></a></h3>

          	<p>By <?php
              if ( function_exists('coauthors_posts_links') ) {
			          coauthors_posts_links();
		          }
		          else { echo "plugin inactive"; } ?> on <?php the_time( 'F jS Y' );?></p>
          	<div class='orbit-excerpt'><?php the_excerpt();?></div>
            <a class='orbit-btn' href='<?php the_permalink();?>'>Read More</a>
          </div>

        </div>
        <?php endwhile; ?>

      <?php endif; ?>
    </div>
  </div>
</div>
<!-- PAGINATION -->
<div class="container-fluid search-pagination">
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
