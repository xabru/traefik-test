<?php
if (!class_exists('suga_overlay_2')) {
    class suga_overlay_2 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
            }else {
                $postIcon = '';
            }
            
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
        
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = suga_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post post--overlay <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="background-img <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                <div class="post__text">
                    <div class="post__text-inner overlay-center-y">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link(get_the_ID());?></h3>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                        <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
    						<?php echo suga_core::bk_get_post_excerpt($postAttr['except_length']);?>
    					</div>
                        <?php }?>
                    </div>
                    <?php 
                    if(($postIcon != '') && (isset($postAttr['iconPosition'])) && ($postAttr['iconPosition'] == 'right-center')) :
                        echo suga_core::bk_get_post_icon($postID, $postIcon);
                    endif;
                    ?>
                </div>
                <a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}