<?php
if (!class_exists('suga_overlay_nothumb_2')) {
    class suga_overlay_nothumb_2 {
        
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
            <article class="post <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="post__text">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link(get_the_ID());?></h3>
                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                    <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
                    	<?php echo suga_core::bk_get_post_excerpt($postAttr['except_length']);?>
                    </div>
                    <?php }?>
                    <span class="entry-author <?php if(isset($postAttr['additionalAuthorClass']) && ($postAttr['additionalAuthorClass'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                        <?php 
                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                echo suga_core::bk_get_post_meta($postAttr['meta']);
                            endif;
                        ?>
                    </span> 
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}