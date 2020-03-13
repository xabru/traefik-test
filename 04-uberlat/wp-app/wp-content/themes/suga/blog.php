<?php
/*
Template Name: Blog
*/
 ?> 
<?php
    get_header();
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&post_status=publish&paged=' . $paged);
    
    $sticky = get_option('sticky_posts') ;
    rsort( $sticky );
    
    $pageID         = get_the_ID();
    $headerStyle    = suga_single::bk_get_post_option($pageID, 'bk_blog_header_style');
    $blogLayout     = suga_core::bk_get_theme_option('bk_blog_content_layout');
    $pagination     = suga_core::bk_get_theme_option('bk_blog_pagination');
    $sidebar        = suga_core::bk_get_theme_option('bk_blog_sidebar_select');
    $sidebarPos     = suga_core::bk_get_theme_option('bk_blog_sidebar_position');
    $sidebarSticky  = suga_core::bk_get_theme_option('bk_blog_sidebar_sticky'); 
    
    if($blogLayout == '') {
        $blogLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('suga_posts_'.$blogLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'post__not_in'      => $sticky,
    	'post_type'         => array( 'post' ),
    	'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
    );
    suga_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
    <?php echo suga_archive::render_page_heading($pageID, $headerStyle);?>
    <?php if( ($blogLayout == 'listing_list')       || 
                  ($blogLayout == 'listing_list_b')     || 
                  ($blogLayout == 'listing_list_c')     || 
                  ($blogLayout == 'listing_list_alt_a') || 
                  ($blogLayout == 'listing_list_alt_b') ||
                  ($blogLayout == 'listing_grid')       ||
                  ($blogLayout == 'listing_grid_small')
                ) {?>
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <div class="row">
                <div class="<?php if($sidebar_option != 'disable') echo 'atbssuga-main-col';?> <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block suga_latest_blog_posts">                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo suga_archive::archive_main_col($blogLayout, $moduleID, $pagination);?>
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
          ($blogLayout == 'listing_grid_no_sidebar')         ||
          ($blogLayout == 'listing_grid_small_no_sidebar')   ||
          ($blogLayout == 'listing_list_no_sidebar')         ||
          ($blogLayout == 'listing_list_b_no_sidebar')       ||
          ($blogLayout == 'listing_list_alt_a_no_sidebar')   ||
          ($blogLayout == 'listing_list_alt_b_no_sidebar')   
        ) { ?>

    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block atbssuga-block--fullwidth suga_latest_blog_posts">
        <?php
        if( ($blogLayout == 'listing_grid_no_sidebar') || ($blogLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
                
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo suga_archive::archive_fullwidth($blogLayout, $moduleID, $pagination);
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