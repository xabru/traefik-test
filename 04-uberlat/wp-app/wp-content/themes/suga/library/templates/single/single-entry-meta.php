<!-- Entry meta -->
<?php
    global $post; //$post->post_author
    $suga_option = suga_core::bk_get_global_var('suga_option');
    $postID = get_the_ID();
    $bk_author_name = get_the_author_meta('display_name', $post->post_author);
    $authorImgALT = $bk_author_name;
    $authorArgs = array(
        'class' => 'entry-author__avatar',
    );
    $suga_article_date_unix = get_the_time('U', $postID);
    $suga_meta_items = 8;
    if(isset($suga_option['bk-single-meta-items'])):
        $suga_meta_case = $suga_option['bk-single-meta-items'];
        $suga_meta_items = suga_core::bk_get_meta_list($suga_meta_case);
    endif;
?>
<div class="entry-meta">
	<span class="entry-author entry-author--with-ava">
        <?php 
            echo get_avatar($post->post_author, '34', '', $authorImgALT, $authorArgs);
            echo esc_html__('By', 'suga');
            
            //function coauthors_posts_links( $between = null, $betweenLast = null, $before = null, $after = null, $echo = true )
            if(function_exists('coauthors_posts_links')){
                  echo coauthors_posts_links(', ', esc_html__(' and ', 'suga'), ' ', ' ', false);
            }
            else {
                  echo ' <a class="entry-author__name" title="Posts by '.esc_attr($bk_author_name).'" rel="author" href="'.get_author_posts_url($post->post_author).'">'.esc_attr($bk_author_name).'</a>';
            }  
                                                        
            
        ?>
    </span>
    <?php
        echo suga_core::bk_get_post_meta($suga_meta_items);
    ?>
</div>