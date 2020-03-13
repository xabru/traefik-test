<?php
/*
Template Name: Single Template 3 -- No Sidebar
*/
?>
<?php
    global $post;
    $suga_option = suga_core::bk_get_global_var('suga_option');
    $currentPost        = $post;
    $postID             = get_the_ID();      
    $catIDClass         = '';
    $bkEntryTeaser      = get_post_meta($postID,'bk_post_subtitle',true);
    
    $reviewBoxPosition  = get_post_meta($postID,'bk_review_box_position',true);
    
    //Switch
    $bkAuthorSW         = suga_single::bk_get_post_option($postID, 'bk-authorbox-sw');
    $bkPostNavSW        = suga_single::bk_get_post_option($postID, 'bk-postnav-sw');
    $bkRelatedSW        = suga_single::bk_get_post_wide_option($postID, 'bk-related-sw');
    $bkSameCatSW        = suga_single::bk_get_post_wide_option($postID, 'bk-same-cat-sw');
    
    $featuredImageSTS   = suga_single::bk_get_post_option($postID, 'bk-feat-img-status');
    
    $sugaExtension = '';
    if (!defined('SUGA_FUNCTIONS_PLUGIN_DIR')) :
        $sugaExtension = 'suga-no-extension';
    endif;
?>
<div class="site-content single-entry single-entry--no-sidebar <?php echo esc_html($sugaExtension);?>">
    <div class="atbssuga-block atbssuga-block--fullwidth single-entry-wrap <?php echo esc_html($sugaExtension);?>">
        
        <article <?php post_class('post--single');?>>
            <header class="single-header--body single-header">
                <div class="container container--narrow">
                    <?php 
                        $catClass = 'post__cat cat-theme';
                        echo suga_core::bk_get_post_cat_link($postID, $catClass, true);
                    ?>
                    <h1 class="entry-title post__title"><?php echo get_the_title($postID);?></h1>
                    
                                
                    <div class="entry-meta">
                        <?php 
                            echo suga_core::bk_get_post_meta(array('author', 'date_without_icon'));
                        ?>
                        
                    </div>
                </div>
            </header>
            <?php
                if(function_exists('has_post_format')){
                    $postFormat = get_post_format($postID);
                }else {
                    $postFormat = 'standard';
                } 
                if(($postFormat == 'video') || ($postFormat == 'gallery')) {
                    echo '<div class="container">';
                    echo suga_single::bk_entry_media($postID, 'suga-xl-2_1');
                    echo '</div>';
                }else {
                    $featImgCaption = get_the_post_thumbnail_caption($postID);
                    if (($featuredImageSTS != 0) && (suga_core::bk_check_has_post_thumbnail($postID))) {
                        $thumbAttrXXL = array (
                            'postID'        => $postID,
                            'thumbSize'     => 'suga-xxl',                                
                        );
                        $thumbAttr = array (
                            'postID'        => $postID,
                            'thumbSize'     => 'suga-l-4_3',                                
                        );            
                        $theBGLinkXXL   = suga_core::bk_get_post_thumbnail_bg_link($thumbAttrXXL);
                        $theBGLink      = suga_core::bk_get_post_thumbnail_bg_link($thumbAttr); 
                        ?>
                        <div class="atbssuga-block atbssuga-block--fullwidth single-billboard">
                            <div class="background-img hidden-xs hidden-sm" style="background-image: url('<?php echo esc_url($theBGLinkXXL);?>');"></div>
                            <div class="background-img hidden-md hidden-lg" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                        </div>
                        <?php
                    }
                }
            ?>
            <div class="single-content container container--narrow">
                <?php
                    if ( function_exists( 'suga_extension_single_entry_interaction__sticky_share_box' ) ) {
                        echo suga_extension_single_entry_interaction__sticky_share_box(get_the_ID(), 'js-sticky-sidebar share-box-2');
                    }
                ?>
                <div class="single-content-right">
                    <div class="single-body entry-content typography-copy">
                        <?php 
                            if(($reviewBoxPosition == 'aside-left') || ($reviewBoxPosition == 'aside-right')) {
                                echo suga_single::bk_post_review_box_aside($postID, $reviewBoxPosition);
                            }
                        ?>
                        <?php the_content();?>
					</div>
                    <?php echo suga_single::bk_post_pagination();?>
                    <?php 
                        if($reviewBoxPosition == 'default') {
                            echo suga_single::bk_post_review_box_default($postID);
                        }
                    ?>
                    <?php get_template_part( 'library/templates/single/single-footer');?>
                </div>
            </div><!-- .single-content -->
            <div class="container container--narrow">
                <?php 
                    if(($bkPostNavSW != '') && ($bkPostNavSW != 0)) {
                        echo suga_single::bk_post_navigation();
                    }
                ?>
                <?php 
                    if(($bkAuthorSW != '') && ($bkAuthorSW != 0)) {
                        echo suga_single::bk_author_box($currentPost->post_author);
                    }
                ?>
            </div>
        </article><!-- .post-single -->
       
        
        <?php
            $sectionsSorter = $suga_option['single-sections-sorter']['enabled'];

            if ($sectionsSorter): foreach ($sectionsSorter as $key=>$value) {
             
                switch($key) {
             
                    case 'related': 
                        if(($bkRelatedSW != '') && ($bkRelatedSW != 0)) {
                            echo suga_single::bk_related_post_wide($currentPost);
                        }
                        break;
             
                    case 'comment': 
                        comments_template();
                    break;
             
                    case 'same-cat': 
                        if(($bkSameCatSW != '') && ($bkSameCatSW != 0)) {
                            echo suga_single::bk_same_category_posts_wide($currentPost);
                        }
                    break;
                    
                    default:
                    break;
                }
             
            }
            endif;
        ?>
    </div>
</div>