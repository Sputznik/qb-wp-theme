<div id="content" class="container-fluid single-template-8">
  <?php if(have_posts()): while ( have_posts() ): the_post(); ?>
    <article class="single-post" role="main">

      <?php if( has_post_thumbnail() ): ?>
        <img class="featured-image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>">
      <?php endif; ?>

      <div class="post-inner-wrap">
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

        <h1 class="post-title"><?php the_title(); ?></h1>
        <div class="post-strapline"><?php echo get_the_excerpt(); ?></div>

        <div class="post-meta">
          <?php echo get_the_date(); ?>
          <?php
            $terms = get_the_terms( get_the_ID(), 'formats' );
            if ( !empty($terms) && !is_wp_error($terms) ) {
                echo ' &nbsp; | &nbsp; ' . esc_html( $terms[0]->name );
            }
          ?>
        </div>
      </div>

      <div class="share-inline">
        <span class="share-label">SHARE</span>
        <?php echo do_shortcode('[addtoany]'); ?>
      </div>

      <?php get_template_part( 'partials/post/contributors' ); ?>


      <div class="post-body">
        <?php the_content(); ?>
      </div>

      <?php get_template_part( 'partials/post/related-posts' ); ?>

    </article>
  <?php endwhile; endif; ?>
</div>
