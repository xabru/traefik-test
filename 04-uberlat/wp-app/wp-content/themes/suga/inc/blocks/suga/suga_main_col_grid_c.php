<?php
if (!class_exists('suga_main_col_grid_c')) {
    class suga_main_col_grid_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_main_col_grid_c-');
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-post-latest-block atbssuga-suga-main-col-grid-c '.$moduleCustomClass.'">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="atbssuga-block__inner atbssuga-post-latest-c">';
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
            
            $cat_Overlay_Style = 4;
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

                $postOverlayHTML = new suga_overlay_3;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-height-370 has-score-badge-bottom post--grid-overlay-slide',
                    'additionalBGClass'   => 'background-img--darkened',
                    'cat'               => $cat_Overlay_Style,
                    'catClass'          => $cat_Overlay_Class,
                    'thumbSize'         => 'suga-s-4_3',
                    'typescale'         => '',
                    'additionalTextClass'  => 'inverse-text',
                    'postIcon'          => $postIconAttr,  
                );
                $postHorizontalHTML = new suga_horizontal_1;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-not-middle post--horizontal-reverse post__thumb-260 post__thumb-width-220 clearfix',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xs-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,  
                    'meta'              => array('author'),
                    'except_length'         => 15,
                    'additionalAuthorClass' => 'hidden-lg',
                    
                );
                $postHorizontalHTML_2 = new suga_horizontal_3;
                $postHorizontalAttr_2 = array (
                    'additionalClass'   => 'post--horizontal-thumb-margin-top post--horizontal-reverse post__thumb-80 post__thumb-width-80 clearfix',
                    'additionalThumbClass' => 'post__thumb-small hidden-md hidden-sm hidden-xs',
                    'additionalThumb2Class' => 'post__thumb-large hidden-lg',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xxs-1_1',
                    'thumbSize_mobile'  => 'suga-xs-1_1',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr, 
                    'except_length'         => 15, 
                    'meta'              => array('author'),
                    'additionalAuthorClass' => '',
                    
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    $maxPosts = $the_query->post_count;

                    if($currentPost == 0){
                        if(($maxPosts > 0) && ($maxPosts < 4)) :
                            $render_modules .= '<div class="atbssuga-post-latest-c--post-grid atbssuga-post-latest-c--post-grid-fw">';
                        else: 
                            $render_modules .= '<div class="atbssuga-post-latest-c--post-grid">';
                        endif;
                        
                        $render_modules .= '<div class="atbssuga-post-latest-c--post-grid-top">';
                        
                        if(($maxPosts == 1) || ($maxPosts == 4)) :
                            $render_modules .= '<div class="atbssuga-carousel">';  
                        else:
                            $render_modules .= '<div class="owl-carousel js-atbssuga-carousel-only-1i-loopdot atbssuga-carousel">';
                        endif;
                    }
                    
                    //begin if >= 4
                    if(($maxPosts >= 4)){    
                        if($currentPost < ($maxPosts - 3)){
                            if($bypassPostIconDetech != 1) {
                                $addClass = '';
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                                }
                                $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                                $postOverlayAttr['postIcon'] = $postIconAttr;
                            } 
                            $postOverlayAttr['postID'] = get_the_ID();
                            $render_modules .= '<div class="slide-content">';
                            $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPost == ($maxPosts - 4)){
                                $render_modules .= '</div><!-- .owl-carousel -->';
                                $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-grid-top -->';
                            }
                        }else if($currentPost == ($maxPosts - 3)){
                            $render_modules .= '<div class="atbssuga-post-latest-c--post-grid-body">';
                            $render_modules .= '<div class="post-item">';
                            $postHorizontalAttr['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                            $render_modules .= '</div><!-- .post-item -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-grid-body -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-grid -->';
                        }else {
                            if($currentPost == ($maxPosts - 2)){
                                $render_modules .= '<div class="atbssuga-post-latest-c--post-list">';
                                $render_modules .= '<div class="post-list">';
                            }
                            $render_modules .= '<div class="list-item">';
                            $postHorizontalAttr_2['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML_2->render($postHorizontalAttr_2);
                            $render_modules .= '</div><!-- .list-item -->';
                            if($currentPost == ($maxPosts - 1) ){
                                $render_modules .= '</div><!-- .post-list -->';
                                $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-list -->';
                            }  
                        }
                    }else {
                        $postOverlayAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="slide-content">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if($currentPost == ($maxPosts -1)){
                            $render_modules .= '</div><!-- .owl-carousel -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-grid-top -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-c--post-grid -->';
                        }
                    }
                    
                endwhile;
  
            endif;
            
            return $render_modules;
        }
    }
}