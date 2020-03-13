<?php 
    $suga_option = suga_core::bk_get_global_var('suga_option');
    if ((isset($suga_option['bk-footer-inverse'])) && (($suga_option['bk-footer-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    if ((isset($suga_option['bk-footer-pattern'])) && (($suga_option['bk-footer-pattern']) == 1)){ 
        $has_Pattern = 'yes';
    }else {
        $has_Pattern = '';
    }
    
    $logo   = suga_core::bk_get_theme_option('bk-footer-logo');
    $logoW  = suga_core::bk_get_theme_option('footer-logo-width');
    
    if (($logo != null) && (array_key_exists('url',$logo))) {
        if ($logo['url'] != '') {
            $hasFooter = 1;
        }else {
            $hasFooter = 0;
        }
    }else if ( has_nav_menu( 'footer-menu' ) ) {
        $hasFooter = 1;
    }else if(isset($suga_option['footer-social']) && ($suga_option['footer-social'] != '')) {
        $hasFooter = 1;
    }else {
        $hasFooter = 0;
    }
?>	
<?php if($hasFooter == 1) :?>
<!-- Site header -->
<footer class="site-footer footer-1 <?php if($inverseClass == "yes") echo " site-footer--inverse inverse-text";?>">
    <!-- Navigation bar -->
    <div class="site-footer__section site-footer__section--flex">
        <div class="container">
            <div class="site-footer__section-inner">
                <nav class="suga-footer-wrap">
                                                                                        
                        <!-- logo open -->
                        
                        <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                if ($logo['url'] != '') {
                            ?>
                            <div class="footer-logo">
                                <a href="<?php echo esc_url(get_home_url('/'));?>">
                                    <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'suga');?>" <?php if($logoW != '') {echo 'width="'.esc_attr($logoW).'"';}?>/>
                                <!-- logo close -->
            					</a>
                            </div>
                            <?php } ?>
                        <?php } ?>
                        
                    <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                    <?php 
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu', 
                            'depth' => '1', 
                            'menu_class' => 'navigation navigation--footer navigation--inline',
                            )
                    ); 
                    ?>
                    <?php endif;?>
                    <?php if(isset($suga_option['footer-social']) && ($suga_option['footer-social'] != '')) :?>
                    <div class="social-footer-container">
            			<ul class="social-list social-list--lg list-horizontal text-center">
            				<?php 
                                echo suga_core::bk_get_social_media_links($suga_option['footer-social']);
                            ?>
            			</ul>
                    </div>
                    <?php endif;?>
                </nav>
            </div>
        </div>
    </div>
</footer><!-- Site header -->
<?php endif;?>
<?php 
    
    if((isset($suga_option['bk-sticky-menu-switch'])) && ($suga_option['bk-sticky-menu-switch'] == 1)):
        get_template_part( 'library/templates/header/suga-sticky-header' );
    endif;
    
    if ( function_exists('login_with_ajax') ) {
        get_template_part( 'library/templates/suga-login-modal' );
    }
    
    if ( isset($suga_option ['bk-offcanvas-desktop-switch']) && ($suga_option ['bk-offcanvas-desktop-switch'] != 0) ){
        get_template_part( 'library/templates/offcanvas/offcanvas-desktop' );
    }
    
    get_template_part( 'library/templates/offcanvas/offcanvas-mobile' );
    
    if((isset($suga_option['bk-header-subscribe-switch'])) && ($suga_option['bk-header-subscribe-switch'] == 1)):
        get_template_part( 'library/templates/suga-subscribe-modal' );
    endif;
   get_template_part( 'library/templates/header/header-search-popup' );
?>
<!-- go top button -->
<a href="#" class="atbssuga-go-top btn btn-default hidden-xs js-go-top-el"><i class="mdicon mdicon-arrow_upward"></i></a>