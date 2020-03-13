<?php
/**
 * The template for 404 page (Not Found).
 *
 */
?>
<?php
    get_header();
    $suga_option = suga_core::bk_get_global_var('suga_option');
    $logo   = suga_core::bk_get_theme_option('404-logo');
    $logoW   = suga_core::bk_get_theme_option('404-logo-width');
    $mainImage = suga_core::bk_get_theme_option('bk-404-image');
    $mainText = suga_core::bk_get_theme_option('404--main-text');
    $subText = suga_core::bk_get_theme_option('404--sub-text');
    $search = suga_core::bk_get_theme_option('404-search');
    
    $suga_allow_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'b'  => array(
            'class' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );
?>
<div class="site-content">
    <div class="container">
        <div class="page-404-logo site-logo text-center">
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
        <div class="page-404-image">
            <?php if (($mainImage != null) && (array_key_exists('url',$mainImage)) && ($mainImage['url'] != '')) {?>
                <img src="<?php echo esc_url($mainImage['url']);?>" alt="<?php esc_attr_e('404', 'suga');?>"/>
            <?php }else {?>
                <div class="page-404-title"><?php esc_html_e('404', 'suga');?></div>
            <?php } ?>
		</div>
        <div class="page-404-text text-center">
			<p>
				<?php echo wp_kses($mainText, $suga_allow_html);?>
			</p>
			<p>
				<?php echo wp_kses($subText, $suga_allow_html);?>
			</p>
		</div>
        <div class="page-404-search">
            <form class="search-form search-form--inline" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" name="s" class="search-form__input" placeholder="<?php esc_attr_e('Type here to search', 'suga');?>" value="">
                <button type="submit" class="search-form__submit btn btn-primary"><?php esc_html_e('Search', 'suga');?></button>
            </form>
		</div>
    </div>
</div>
<?php get_footer(); ?>