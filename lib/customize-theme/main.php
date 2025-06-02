<?php

	$inc_files = array(
		// 'class-sp-customize.php',
		'logo.php',
		// 'social_media.php',
		// 'background.php',
		// 'fonts.php',
		'single-post.php',
		'taxonomy.php',
		'archive.php',
		// 'author.php',
		// 'footer.php'
	);

	foreach($inc_files as $inc_file){
		require_once( $inc_file );
	}
