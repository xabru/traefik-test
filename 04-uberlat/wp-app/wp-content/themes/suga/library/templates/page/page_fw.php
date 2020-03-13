<?php
/**
 * The Default Page Template -- With Sidebar page template
 *
 */
 ?>
<?php
    $pageID  = get_the_ID();
    
    $headerStyle    = suga_single::bk_get_post_option($pageID, 'bk_page_header_style');
    $headingColor   = suga_core::bk_get_theme_option('bk_default_page_heading__color');
    $sidebar        = suga_single::bk_get_post_option($pageID, 'bk_page_sidebar_select');
    $sidebarPos     = suga_single::bk_get_post_option($pageID, 'bk_page_sidebar_position');
    $sidebarSticky  = suga_single::bk_get_post_option($pageID, 'bk_page_sidebar_sticky'); 
    $featuredImage  = suga_single::bk_get_post_option($pageID, 'bk_page_feat_img');       
?>
<div class="atbssuga-block atbssuga-block--fullwidth">
	<div class="container">
        <?php echo suga_archive::render_page_heading($pageID, $headerStyle, $headingColor);?>
        <article <?php post_class('post--single');?>>
            <div class="single-content">
                <?php
                    if ( ($featuredImage != 0) && suga_core::bk_check_has_post_thumbnail($pageID)) {
                        echo '<div class="entry-thumb single-entry-thumb">';
                        echo get_the_post_thumbnail($pageID, 'suga-m-2_1');
        				echo '</div>';
                    }
                ?>
				<div class="entry-content typography-copy">
                    <?php the_content();?>
                </div>
                <?php echo suga_single::bk_post_pagination();?>
            </div>
        </article>
        <?php if(comments_open()) {?>
                <?php comments_template(); ?>
        <?php }?>
    </div> <!-- .container -->
</div><!-- .atbssuga-block -->