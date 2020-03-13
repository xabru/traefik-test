<?php
if (!class_exists('suga_overlay_icon_side_right')) {
    class suga_overlay_icon_side_right {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = suga_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
				<div class="background-img <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
				<div class="post__text inverse-text">
					<div class="post__text-wrap">
						<div class="post__text-inner <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                            <div class="media">
                                <div class="media-body media-middle">
                                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != '1')) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                                    <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link(get_the_ID());?></h3>
                                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                                    <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
                						<?php echo suga_core::bk_get_post_excerpt($postAttr['except_length']);?>
                					</div>
                                    <?php }?>
                                    <?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :?>
                                        <?php if (isset($postAttr['footerType']) && ($postAttr['footerType'] == '2-cols')) :?>
                            				<div class="post__meta <?php if(isset($postAttr['additionalMetaClass']) && ($postAttr['additionalMetaClass'] != null)) echo esc_attr($postAttr['additionalMetaClass']);?>">
                            					<div class="post__meta-left">
                            						<?php echo suga_core::bk_meta_cases($postAttr['meta'][0]);?>
                            					</div>
                            					<div class="post__meta-right">
                            						<?php echo suga_core::bk_meta_cases($postAttr['meta'][1]);?>
                            					</div>
                            				</div>
                                            
                                        <?php else:?>
                                            <div class="post__meta <?php if(isset($postAttr['additionalMetaClass']) && ($postAttr['additionalMetaClass'] != null)) echo esc_attr($postAttr['additionalMetaClass']);?>">
                                                <?php echo suga_core::bk_get_post_meta($postAttr['meta']);?>
                            				</div>
                                        <?php endif;?>
                                    <?php endif;?>
                                </div>
                                <?php 
                                if(isset($postAttr['postIcon']) && ($postAttr['postIcon']['iconType'] != 'gallery')) :
                                    echo '<div class="media-right media-middle">';
                                    echo suga_core::bk_get_post_icon($postID, $postAttr['postIcon']);
                                    echo '</div>';
                                endif;
                                ?>
                            </div>
						</div>
					</div>
				</div>
                <?php
                if(isset($postAttr['postIcon']) && ($postAttr['postIcon']['iconType'] == 'gallery')) :
                    echo suga_core::bk_get_post_icon($postID, $postAttr['postIcon']);
                endif;
                ?>
                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == '1')) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
				<a href="<?php echo esc_url($bk_permalink);?>" class="link-overlay"></a>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}