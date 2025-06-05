<?php

	$inc_files = array(
		'logo.php',
		'single-post.php',
		// 'taxonomy.php',
	);

	foreach($inc_files as $inc_file){
		require_once( $inc_file );
	}
