<?php 
    $suga_option = suga_core::bk_get_global_var('suga_option');
    if ((isset($suga_option['bk-offcanvas-mobile-logo'])) && (($suga_option['bk-offcanvas-mobile-logo']) != NULL)){ 
        $logo = $suga_option['bk-offcanvas-mobile-logo'];
        if (($logo != null) && (array_key_exists('url',$logo))) {
            if ($logo['url'] == '') {
                $logo = suga_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $logo = suga_core::bk_get_theme_option('bk-logo');
    }
?>
<!-- Off-canvas menu -->
<div id="atbssuga-offcanvas-mobile" class="atbssuga-offcanvas js-atbssuga-offcanvas js-perfect-scrollbar">
	<div class="atbssuga-offcanvas__title">
		<h2 class="site-logo">
            <a href="<?php echo esc_url(get_home_url('/'));?>">
				<!-- logo open -->
                <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                        if ($logo['url'] != '') {
                    ?>
                    <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'suga');?>"/>
    			<!-- logo close -->
                <?php } else {?>
                    <?php echo esc_attr(bloginfo( 'name' ));?>
                <?php }
                } else {?>
                    <?php echo esc_attr(bloginfo( 'name' ));?>
                <?php } ?>
			</a>
        </h2>
        <?php if ( isset($suga_option ['bk-offcanvas-mobile-social']) && ($suga_option ['bk-offcanvas-mobile-social'] != '') ){ ?>
		<ul class="social-list list-horizontal">
			<?php echo suga_core::bk_get_social_media_links($suga_option['bk-offcanvas-mobile-social']);?>
		</ul>
        <?php }?>
		<a href="#atbssuga-offcanvas-mobile" class="atbssuga-offcanvas-close js-atbssuga-offcanvas-close" aria-label="Close"><span aria-hidden="true">&#10005;</span></a>
	</div>

	<div class="atbssuga-offcanvas__section atbssuga-offcanvas__section-navigation">
		<?php 
            if ( isset($suga_option ['bk-offcanvas-mobile-menu']) && ($suga_option ['bk-offcanvas-mobile-menu'] != '') ){
                if ( has_nav_menu( $suga_option ['bk-offcanvas-mobile-menu'] ) ) : 
                    $menuSettings = array( 
                        'theme_location' => $suga_option ['bk-offcanvas-mobile-menu'],
                        'container_id' => 'offcanvas-menu-mobile',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                elseif ( has_nav_menu( 'main-menu' ) ) : 
                    $menuSettings = array( 
                        'theme_location' => 'main-menu',
                        'container_id' => 'offcanvas-menu-mobile',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                endif;
            }
        ?>
	</div>
    
    <?php if(isset($suga_option['bk-offcanvas-mobile-mailchimp-shortcode']) && ($suga_option['bk-offcanvas-mobile-mailchimp-shortcode'] != '')) :?>
	<div class="atbssuga-offcanvas__section">
		<div class="subscribe-form subscribe-form--horizontal text-center">
            <?php echo do_shortcode($suga_option['bk-offcanvas-mobile-mailchimp-shortcode']);?>
		</div>
	</div>
    <?php endif;?>
    
    <?php if(is_active_sidebar('mobile-offcanvas-widget-area')):?>
    <div class="atbssuga-offcanvas__section">
        <?php dynamic_sidebar( 'mobile-offcanvas-widget-area' );?>
	</div>
    <?php endif;?>
    
    <?php if ( function_exists('login_with_ajax') ) {  ?>
	<div class="atbssuga-offcanvas__section visible-xs visible-sm">
		<div class="text-center">
            <?php 
                $bk_home_url = esc_url(get_home_url('/'));
                $ajaxArgs = array(
                    'profile_link' => true,
                    'template' => 'modal',
                    'registration' => true,
                    'remember' => true,
                    'redirect'  => $bk_home_url
                );
                login_with_ajax($ajaxArgs);  
                if(!is_user_logged_in()) {
                    echo '<a href="#login-modal" class="btn btn-default" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person mdicon--first"></i><span>Login/Sign up</span></a>';
                }
            ?>
		</div>
	</div>
    <?php }?>
</div><!-- Off-canvas menu -->