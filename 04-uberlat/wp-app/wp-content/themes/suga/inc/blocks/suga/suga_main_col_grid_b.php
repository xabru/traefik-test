<?php
if (!class_exists('suga_main_col_grid_b')) {
    class suga_main_col_grid_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_main_col_grid_b-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-suga-main-col-grid-b atbssuga-post-latest-block atbssuga-post-latest-b '.$moduleCustomClass.'">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="atbssuga-block__inner">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div><!-- .atbssuga-block__inner -->';
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
            
            $cat_Overlay_Style = 1;
            $cat_Overlay_Class = suga_core::bk_get_cat_class($cat_Overlay_Style);
            
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

                $postOverlayHTML = new suga_overlay_4;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-bottom post--overlay-sm post--overlay-height-300 post--overlay-padding-sm post--overlay-title-small',
                    'cat'               => $cat_Overlay_Style,
                    'catClass'          => $cat_Overlay_Class,
                    'thumbSize'         => 'suga-xs-1_1',
                    'typescale'         => 'typescale-0 custom-typescale-0',
                    'additionalTextClass'  => 'inverse-text',
                    'postIcon'          => $postIconAttr,  
                );
                
                $postHorizontalHTML = new suga_horizontal_2;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle post--horizontal-xxs post__thumb-70 post--horizontal-title-small',
                    'thumbSize'         => 'suga-xxs-1_1',
                    'additionalThumbClass' => 'margin-right-20',
                    'typescale'         => 'typescale-0 m-b-0',
                );
                
                $postHorizontalAttr_slider = array (
                    'additionalClass'   => 'post--horizontal-xs post__thumb-180 post__thumb-width-320 clearfix post--horizontal-center-slide',
                    'thumbSize'         => 'suga-xs-4_3',
                    'additionalThumbClass' => '',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'except_length'     => 15,
                );
                        
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    $maxPosts = $the_query->post_count;
                    
                    if(($currentPost >= 0) && ($currentPost < 3)) :
                        if($currentPost == 0):
                            $render_modules .= '<div class="atbssuga-post-latest-b--post-grid">';
                            $render_modules .= '<div class="atbssuga-post-latest-b--top">';
                            $render_modules .= '<div class="post-list">';
                        endif;
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, '');
                            
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                        }
                        
                        $postOverlayAttr['postID'] = get_the_ID();
                        $postOverlayAttr['catClass'] .= ' cat-color-logo';
                        
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .list-item -->';
                        
                        if($currentPost == 2):
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-b--top -->';
                                
                        endif;
                    elseif(($currentPost > 2) && ($currentPost < 9)):
                        if($currentPost == 3):
                            $render_modules .= '<div class="atbssuga-post-latest-b--body">';
                            $render_modules .= '<div class="post-list">';
                        endif;

                        $postHorizontalAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div><!-- .list-item -->';

                        if($currentPost == 8):
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-b--body -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-b--post-grid -->';
                        endif;
                        
                    elseif($currentPost > 8):
                        
                        if($currentPost == 9):
                            $render_modules .= '<div class="atbssuga-post-latest-b--post-slide">';
                            if($maxPosts == 10) :
                                $render_modules .= '<div class="atbssuga-carousel">';
                            else :
                                $render_modules .= '<div class="owl-carousel js-atbssuga-carousel-only-1i-loopdot atbssuga-carousel">';
                            endif;
                            
                         endif;
                         
                            $postHorizontalAttr_slider['postID'] = get_the_ID();
                            if($bypassPostIconDetech != 1) {
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                                }
        
                                $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, '');
                                
                                $postHorizontalAttr_slider['postIcon'] = $postIconAttr;
                            }
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_slider);
                            $render_modules .= '</div><!-- .slide-content -->';
   
                    endif;
                endwhile;
                if(($currentPost == 0) || ($currentPost == 1)):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--top -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--post-grid -->';
                elseif($currentPost == 2):
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--post-grid -->';
                elseif(($currentPost > 2) && ($currentPost < 8)):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--body -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--post-grid -->';
                elseif($currentPost >= 9):
                    $render_modules .= '</div><!-- .owl-carousel -->';
                    $render_modules .= '</div><!-- .atbssuga-post-latest-b--post-slide -->';
                endif;
                
            endif;
            
            return $render_modules;
        }
    }
}