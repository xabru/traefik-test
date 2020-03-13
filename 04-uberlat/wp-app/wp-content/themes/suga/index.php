<?php
/**
 * Index Page -- Latest Page
 *
 */
 ?>
<?php get_header();?>
<?php
$sidebar_option = '';
if(!is_active_sidebar('home_sidebar')) {
    $sidebar_option = 'disable';
}
?>
<div class="site-content">
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <div class="container <?php if($sidebar_option == 'disable') echo 'container--narrow';?>">
            <div class="row">
                <div class="<?php if($sidebar_option != 'disable'): echo 'atbssuga-main-col'; else: echo 'container--narrow-inner'; endif;?>" role="main">
                <?php //echo suga_archive::archive_main_col('listing_list');?>
                <?php
                    $cat = 3; //Above the Title - No BG
                    $cat_Class = suga_core::bk_get_cat_class($cat);
                ?>
                <div class="posts-list list-unstyled list-space-xl">
                    <?php while (have_posts()): the_post(); $postID = get_the_ID();?>
                    <div class="list-item">
                        <article class="post post--horizontal <?php if(is_sticky($postID)) echo 'sticky-suga-post';?>">
                            <?php if(suga_core::bk_check_has_post_thumbnail($postID)) :?>
                            <div class="post__thumb">
                                <?php echo suga_core::get_feature_image($postID, 'suga-xs-4_3', true);?>
                            </div>
                            <?php endif;?>
                            <div class="post__text">
                                <?php echo suga_core::bk_get_post_cat_link($postID, $cat_Class);?>
                                <?php if(is_sticky($postID)) echo '<span class="sugaStickyMark"><i class="mdicon mdicon-fire"></i></span>';?>
                                <h3 class="post__title typescale-2">
                                    <?php echo suga_core::bk_get_post_title_link($postID);?>
                                </h3>
                                <div class="post__excerpt">
                                    <?php echo suga_core::bk_get_post_excerpt(23);?>
                                </div>
                                <div class="post__meta">
                                    <?php echo suga_core::bk_get_post_meta(array('author', 'date'));?>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php endwhile;?>
                </div>
                <?php
                    if (function_exists('suga_paginate')) {
                        echo suga_core::suga_get_pagination();
                    }
                ?>
                </div><!-- .atbssuga-main-col -->
                
                <?php if($sidebar_option != 'disable') : ?>
                <div class="atbssuga-sub-col atbssuga-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php dynamic_sidebar( 'home_sidebar' );?>
                    </div>
                </div> <!-- .atbssuga-sub-col -->
                <?php endif;?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbssuga-block -->
</div>
<?php get_footer();?>