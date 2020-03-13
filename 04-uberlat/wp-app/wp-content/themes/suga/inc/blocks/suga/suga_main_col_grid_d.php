<?php
if (!class_exists('suga_main_col_grid_d')) {
    class suga_main_col_grid_d {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_main_col_grid_d-');
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
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-post-latest-block atbssuga-suga-main-col-grid-d '.$moduleCustomClass.'">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="atbssuga-block__inner atbssuga-post-latest-d">';
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
            
            $cat_Overlay_Style = 3;
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

                $postVerticalHTML = new suga_vertical_1;
                $postVerticalAttr = array (
                    'additionalClass'   => 'post--vertical-slide-2i post__thumb-260',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class .' cat-color-logo',
                    'thumbSize'         => 'suga-s-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,
                );
                $postOverlayHTML  = new suga_overlay_nothumb_2;
                $postOverlay_noThumbAttr = array (
                    'additionalClass'   => 'post--nothumb-large-has-background post__thumb-80 post__thumb-width-80 clearfix',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class .' cat-color-logo',
                    'thumbSize'         => '',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'except_length'     => 15,
                    'meta'              => array('author'),
                );
                
                $postHorizontalHTML = new suga_horizontal_2;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-middle post--horizontal-xxs post__thumb-70 post--horizontal-title-small',
                    'thumbSize'         => 'suga-xxs-1_1',
                    'additionalThumbClass' => 'margin-right-20',
                    'typescale'         => 'typescale-0 m-b-0',
                );
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $currentPost = $the_query->current_post;
                    $maxPosts = $the_query->post_count;     
                    $activeClass = '';               
                    
                    if($currentPost == 0){
                        $render_modules .= '<div class="atbssuga-post-latest-d--post-slide">';
                        
                        if(($maxPosts == 1) || ($maxPosts == 2) || ($maxPosts == 5)) :
                            $render_modules .= '<div class="atbssuga-carousel-disable row">'; 
                            $itemW = 'col-sm-6';
                        else: 
                            $render_modules .= '<div class="owl-carousel js-carousel-2i30m atbssuga-carousel">'; 
                            $itemW = '';
                        endif;
                    }
                    if($bypassPostIconDetech != 1) :
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    endif;
                    if(($maxPosts < 5)){
                        $postVerticalAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="slide-content '.$itemW.'">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div><!-- .slide-content -->';
                        if($currentPost == ($maxPosts -1)){
                            $render_modules .= '</div><!-- .owl-carousel -->';
                            $render_modules .= '</div><!-- .atbssuga-post-latest-d--post-slide -->';
                        }
                    }elseif(($maxPosts > 4) && ($maxPosts < 8)){
                        if($currentPost < ($maxPosts - 3)){
                            $postVerticalAttr['postID'] = get_the_ID();
                            $render_modules .= '<div class="slide-content '.$itemW.'">';
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPost == ($maxPosts - 4)){
                                $render_modules .= '</div><!-- .owl-carousel -->';
                                $render_modules .= '</div><!-- .atbssuga-post-latest-d--post-slide -->';
                            }
                        }else {
                            
                            if($currentPost == ($maxPosts - 3)){
                                $render_modules .= '<div class="atbssuga-post-latest-d--post-grid">';
                                $render_modules .= '<div class="post-list">';
                                $activeClass .=' active';
                               
                            }
                            
                            $render_modules .= '<div class="list-item '.$activeClass.'">';
                            $postOverlay_noThumbAttr['postID'] = get_the_ID();
                            $render_modules .= $postOverlayHTML->render($postOverlay_noThumbAttr);
                            $render_modules .= '</div><!-- .list-item -->';
                            
                            if($currentPost == ($maxPosts - 1)){
                                $render_modules .= '</div> <!-- .post-list -->';
                                $render_modules .= '</div> <!-- .atbssuga-post-latest-d--post-grid -->';
                            }
                        }
                        
                    }else {
                        if($currentPost < ($maxPosts - 6)){
                            $postVerticalAttr['postID'] = get_the_ID();
                            $render_modules .= '<div class="slide-content '.$itemW.'">';
                            $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                            $render_modules .= '</div><!-- .slide-content -->';
                            if($currentPost == ($maxPosts - 7)){
                                $render_modules .= '</div><!-- .owl-carousel -->';
                                $render_modules .= '</div><!-- .atbssuga-post-latest-d--post-slide -->';
                            }
                        }elseif(($currentPost >= ($maxPosts - 6)) && ($currentPost < ($maxPosts - 3))){
                            if($currentPost == ($maxPosts - 6)){
                                $render_modules .= '<div class="atbssuga-post-latest-d--post-grid">';
                                $render_modules .= '<div class="post-list">';
                                $activeClass .=' active';
                           
                            }
                            $render_modules .= '<div class="list-item '.$activeClass.'">';
                            $postOverlay_noThumbAttr['postID'] = get_the_ID();
                            $render_modules .= $postOverlayHTML->render($postOverlay_noThumbAttr);
                            $render_modules .= '</div><!-- .list-item -->';
                            if($currentPost == ($maxPosts - 4)){
                                $render_modules .= '</div> <!-- .post-list -->';
                                $render_modules .= '</div> <!-- .atbssuga-post-latest-d--post-grid -->';
                            }
                        }else {
                            if($currentPost == ($maxPosts - 3)){
                                $render_modules .= '<div class="atbssuga-post-latest-d--post-small">';
                                $render_modules .= '<div class="post-list">';
                                
                            }
                            $render_modules .= '<div class="list-item ">';
                            $postHorizontalAttr['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                            $render_modules .= '</div><!-- .list-item -->';
                            if($currentPost == ($maxPosts - 1)){
                                $render_modules .= '</div> <!-- .post-list -->';
                                $render_modules .= '</div> <!-- .atbssuga-post-latest-d--post-small -->';
                            }
                        }
                                            
                    }

                endwhile;

  
            endif;
            
            return $render_modules;
            if($bypassPostIconDetech != 1) {
                $addClass = '';
                if($postSource != 'all') {
                    $postIconAttr['iconType'] = $postSource;
                }else {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                }
                $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                $postOverlaplAttr['postIcon'] = $postIconAttr;
            }
        }
    }
}