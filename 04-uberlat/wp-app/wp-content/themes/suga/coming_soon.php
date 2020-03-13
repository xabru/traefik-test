<?php
/*
Template Name: Coming Soon
*/
 ?> 
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
</head>
<?php
    $suga_option         = suga_core::bk_get_global_var('suga_option');
    $backgroundStyle    = suga_core::bk_get_theme_option('bk-coming-soon-bg-style');
    $backgroundBlur     = suga_core::bk_get_theme_option('bk-coming-soon-bg-blur-switch');
    if($backgroundBlur == 1) {
        $bgBlurClass = 'blurred-more';
    }else {
        $bgBlurClass = '';
    }
    
    if ((isset($suga_option['coming-soon-logo'])) && (($suga_option['coming-soon-logo']) != NULL)){ 
        $logo = $suga_option['coming-soon-logo'];
        if (($logo != null) && (array_key_exists('url',$logo))) {
            if ($logo['url'] == '') {
                $logo = suga_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $logo = suga_core::bk_get_theme_option('bk-logo');
    }
    $logoW  = suga_core::bk_get_theme_option('coming-soon-logo-width');
    $csText = suga_core::bk_get_theme_option('coming-soon-introduction--main-text');
    $csDate = suga_core::bk_get_theme_option('coming-soon--date');
    $mailchimpShortcode = suga_core::bk_get_theme_option('bk-coming-soon-mailchimp-shortcode');
?>
<body class="page page-coming-soon">
    <!-- .site-wrapper -->
    <div class="site-wrapper">
        
        <div class="background-img">
            <?php 
            if($backgroundStyle == 'image') :
                echo '<div class="background-img background-img--darkened '.$bgBlurClass.'"></div>';
            elseif($backgroundStyle == 'gradient') :
                echo '<div class="background-img background-img--darkened '.$bgBlurClass.'"></div>';
                echo '<div class="background-overlay"></div>';
            elseif($backgroundStyle == 'color') :
                echo '';
            else :
                echo '<div class="background-overlay gradient-5"></div>';
            endif;
            ?>
    	</div>
        
        <div class="page-content inverse-text">
    		<div class="container">
    			<div class="site-logo text-center">
                    <a href="<?php echo esc_url( home_url('/') ); ?>">
                        <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                if ($logo['url'] != '') {
                            ?>
                            <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'suga');?>"  width="<?php echo esc_attr($logoW);?>"/>
                		<!-- logo close -->
                        <?php } else {?>
                            <?php echo esc_attr(bloginfo( 'name' ));?>
                        <?php }
                        } else {?>
                            <?php echo esc_attr(bloginfo( 'name' ));?>
                        <?php } ?>
                    </a>
    			</div>
    
    			<div class="introduction text-center">
                    <p class="typescale-4"><?php echo esc_attr($csText);?></p>
    				<br>
                    <?php if ( isset($suga_option ['bk-coming-soon--social']) && ($suga_option ['bk-coming-soon--social'] != '') ){ ?>
            		<ul class="social-list social-list--circle social-list--md list-center">
            			<?php echo suga_core::bk_get_social_media_links($suga_option['bk-coming-soon--social']);?>
            		</ul>
                    <?php }?>
    			</div>
                <?php if($csDate != '') {?>
    			<div class="atbssuga-countdown">
    				<div class="atbssuga-countdown__inner meta-font js-countdown" data-countdown="<?php echo esc_attr($csDate);?>"></div>
    			</div>
                <?php }?>
                <?php if($mailchimpShortcode != '') {?>
    			<div class="subscribe-form subscribe-form--horizontal text-center max-width-sm">
    				<?php echo do_shortcode($mailchimpShortcode);?>
    			</div>
                <?php }?>
    		</div>
    	</div>
    </div>
<?php wp_footer(); ?>
</body>
</html>