<?php 
    $suga_option = suga_core::bk_get_global_var('suga_option');
    $logo   = suga_core::bk_get_theme_option('bk-logo');
    $mobileLogo   = suga_core::bk_get_theme_option('bk-mobile-logo');
    $logoSOption  = suga_core::bk_get_theme_option('bk-site-logo-size-option');
    if($logoSOption == 'customize') {
        $logoW   = suga_core::bk_get_theme_option('site-logo-width');
    }else {
        $logoW = '';
    }
    if ((isset($suga_option['bk-header-inverse'])) && (($suga_option['bk-header-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    if ((isset($suga_option['bk-mobile-menu-inverse'])) && (($suga_option['bk-mobile-menu-inverse']) == 1)){ 
        $inverseClass_Mobile = 'yes';
    }else {
        $inverseClass_Mobile = '';
    }
    $sugaAds = 'enable';
    if((isset($suga_option['bk-header-ads'])) && ($suga_option['bk-header-ads'] == 1)) {
        $sugaAds = 'enable';
    }else {
        $sugaAds = 'disable';
    }
?>
<header class="site-header site-header--skin-4">
    <?php if (isset($suga_option['bk-header-bg-style']) && ($suga_option['bk-header-bg-style'] == 'image')) :?>
	<div class="background-img-wrapper">
		<div class="background-img"></div>
	</div>
    <?php endif;?>
    <!-- Header content -->
	<div class="header-main hidden-xs hidden-sm <?php if($inverseClass == "yes") echo " header-main--inverse";?>">
		<div class="container">
			<div class="row row--flex row--vertical-center">
				<div class="col-xs-4">
					<div class="site-logo header-logo text-left">
						<a href="<?php echo esc_url(get_home_url('/'));?>">
    						<!-- logo open -->
                            <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                    if ($logo['url'] != '') {
                                ?>
                                <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'suga');?>" <?php if($logoW != '') {echo 'width="'.esc_attr($logoW).'px"';}?>/>
                			<!-- logo close -->
                            <?php } else {?>
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                            <?php }
                            } else {?>
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                            <?php } ?>
    					</a>
					</div>
				</div>

				<div class="col-xs-8">
                    <?php if($sugaAds == 'enable') {?>
                        <div class="site-header__ads">
                            <?php if ( isset($suga_option ['bk-ads-html']) && !empty($suga_option ['bk-ads-html']) ){ ?>
            					<?php echo suga_core::suga_html_render($suga_option['bk-ads-html']);?>            						
                            <?php }?>
    					</div>
                    <?php }else {?>
    					<div class="site-header__social <?php if($inverseClass == "yes") echo " inverse-text";?>">
                            <?php if ( isset($suga_option ['bk-social-header']) && !empty($suga_option ['bk-social-header']) ){ ?>
            					<ul class="social-list list-horizontal text-right">
            						<?php echo suga_core::bk_get_social_media_links($suga_option['bk-social-header']);?>            						
            					</ul>
                            <?php }?>
    					</div>
                    <?php }?>
				</div>
			</div>
		</div>
	</div><!-- Header content -->
    <!-- Mobile header -->
    <div id="atbssuga-mobile-header" class="mobile-header visible-xs visible-sm <?php if($inverseClass_Mobile == "yes") echo " mobile-header--inverse";?>">
    	<div class="mobile-header__inner mobile-header__inner--flex">
            <!-- mobile logo open -->
    		<div class="header-branding header-branding--mobile mobile-header__section text-left">
    			<div class="header-logo header-logo--mobile flexbox__item text-left">
                    <a href="<?php echo esc_url(get_home_url('/'));?>">
                        <?php if (($mobileLogo != null) && (array_key_exists('url',$mobileLogo))) {
                            if ($mobileLogo['url'] != '') {
                        ?>                    
                        <img src="<?php echo esc_url($mobileLogo['url']);?>" alt="<?php esc_attr_e('logo', 'suga');?>"/>
                        <?php 
                        } else {?>
                                <span class="logo-text">
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                                </span>
                        <?php }
                        } else {?>
                            <span class="logo-text">
                            <?php echo esc_attr(bloginfo( 'name' ));?>
                            </span>
                        <?php } ?>                        
                    </a>               
    			</div>
    		</div>
            <!-- logo close -->
    		<div class="mobile-header__section text-right">
    			<button type="submit" class="mobile-header-btn js-search-popup">
    				<span class="hidden-xs"><?php esc_html_e('Search', 'suga');?></span><i class="mdicon mdicon-search mdicon--last hidden-xs"></i><i class="mdicon mdicon-search visible-xs-inline-block"></i>
    			</button>
                <?php if (is_active_sidebar('mobile-offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
    			<a href="#atbssuga-offcanvas-mobile" class="offcanvas-menu-toggle mobile-header-btn js-atbssuga-offcanvas-toggle">
    				<span class="hidden-xs">Menu</span><i class="mdicon mdicon-menu mdicon--last hidden-xs"></i><i class="mdicon mdicon-menu visible-xs-inline-block"></i>
    			</a>
                <?php endif;?>
    		</div>
    	</div>
    </div><!-- Mobile header -->
    
    <!-- Navigation bar -->
	<nav class="navigation-bar hidden-xs hidden-sm js-sticky-header-holder <?php if($inverseClass == "yes") echo " navigation-bar--inverse";?>">
		<div class="container">
			<div class="navigation-bar__inner">
                <?php if (is_active_sidebar('offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
                    <?php if ( isset($suga_option ['bk-offcanvas-desktop-switch']) && ($suga_option ['bk-offcanvas-desktop-switch'] != 0) ){ ?>
    				<div class="navigation-bar__section">
    					<a href="#atbssuga-offcanvas-primary" class="offcanvas-menu-toggle navigation-bar-btn js-atbssuga-offcanvas-toggle">
    						<i class="mdicon mdicon-menu"></i>
    					</a>
    				</div>
                    <?php }?>
                <?php endif;?>
				<div class="navigation-wrapper navigation-bar__section js-priority-nav">
					<?php 
                        if ( has_nav_menu( 'main-menu' ) ) : 
                            $menuSettings = array( 
                                'theme_location' => 'main-menu',
                                'container_id' => 'main-menu',
                                'menu_class'    => 'navigation navigation--main navigation--inline',
                                'walker' => new BK_Walker,
                            );
                            wp_nav_menu($menuSettings);
                        endif;
                    ?>
				</div>

				<div class="navigation-bar__section lwa lwa-template-modal">
                    <?php 
                        if ( function_exists('login_with_ajax') ) {  
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
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i></a>';
                            }
                    }?>
    				<button type="submit" class="navigation-bar-btn js-search-popup"><i class="mdicon mdicon-search"></i></button>
                </div>
			</div><!-- .navigation-bar__inner -->
		</div><!-- .container -->
	</nav><!-- Navigation-bar -->

</header><!-- Site header -->