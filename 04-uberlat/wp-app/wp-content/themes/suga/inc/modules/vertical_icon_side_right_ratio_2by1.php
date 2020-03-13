<?php
if (!class_exists('atbs_vertical_icon_side_right_ratio_2by1')) {
    class atbs_vertical_icon_side_right_ratio_2by1 {
        
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
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = suga_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            ?>
            <article class="post post--vertical <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                 <?php if(isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb ratio-2by1">
                        <div class="background-img <?php if(isset($postAttr['additionalBGClass']) && ($postAttr['additionalBGClass'] != null)) echo esc_attr($postAttr['additionalBGClass']);?>" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 2)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                    </div>
                <?php endif;?>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
					<div class="media">
                        <div class="media-body media-middle">
							<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
                            <h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo suga_core::bk_get_post_title_link($postAttr['postID']);?></h3>
                                <?php
                                    if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                        echo '<div class="post__meta">';
                                        echo suga_core::bk_get_post_meta($postAttr['meta']);
                                        echo '</div>';
                                    endif;
                                ?> 
                        </div>
                        <div class="media-right media-middle">
							<?php 
                                if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) :
                                    echo suga_core::bk_get_post_icon($postID, $postAttr['postIcon']);               
                                endif;
                            ?>
						</div>    
                    </div>
				</div>
                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo suga_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}