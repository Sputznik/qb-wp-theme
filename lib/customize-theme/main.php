<?php

	$inc_files = array(
		'logo.php',
		'single-post.php',
		'back-to-top.php',
		// 'taxonomy.php',
	);

	foreach($inc_files as $inc_file){
		require_once( $inc_file );
	}
