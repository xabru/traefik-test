<?php
/**
 * The template for displaying Author archive pages
 *
 */
 ?> 
<?php
    get_header();
    
    if (function_exists('get_queried_object_id')) :
        $authorID = get_queried_object_id();
    else:
        $authorID = $wp_query->get_queried_object_id();
    endif;
    
    $authorLayout   = suga_core::bk_get_theme_option('bk_author_content_layout');
    $pagination     = suga_core::bk_get_theme_option('bk_author_pagination');
    $sidebar        = suga_core::bk_get_theme_option('bk_author_sidebar_select');
    $sidebarPos     = suga_core::bk_get_theme_option('bk_author_sidebar_position');
    $sidebarSticky  = suga_core::bk_get_theme_option('bk_author_sidebar_sticky'); 
    
    if($authorLayout == '') {
        $authorLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('suga_posts_'.$authorLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'author'            => $authorID,
    	'post_type'         => array( 'post' ),
    	'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
    );
    suga_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
<?php if( ($authorLayout == 'listing_list')       || 
          ($authorLayout == 'listing_list_b')     || 
          ($authorLayout == 'listing_list_c')     || 
          ($authorLayout == 'listing_list_alt_a') || 
          ($authorLayout == 'listing_list_alt_b') ||
          ($authorLayout == 'listing_grid')       ||
          ($authorLayout == 'listing_grid_small')
        ) {?>
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <div class="row">
                <div class="<?php if($sidebar_option != 'disable') echo 'atbssuga-main-col';?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block">
                        <?php echo suga_archive::author_box($authorID);?>
                        
                        <div class="spacer-lg"></div>
                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo suga_archive::archive_main_col($authorLayout, $moduleID, $pagination);?>
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
              ($authorLayout == 'listing_grid_no_sidebar')         ||
              ($authorLayout == 'listing_grid_small_no_sidebar')   ||
              ($authorLayout == 'listing_list_no_sidebar')         ||
              ($authorLayout == 'listing_list_b_no_sidebar')       ||
              ($authorLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($authorLayout == 'listing_list_alt_b_no_sidebar')   
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block atbssuga-block--fullwidth">
        <?php
        if( ($authorLayout == 'listing_grid_no_sidebar') || ($authorLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        
        echo suga_archive::author_box($authorID);
        echo '<div class="spacer-lg"></div>';
        
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo suga_archive::archive_fullwidth($authorLayout, $moduleID, $pagination);
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