<div id="content" class="container-fluid single-template-8">
  <?php if(have_posts()): while ( have_posts() ): the_post(); ?>
    <article class="single-post" role="main">

    <?php
      $tags = get_the_tags();
      if ( $tags && ! is_wp_error( $tags ) ) :
        $tag_names = array_map( function( $tag ) {
          return esc_html( $tag->name );
        }, $tags );
        $tag_output = implode( ', ', $tag_names );
    ?>
        <div class="top-head">
          <div class="post-tags body-font fw-semibold text-medium mb-32">
            <?php echo $tag_output; ?>
          </div>
        </div> 
    <?php endif; ?>


      <h1 class="post-title mt-0 mb-16 heading-1 heading-font fw-bold"><?php the_title(); ?></h1>

        <div class="post-strapline body-font text-large fw-normal"><?php echo get_the_excerpt(); ?></div>

        <div class="post-meta body-font fw-normal text-medium mb-32">
          <?php echo get_the_date(); ?>
          <?php
          /*
            $terms = get_the_terms( get_the_ID(), 'formats' );
            if ( !empty($terms) && !is_wp_error($terms) ) {
                echo ' &nbsp; | &nbsp; ' . esc_html( $terms[0]->name );
            }
          */?>
        </div>

      <div class="share-inline">
        <span class="body-font text-tiny fw-medium">SHARE</span>
        <?php echo do_shortcode('[addtoany]'); ?>
      </div>

      <?php if( has_post_thumbnail() ): ?>
        <img class="featured-image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>">
      <?php endif; ?>

      <div class="temp-9-post-inner-wrap" style="display: none;">
        <div class="post-category">
          
			<?php 
        $categories = get_the_category(); 
        if ( ! empty( $categories ) ) {
          $cat = $categories[0];
          $icon_class = get_term_meta( $cat->term_id, 'category_icon', true );
          $text_color = get_term_meta( $cat->term_id, 'category_text_color', true );
          ?>
          <span class="category-icon-label" style="color: <?php echo esc_attr( $text_color ); ?>;">
            <?php if ( $icon_class ) : ?>
              <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
            <?php endif; ?>
            <span class="category-name" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html( strtoupper( $cat->name ) ); ?></span>
          </span>
          <?php
        }
      ?>

		</div>
    </div>
      <?php get_template_part( 'partials/post/contributors' ); ?>
      <div class="post-body">
        <?php
        $warning = get_post_meta(get_the_ID(), 'post_content_warning', true);
        if (!empty($warning)) : ?>
          <div class="qb-content-warning">
            <p>
              <i class='bxr bx-alert-triangle'></i> 
              <?php echo esc_html($warning); ?>
            </p>
          </div>
        <?php endif; ?>
        <?php the_content(); ?>
        <?php get_template_part( 'partials/post/credits' ); ?>
      </div>

      <?php get_template_part( 'partials/post/related-posts' ); ?>

    </article>
  <?php endwhile; endif; ?>
</div>
