<?php get_header();?>
<?php

	global $post_type;

	if( $post_type ){
		$archive_template = apply_filters( 'sp_'.$sp_customize->get_archive_template( $post_type ).'_template', 'partials/archives/'.$sp_customize->get_archive_template( $post_type ).'.php' );
		require_once( $archive_template );
	}
	elseif (is_author()) {
		$author_template = apply_filters( 'sp_'.$sp_customize->get_author_template().'_template', 'partials/taxonomies/'.$sp_customize->get_author_template().'.php' );
		require_once( $author_template );
	}
	else{

		$term = $wp_query->get_queried_object();

		$taxonomy = $term->taxonomy;

		$taxonomy_template = apply_filters( 'sp_'.$sp_customize->get_taxonomy_template( $taxonomy ).'_template', 'partials/taxonomies/'.$sp_customize->get_taxonomy_template( $taxonomy ).'.php' );

		require_once( $taxonomy_template );

	}
?>
<?php get_footer();?>
