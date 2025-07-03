<ul id="<?php _e( $atts['id'] );?>" data-target="<?php _e('li.orbit-article-db');?>" data-url="<?php _e( $atts['url'] );?>" class="orbit-one-grid hero-post">
	<?php while( $this->query->have_posts() ) : $this->query->the_post();?>
	<li class="orbit-article-db orbit-list-db">
		<?php get_template_part('partials/post', 'common');?>
	</li>
	<?php endwhile;?>
</ul>
