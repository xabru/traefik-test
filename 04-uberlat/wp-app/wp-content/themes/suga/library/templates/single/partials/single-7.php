<?php
/*
Template Name: Single Template 7
*/
?>
<?php
    global $post;
    $suga_option = suga_core::bk_get_global_var('suga_option');
    $currentPost        = $post;
    $postID             = get_the_ID();      
    $catIDClass         = '';
    $bkEntryTeaser      = get_post_meta($postID,'bk_post_subtitle',true);
    
    $sidebar            =  suga_single::bk_get_post_option($postID, 'bk_post_sb_select');   
    $sidebarPos         =  suga_single::bk_get_post_option($postID, 'bk_post_sb_position');    
    $sidebarSticky      =  suga_single::bk_get_post_option($postID, 'bk_post_sb_sticky');
    
    $reviewBoxPosition  = get_post_meta($postID,'bk_review_box_position',true);
    
    //Switch
    $bkAuthorSW         = suga_single::bk_get_post_option($postID, 'bk-authorbox-sw');
    $bkPostNavSW        = suga_single::bk_get_post_option($postID, 'bk-postnav-sw');
    $bkRelatedSW        = suga_single::bk_get_post_option($postID, 'bk-related-sw');
    $bkSameCatSW        = suga_single::bk_get_post_option($postID, 'bk-same-cat-sw');
    
    $sugaExtension = '';
    if (!defined('SUGA_FUNCTIONS_PLUGIN_DIR')) :
        $sugaExtension = 'suga-no-extension';
    endif;
?>
<div class="site-content single-layout single-entry single-entry--billboard-overlap-title <?php echo esc_html($sugaExtension);?>">
    <?php if (suga_core::bk_check_has_post_thumbnail($postID)) {?>
    <div class="atbssuga-block atbssuga-block--fullwidth atbssuga-block--contiguous single-billboard single-billboard--sm">
		<?php
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
        <div class="background-img hidden-xs hidden-sm" style="background-image: url('<?php echo esc_url($theBGLinkXXL);?>');"></div>
		<div class="background-img hidden-md hidden-lg" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
	</div>
    <?php }?>
    <div class="atbssuga-block atbssuga-block--fullwidth single-entry-wrap">
        <div class="container">
            <div class="row">
                <div class="atbssuga-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <article <?php post_class('post--single');?>>
                        <header class="single-header">
                            <div class="single-header__inner">
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
                                echo suga_single::bk_entry_media($postID);
                            }
                         ?>
                         <div class="single-content">
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
                    </article><!-- .post-single -->
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
                    <?php
                        $sectionsSorter = $suga_option['single-sections-sorter']['enabled'];
 
                        if ($sectionsSorter): foreach ($sectionsSorter as $key=>$value) {
                         
                            switch($key) {
                         
                                case 'related': 
                                    if(($bkRelatedSW != '') && ($bkRelatedSW != 0)) {
                                        echo suga_single::bk_related_post($currentPost);
                                    }
                                    break;
                         
                                case 'comment': 
                                    comments_template();
                                break;
                         
                                case 'same-cat': 
                                    if(($bkSameCatSW != '') && ($bkSameCatSW != 0)) {
                                        echo suga_single::bk_same_category_posts($currentPost);
                                    }
                                break;
                                
                                default:
                                break;
                            }
                         
                        }
                        endif;
                    ?>
                </div><!-- .atbssuga-main-col -->
                
                <div class="atbssuga-sub-col sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
					<div class="theiaStickySidebar">
                        <?php 
                            dynamic_sidebar( $sidebar );
                        ?>
                    </div>
				</div><!-- .atbssuga-sub-col -->
            </div>
        </div>
    </div>
</div>