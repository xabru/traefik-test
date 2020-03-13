<?php
    $suga_option = suga_core::bk_get_global_var('suga_option');
    if ((isset($suga_option['bk-footer-inverse'])) && (($suga_option['bk-footer-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    $footerScale = 1;
    if(isset($suga_option['footer-col-scale']) && ($suga_option['footer-col-2'] != '')) :
        $footerScale = $suga_option['footer-col-scale'];
    endif;
?> 
<footer class="site-footer footer-8 <?php if($inverseClass == "yes") echo " site-footer--inverse inverse-text";?>">
    <div class="site-footer__section site-footer__section--seperated">
		<div class="container">
			<div class="row row--space-between">
				<div class="col-xs-12 <?php if($footerScale == 1) echo 'col-md-4'; else echo 'col-md-6';?>">
					<?php 
                        if(isset($suga_option['footer-col-1']) && ($suga_option['footer-col-1'] != '')) :
                            dynamic_sidebar($suga_option['footer-col-1']); 
                        endif;
                    ?>
				</div>

				<div class="col-xs-12 <?php if($footerScale == 1) echo 'col-md-4'; else echo 'col-md-3';?>">
					<?php 
                        if(isset($suga_option['footer-col-2']) && ($suga_option['footer-col-2'] != '')) :
                            dynamic_sidebar($suga_option['footer-col-2']); 
                        endif;
                    ?>
				</div>

				<div class="col-xs-12 <?php if($footerScale == 1) echo 'col-md-4'; else echo 'col-md-3';?>">
					<?php 
                        if(isset($suga_option['footer-col-3']) && ($suga_option['footer-col-3'] != '')) :
                            dynamic_sidebar($suga_option['footer-col-3']); 
                        endif;
                    ?>
				</div>
			</div>
		</div>
	</div>
    
    <div class="site-footer__section site-footer__section--flex site-footer__section--bordered-inner">
		<div class="container">
			<div class="site-footer__section-inner">
                <?php if(isset($suga_option['footer-copyright-text']) && ($suga_option['footer-copyright-text'] != '')) :?>
                <div class="site-footer__section-left">
                    <?php
                        $suga_allow_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array()
                            ),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );
                        echo wp_kses($suga_option['footer-copyright-text'], $suga_allow_html);
                    ?>
                </div>
                <?php endif;?>
				<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                <div class="site-footer__section-right">
					<nav class="footer-menu">
                        <?php 
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-menu', 
                                'depth' => '1', 
                                'menu_class' => 'navigation navigation--footer navigation--inline',
                                )
                        ); 
                        ?>
					</nav>
				</div>
                <?php endif;?>
            </div>
		</div>
	</div>
</footer>
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