<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php
    get_header();
    
    $archiveLayout  = suga_core::bk_get_theme_option('bk_archive_content_layout');
    $headingStyle   = suga_core::bk_get_theme_option('bk_archive_header_style');
    $headingColor   = suga_core::bk_get_theme_option('bk_archive_heading__color');
    $sidebar        = suga_core::bk_get_theme_option('bk_archive_sidebar_select');
    $sidebarPos     = suga_core::bk_get_theme_option('bk_archive_sidebar_position');
    $sidebarSticky  = suga_core::bk_get_theme_option('bk_archive_sidebar_sticky'); 
    
    if($archiveLayout == '') {
        $archiveLayout = 'listing_list';
    }
    
    $sidebar_option = '';
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $headingInverse = 'no';
    $headingClass = suga_core::bk_get_block_heading_class($headingStyle, $headingInverse);
    
    $styleInline = '';
    if($headingColor != '') :
        $styleInline = 'style="color:'.$headingColor.';"';
    endif;
?>
<div class="site-content">    
    <div class="container">   
        <div class="block-heading <?php echo esc_html($headingClass);?>">
			<h2 class="page-heading__title block-heading__title" style="color: <?php echo esc_html($headingColor);?>;">
                <?php
                    if ( is_day() ) :
                		printf( esc_html__( 'Daily Archives: %s', 'suga' ), get_the_date() );
                	elseif ( is_month() ) :
                		printf( esc_html__( 'Monthly Archives: %s', 'suga' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'suga' ) ) );
                	elseif ( is_year() ) :
                		printf( esc_html__( 'Yearly Archives: %s', 'suga' ), get_the_date( _x( 'Y', 'yearly archives date format', 'suga' ) ) );
                    else :
                		esc_html_e( 'Archives', 'suga' );
                	endif;
                ?>                                
            </h2>
        </div>
	</div>
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
                <?php echo suga_archive::archive_main_col($archiveLayout);?>
                <?php
                    if (function_exists('suga_paginate')) {
                        echo suga_core::suga_get_pagination();
                    }
                ?>
                </div><!-- .atbssuga-main-col -->
                
                <?php if($sidebar_option != 'disable'):?>
                <div class="atbssuga-sub-col atbssuga-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php dynamic_sidebar( $sidebar );?>
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
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <?php
            if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') ) {
                echo '<div class="container">';
            }else {
                echo '<div class="container container--narrow">';
            }
            echo suga_archive::archive_fullwidth($archiveLayout);
            if (function_exists('suga_paginate')) {
                echo suga_core::suga_get_pagination();
            }
            echo '</div><!-- .container -->';
        ?>
    </div><!-- .atbssuga-block -->
    <?php }?>
        
</div>

<?php get_footer(); ?>