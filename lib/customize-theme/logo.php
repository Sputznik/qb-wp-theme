<?php

	add_filter( 'sp_headers_options', function( $headers_arr ) {
        $headers_arr['header5'] = 'Queerbeat Header';
        return $headers_arr;
    });

    add_filter( 'sp_header5_template', function( $template_path ) {
        $child_template = QUEERBEAT_THEME_PATH . '/' .  $template_path;
        return file_exists( $child_template ) ? $child_template : $template_path;
    } );

	add_action('customize_register', function( $wp_customize ) {
        global $sp_customize;

        $sp_customize->checkbox($wp_customize, 'sp_logo_section', '[has_cta_button]', 'Has CTA Button');
        $sp_customize->text($wp_customize, 'sp_logo_section', '[cta_button_text]', 'CTA Button Text', 'Join qbClub');
        $sp_customize->text($wp_customize, 'sp_logo_section', '[cta_button_url]', 'CTA Button URL', '#');

    }, 20);

	/* CHANGE THE ATTRIBUTES PASSED TO THE NAVIGATION MENU */
	add_filter('sp_nav_menu_options', function( $sp_nav_menu_options ){

		global $sp_customize;

		$header_type = $sp_customize->get_header_type();

		if( $header_type == 'header5' ){
			$sp_nav_menu_options['container_class'] = 'navbar-collapse collapse';
			$sp_nav_menu_options['container_id']    = 'bs-example-navbar-collapse-1';
			$sp_nav_menu_options['menu_class']      = 'nav navbar-nav';
		}
		return $sp_nav_menu_options;
	});


    add_action( 'after_setup_theme', function() {
        remove_all_filters( 'wp_nav_menu_items' );

        add_filter( 'wp_nav_menu_items', function( $items, $args ) {

            global $sp_customize;

            // Check if we are in the right menu location
            if ( $args->theme_location == 'primary' ) {

                $option = $sp_customize->get_option();

                // Optional WooCommerce cart icon
                if ( isset( $option['has_cart_icon'] ) && $option['has_cart_icon'] == 1 && class_exists( 'WooCommerce' ) ) {
                    $items .= '<li class="sp_cart_item"><a href="' . get_permalink( wc_get_page_id( 'cart' ) ) . '"><i class="fa fa-shopping-cart"></i><strong class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</strong></a></li>';
                }

                // CTA logic
                $show_cta = isset( $option['has_cta_button'] ) && $option['has_cta_button'] == 1;
                $cta_text = !empty( $option['cta_button_text'] ) ? esc_html( $option['cta_button_text'] ) : '';
                $cta_url  = !empty( $option['cta_button_url'] ) ? esc_url( $option['cta_button_url'] ) : '#';

                $show_search = isset($option['has_search_icon']) && $option['has_search_icon'] == 1;

                // Append CTA to menu
                if ( $show_cta && $cta_text ) {
                    $items .= '<li id="join-cta" class="menu-item sp-cta"><a href="' . $cta_url . '" target="_blank">' . $cta_text . '</a></li>';
                }

                // Append SEARCH to menu
                if ( $show_search) {
                    $items .= '<li id="search-cta" class="menu-item sp-cta">
                                    <a href="#" data-toggle="modal" data-target="#search-modal">
                                        <i class="bx bx-search"></i>
                                        <span>Search</span>
                                    </a>
                                </li>';

                }
            }

            return $items;

        }, 10, 2 );

    }, 20 );

