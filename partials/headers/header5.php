<?php 
    $sp_customize;
    $option = $sp_customize->get_option();
    $show_cta = isset($option['has_cta_button']) && $option['has_cta_button'] == 1;
    $cta_text = !empty($option['cta_button_text']) ? esc_html($option['cta_button_text']) : '';
    $cta_url  = !empty($option['cta_button_url']) ? esc_url($option['cta_button_url']) : '#';
?>


<nav class="navbar header5">
  <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="menu-text">MENU</span>
                <span class="icon-bars">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </span>
            </button>
        

            <div class="qb-topbar">
            <div class="qb-left">
                <?php if ( isset($option['has_search_icon']) && $option['has_search_icon'] == 1 ) : ?>
                <div href="#" class="header-search-icon" data-toggle="modal" data-target="#search-modal">
                <i class="bx bx-search"></i>
                <span>Search</span>
                </div>

                <?php endif; ?>
            </div>

            <div class="qb-center">
                <div class="qb-logo">
                <?php do_action('sp_logo'); ?>
                <div class="site-tagline"><?php echo get_bloginfo( 'description' ); ?></div>
                </div>
            </div>

            <div class="qb-right">
                <?php if ( $show_cta && $cta_text ) : ?>
                <a href="<?php echo $cta_url; ?>" target="_blank" class="qb-cta"><?php echo $cta_text; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    

    <?php do_action('sp_nav_menu'); ?>
  </div>
</nav>


