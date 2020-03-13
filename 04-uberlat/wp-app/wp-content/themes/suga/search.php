<?php
/**
 * The template for displaying Search Results pages.
 *
 */
 ?> 
<?php
    get_header();    
    $searchLayout   = suga_core::bk_get_theme_option('bk_search_content_layout');
    $pagination     = suga_core::bk_get_theme_option('bk_search_pagination');
    $sidebar        = suga_core::bk_get_theme_option('bk_search_sidebar_select');
    $sidebarPos     = suga_core::bk_get_theme_option('bk_search_sidebar_position');
    $sidebarSticky  = suga_core::bk_get_theme_option('bk_search_sidebar_sticky');
    
    if($searchLayout == '') {
        $searchLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $moduleID = uniqid('suga_posts_'.$searchLayout.'-');
    
    /* Search Count */ 
    $allsearch = new WP_Query("s=$s&showposts=0");
    $searchCount = $allsearch->found_posts;     
    
    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    $customArgs = array(
        's'                 => esc_attr($s),
		'post_type'         => array( 'post', 'page' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    suga_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
    
    $headingStyle  = suga_core::bk_get_theme_option('bk_search_header_style');
    $headingInverse = 'no';
    $headingClass = suga_core::bk_get_block_heading_class($headingStyle, $headingInverse);
    
    $headingColor  = suga_core::bk_get_theme_option('bk_search_heading__color');
?>
<div class="site-content">
	<div class="container">
        <div class="block-heading <?php echo esc_html($headingClass);?>">
    		<h2 class="page-heading__title block-heading__title" style="color: <?php echo esc_html($headingColor);?>;"><?php printf( esc_html__( 'Search for: %s', 'suga' ), get_search_query() ); ?></h2>
    		<div class="page-heading__subtitle"><?php echo (esc_html__('There are', 'suga') . ' ' . esc_attr($searchCount) . ' ' . esc_html__('results', 'suga'));?></div>
        </div>
	</div>
    <?php if( ($searchLayout == 'listing_list')       || 
              ($searchLayout == 'listing_list_b')     || 
              ($searchLayout == 'listing_list_c')     || 
              ($searchLayout == 'listing_list_alt_a') || 
              ($searchLayout == 'listing_list_alt_b') ||
              ($searchLayout == 'listing_grid')       ||
              ($searchLayout == 'listing_grid_small')
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
                        <?php echo suga_archive::archive_main_col($searchLayout, $moduleID, $pagination);?>
                        <?php echo suga_archive::bk_pagination_render($pagination);?>
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '</div><!-- .js-ajax-load-post -->';
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
              ($searchLayout == 'listing_grid_no_sidebar')         ||
              ($searchLayout == 'listing_grid_small_no_sidebar')   ||
              ($searchLayout == 'listing_list_no_sidebar')         ||
              ($searchLayout == 'listing_list_b_no_sidebar')       ||
              ($searchLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($searchLayout == 'listing_list_alt_b_no_sidebar')   
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="atbssuga-block atbssuga-block--fullwidth">
        <?php
        if( ($searchLayout == 'listing_grid_no_sidebar') || ($searchLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo suga_archive::archive_fullwidth($searchLayout, $moduleID, $pagination);
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