<?php
/**
 * The template for displaying Category archive pages
 *
 */
 ?>
<?php
    get_header();
    $suga_option = suga_core::bk_get_global_var('suga_option');
    
    $paged = intval(get_query_var('paged'));
    if(empty($paged) || $paged == 0) {
        $paged = 1;
    }
    
    if (function_exists('get_queried_object_id')) :
        $catID          = get_queried_object_id();
    else:
        $catID          = $wp_query->get_queried_object_id();
    endif;
    
    $archiveLayout  = suga_archive::bk_get_archive_option($catID, 'bk_category_content_layout');
    $pagination     = suga_archive::bk_get_archive_option($catID, 'bk_category_pagination');
    $featLayout     = suga_archive::bk_get_archive_option($catID, 'bk_category_feature_area');
    $featAreaShowHide  = suga_archive::bk_get_archive_option($catID, 'bk_feature_area__show_hide');
    $sidebar        = suga_archive::bk_get_archive_option($catID, 'bk_category_sidebar_select');
    $sidebarPos     = suga_archive::bk_get_archive_option($catID, 'bk_category_sidebar_position');
    $sidebarSticky  = suga_archive::bk_get_archive_option($catID, 'bk_category_sidebar_sticky');
    $featAreaOption = suga_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
    
    if($archiveLayout == '') {
        $archiveLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('suga_posts_'.$archiveLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    if(function_exists('rwmb_meta')) {
        $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $catID );
    }else {
        $is_exclude = '';
    }
    if (isset($is_exclude) && ($is_exclude == 'global_settings')): 
        $is_exclude = $suga_option['bk_category_exclude_posts'];
    endif;
    if(($is_exclude == 1) || ($featAreaOption == 'latest')) {
        $excludeID = suga_archive::get_sticky_ids__category_feature_area($catID, $featLayout);
    }else {
        $excludeID = '';
    }
    
    $customArgs = array(
        'cat'               => $catID,
        'post__not_in'      => $excludeID,
		'post_type'         => array( 'post' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    suga_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
    <?php 
        echo suga_archive::suga_archive_header($catID);
        echo suga_archive::archive_feature_area($catID, $featLayout);
    ?>          
    
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
    <?php }else {?>
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <div class="row">
                <div class="<?php if($sidebar_option != 'disable') echo 'atbssuga-main-col';?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block">
                        <?php echo suga_archive::archive_main_col('listing_list', $moduleID, 'default');?>
                        <?php echo suga_archive::bk_pagination_render('default');?>
                    </div><!-- .atbssuga-block -->
                </div><!-- .atbssuga-main-col -->
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbssuga-sub-col atbssuga-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <div class="theiaStickySidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
                    </div>
                </div> <!-- .atbssuga-sub-col -->
                <?php endif;?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbssuga-block -->
    <?php }?>
</div>

<?php get_footer(); ?>