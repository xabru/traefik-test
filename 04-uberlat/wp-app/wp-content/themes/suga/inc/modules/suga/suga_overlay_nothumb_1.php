<?php
if (!class_exists('suga_overlay_nothumb_1')) {
    class suga_overlay_nothumb_1 {
        
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
                <div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <div class="post__text-inner">
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                        <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link(get_the_ID());?></h3>
                        <?php 
                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                echo '<span class="entry-author">';
                                echo suga_core::bk_get_post_meta($postAttr['meta']);
                                echo '</span>';
                            endif;
                        ?>
                    </div>
                    <?php 
                        if (isset($postAttr['readmore']) && ($postAttr['readmore'] != '')) :
                    ?>
                    <div class="post__readmore">
                        <a href="<?php echo get_permalink($postID);?>" class="button__readmore">
                            <span class="readmore__text"><?php esc_html_e('Read more','suga'); ?><i class="mdicon mdicon-navigate_next"></i></span>
                        </a>
                    </div>        
                    <?php
                        endif;
                    ?>
                </div>
            </article>
            <?php return ob_get_clean();
        }
        
    }
}