<?php
if (!class_exists('suga_vertical_1')) {
    class suga_vertical_1 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
            }else {
                $postIcon = '';
            }
            if(isset($postAttr['meta_seperator']) && ($postAttr['meta_seperator'] != '')) {
                $metaSeperator = 1;
            }else {
                $metaSeperator = 0;
            }
            ?>
            <article class="post post--vertical <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                 <?php if(suga_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo suga_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 2)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                        <?php 
                        if($postIcon != '') :
                            echo suga_core::bk_get_post_icon($postID, $postIcon);
                        endif;
                        ?>
                    </div>
                <?php endif;?>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
					<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
					<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link($postAttr['postID']);?></h3>
					<?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                    <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
						<?php echo suga_core::bk_get_post_excerpt($postAttr['except_length']);?>
					</div>
                    <?php }?>
                    <?php
                    if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                        echo '<div class="post__meta">';
                        echo suga_core::bk_get_post_meta($postAttr['meta'], $metaSeperator);
                        echo '</div>';
                    endif;
                    ?>
				</div>
                <?php if(suga_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}