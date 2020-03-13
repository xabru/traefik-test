<?php
if (!class_exists('suga_horizontal_1')) {
    class suga_horizontal_1 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            
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
            
            <article class="post post--horizontal <?php if(!(suga_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != ''))) echo 'suga-horizontal--no-thumb';?> <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <?php if(suga_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
                <div class="post__thumb">
                    <div class="background-img <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                    <?php 
                    if($postIcon != '') :
                        echo suga_core::bk_get_post_icon($postID, $postIcon);
                    endif;
                    ?>
                    <a href="<?php echo get_permalink($postID);?>" class="link-overlay"></a>
                </div>
                <?php endif;?>
                <div class="post__text">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != null)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                    <h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) :?>
					<div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
						<?php echo suga_core::bk_get_post_excerpt($postAttr['except_length']);?>
					</div>
                    <?php endif;?>
                    <span class="entry-author <?php if(isset($postAttr['additionalAuthorClass']) && ($postAttr['additionalAuthorClass'] != null)) echo esc_attr($postAttr['additionalAuthorClass']);?>">
                        <?php 
                            if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                echo suga_core::bk_get_post_meta($postAttr['meta']);
                            endif;
                        ?>
                    </span>
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
            </article>
            
            <?php return ob_get_clean();
        }
        
    }
}