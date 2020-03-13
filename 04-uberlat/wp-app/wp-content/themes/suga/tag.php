<?php
/**
 * The template for displaying Category archive pages
 *
 */
 ?>
<?php
    get_header();
    $tagID          = $wp_query->get_queried_object_id();

    $archiveLayout  = suga_archive::bk_get_archive_option($tagID, 'bk_archive_content_layout');
    $pagination     = suga_archive::bk_get_archive_option($tagID, 'bk_archive_pagination');
    $sidebar        = suga_archive::bk_get_archive_option($tagID, 'bk_archive_sidebar_select');
    $sidebarPos     = suga_archive::bk_get_archive_option($tagID, 'bk_archive_sidebar_position');
    $sidebarSticky  = suga_archive::bk_get_archive_option($tagID, 'bk_archive_sidebar_sticky'); 
    
    if($archiveLayout == '') {
        $archiveLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('suga_posts_'.$archiveLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'tag_id'            => $tagID,
		'post_type'         => array( 'post' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    suga_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">       
    <?php echo suga_archive::suga_archive_header($tagID);?>
    
    <?php if( ($archiveLayout == 'listing_list')       || 
              ($archiveLayout == 'listing_list_b')     || 
              ($archiveLayout == 'listing_list_c')     || 
              ($archiveLayout == 'listing_list_alt_a') || 
              ($archiveLayout == 'listing_list_alt_b') ||
              ($archiveLayout == 'listing_grid')       ||
              ($archiveLayout == 'listing_grid_small')
            ) {?>
    
    <div class="atbssuga-block atbssuga-block--fullwidth">
		<div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <div class="row">
                <div class="<?php if($sidebar_option != 'disable') echo 'atbssuga-main-col';?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block">
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo suga_archive::archive_main_col($archiveLayout, $moduleID, $pagination);?>
                        <?php echo suga_archive::bk_pagination_render($pagination);?>
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '</div>';
                        }
                        ?>
                    </div><!-- .atbssuga-block -->
                </div><!-- .atbssuga-main-col -->
                
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbssuga-sub-col atbssuga-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php 
                            dynamic_sidebar( $sidebar );
                        ?>
                    </div>
                </div> <!-- .atbssuga-sub-col -->
                <?php endif;?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbssuga-block -->
    <?php } elseif( 
              ($archiveLayout == 'listing_grid_no_sidebar')         ||
              ($archiveLayout == 'listing_grid_small_no_sidebar')   ||
              ($archiveLayout == 'listing_list_no_sidebar')         ||
              ($archiveLayout == 'listing_list_b_no_sidebar')       ||
              ($archiveLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($archiveLayout == 'listing_list_alt_b_no_sidebar')   
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block atbssuga-block--fullwidth">
        <?php
        if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo suga_archive::archive_fullwidth($archiveLayout, $moduleID, $pagination);
        echo suga_archive::bk_pagination_render($pagination);
        
        if($pagination == 'ajax-loadmore') {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .atbssuga-block -->
    <?php }?>
</div>

<?php get_footer(); ?>