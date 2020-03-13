<?php
if (!class_exists('suga_main_col_grid_a')) {
    class suga_main_col_grid_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_main_col_grid_a-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 4;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
     
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = suga_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
           //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'  => 'top-right',
                
            );
            
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
               
            $the_query = bk_get_query::suga_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-suga-main-col-grid-a atbssuga-post-latest-block atbssuga-post-latest-a '.$moduleCustomClass.'">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="atbssuga-block__inner">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- .atbssuga-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $catStyle_L = 4;
            $cat_Class_L = suga_core::bk_get_cat_class($catStyle_L);
            
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }    
            
            if ( $the_query->have_posts() ) :
                $postVerticalHTML = new suga_vertical_1;
                $postVerticalAttr = array (
                    'additionalClass'   => 'post--vertical-thumb-reverse post__thumb-180',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xs-2_1',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,  
                    'except_length'     => 17,
                );
                $postOverlayHTML = new suga_overlay_3;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-bottom post--overlay-height-460 post--overlay-author-top post--overlay-author-top-small',
                    'cat'               => $catStyle_L,
                    'catClass'          => $cat_Class_L,
                    'thumbSize'         => 'suga-s-1_1',
                    'typescale'         => '',
                    'except_length'     => 15,
                    'meta'              => array('author'),
                    'postIcon'          => $postIconAttr,  
                );
                
                $postHorizontalHTML = new suga_horizontal_2;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xxs post__thumb-70',
                    'thumbSize'         => 'suga-xs-1_1',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'additionalThumbClass' => 'margin-right-30',
                    'typescale'         => 'typescale-0 m-b-0',
                );
                        
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0):
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                            
                            $postVerticalAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="atbssuga-post-latest-a--top">';
                        $render_modules .= '<div class="post-list">';
                        
                        
                        $postVerticalAttr['postID'] = get_the_ID();
                        $postVerticalAttr['catClass'] .= ' cat-color-logo';
                        
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        
                    elseif($currentPost == 1):
                        $render_modules .= '<div class="list-item">';
                        $postOverlayAttr['postID']          = get_the_ID();
                        
                        if($bypassPostIconDetech != 1) :
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                            
                        endif;
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        
                        $render_modules .= '</div><!-- .post-list -->';
                        $render_modules .= '</div><!-- .atbssuga-post-latest-a--top -->';
                        
                    elseif($currentPost > 1):
                        if($currentPost == 2):
                            $render_modules .= '<div class="atbssuga-post-latest-a--body">';
                            $render_modules .= '<div class="post-list">';
                        endif;
                        
                        $render_modules .= '<div class="list-item">';
                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= $postHorizontalHTML -> render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->'; 
                        
                        if($currentPost == 3):
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-a--body -->';
                        endif;
                        
                    endif;

                endwhile;
                
                if($currentPost == 0):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-a--top -->';
                elseif($currentPost == 2):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-a--body -->';
                endif;
                
            endif;
            
            return $render_modules;
        }
    }
}