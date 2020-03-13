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
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
?>
<div class="atbssuga-block atbssuga-block--fullwidth">
	<div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
        <?php echo suga_archive::render_page_heading($pageID, $headerStyle, $headingColor);?>
		<div class="row">
			<div class="<?php if($sidebar_option != 'disable') echo 'atbssuga-main-col';?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
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
            </div><!-- .atbssuga-main-col -->
            
            <?php if($sidebar_option != 'disable'):?>
            <div class="atbssuga-sub-col sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
				<?php 
                    dynamic_sidebar( $sidebar );
                ?>
			</div><!-- .atbssuga-sub-col -->
            <?php endif;?>
        </div>
    </div> <!-- .container -->
</div><!-- .atbssuga-block -->