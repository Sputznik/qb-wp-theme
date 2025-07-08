<?php
	global $post;
	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
	$img_class = "orbit-thumbnail-bg";
	if( !has_post_thumbnail() || !is_array( $thumbnail ) || !$thumbnail[0] ){
		$img_class .= " no-thumbnail";
	}

	// Get first 'formats' term (custom taxonomy)
	$formats = get_the_terms( $post->ID, 'formats' );
	$format_term = ( !empty($formats) && !is_wp_error($formats) ) ? $formats[0] : false;

	// Get first 'category' term
	$categories = get_the_category();
	$category_term = ( !empty($categories) && !is_wp_error($categories) ) ? $categories[0] : false;
?>

<article class="orbit-card">
	<div class="orbit-thumbnail <?php echo esc_attr($img_class); ?>" style='background-image: url("<?php echo esc_url($thumbnail[0]); ?>");'>
		<?php if ( $format_term ) : ?>
			<span class="orbit-badge text-small body-font"><?php echo esc_html( $format_term->name ); ?></span>
		<?php endif; ?>
		<a href="<?php the_permalink(); ?>"></a>
	</div>

	<div class="orbit-content">
		<div class="orbit-meta">
			<span class="body-font text-tiny fw-medium">
				<?php
				// the_author();
				echo do_shortcode('[orbit_coauthors]');
				?>
			</span>
			<span class="body-font text-tiny fw-medium"><?php echo get_the_date('d M Y'); ?></span>
		</div>

		<h2 class="orbit-headline heading-font heading-4 fw-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<p class="orbit-strapline body-font text-small fw-normal"><?php echo get_the_excerpt(); ?></p>

		<?php if ( $category_term ) : 
			$text_color = get_term_meta( $category_term->term_id, 'category_text_color', true );
			$text_color = $text_color ? esc_attr( $text_color ) : '#14182D';
		?>
			<a class="orbit-tag body-font text-regular" href="<?php echo esc_url( get_category_link( $category_term->term_id ) ); ?>" style="background-color: <?php echo $text_color; ?>;">
				<?php echo esc_html( $category_term->name ); ?>
			</a>
		<?php endif; ?>
	</div>

</article>
