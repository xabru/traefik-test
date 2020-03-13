<?php
if (!class_exists('suga_feature_a')) {
    class suga_feature_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_feature_a-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config   
            $moduleConfigs['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = suga_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::suga_query($moduleConfigs);              //get query
            
    

            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-feature-a atbssuga-featured-slider-3-layout '.$moduleCustomClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                $block_str .= '</div>';
                $block_str .= '<div class="atbssuga-block__inner">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div><!-- .atbssuga-block__inner -->';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            
            $iconPosition = 'top-right';
            $iconPosition_L = '';
            $currentPost = 0;
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $catStyle_L = 4;
            $cat_Class_L = suga_core::bk_get_cat_class($catStyle_L);
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            } 
            $postOverlayHTML = new suga_overlay_2;
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-height-500 post--overlay-fullwidth post-grid-video-space-between',
                'cat'               => $catStyle_L,
                'catClass'          => $cat_Class_L,
                'thumbSize'         => 'suga-xl-2_1',
                'typescale'         => 'm-b-0-mobile-md',
                'except_length'     => 23,
                'additionalExcerptClass' => 'hidden-sm hidden-xs',
                'postIcon'          => $postIconAttr,  
            );           
            $postVerticalHTML = new suga_vertical_4;
            $postVerticalAttr = array (
                'additionalClass'   => '',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'postIcon'          => $postIconAttr,  
                'thumbSize'         => '',
            );
            $postHorizontalHTML = new suga_horizontal_2;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-xs post--horizontal-middle post__thumb-360 post__thumb-width-370 clearfix post--horizontal-text-background',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-1_1',
                'typescale'         => 'typescale-2 custom-typescale-2 m-b-0-mobile-sm',
                'except_length'     => 17,
                'additionalExcerptClass' => 'hidden-sm hidden-xs',
                'postIcon'          => $postIconAttr,  
                'readmore'          => 1,
            );
            
            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                if($currentPost == 0){
                    $render_modules .= '<div class="post-feature-top--overlay">';
                }
                
                if($currentPost == 1){
                    $render_modules .= '<div class="container">';
                    $render_modules .= '<div class="post-feature--wrap">';
                    $render_modules .= '<div class="post-feature--horizontal-has-background">';
                }
                
                if($currentPost == 2){
                    $carouselID = uniqid('carousel-');
                    $render_modules .= '<div class="post-feature-slide-small">';
                    $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel js-atbssuga-carousel-1i-dot-number atbssuga-carousel">';
                }
               
                if($currentPost == 0):
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'right-center';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        }
                        //$postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', 'right-center');
                        $postOverlayAttr['iconPosition']  = 'right-center';
                        
                        $postOverlayAttr['postIcon'] = $postIconAttr;
                    } 
                    $postOverlayAttr['postID'] = get_the_ID();
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    
                elseif(($currentPost == 1)):
                    if($bypassPostIconDetech != 1) {
                        $addClass = '';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    } 
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    
                elseif ($currentPost >= 2):
                    $postVerticalAttr['postID'] = get_the_ID();
                    $postVerticalAttr['additionalClass'] = 'post-slide--nothumb remove-margin-bottom-lastchild';
                    $postVerticalAttr['typescale'] = '';
                    $postVerticalAttr['additionalTextClass'] = 'remove-margin-bottom-lastchild';
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div><!-- .slide-content -->';                    
                endif;
                
                if(($currentPost == 0)):
                    $render_modules .= '</div><!-- post-feature-top--overlay -->';
                endif;
                
                if(($currentPost == 1)):
                    $render_modules .= '</div><!-- .post-feature--horizontal-has-background -->';
                endif;
               
            endwhile;
            
            if($currentPost == 1):
                $render_modules .= '</div><!-- .post-feature--wrap -->';
                $render_modules .= '</div><!-- .container -->';
            endif;
            
            if($currentPost >= 2):
                $render_modules .= '</div><!-- js-atbssuga-carousel-1i-dot-number -->';
                
                $render_modules .= '<div class="atbssuga-carousel-nav-custom-holder" data-carouselid="'.$carouselID.'">';
                $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-chevron-thin-left"></i></div>';
                $render_modules .= '<div id="numberSlide" class="owl-number"></div>';
                $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-chevron-thin-right"></i></div>';
                $render_modules .= '</div><!-- atbssuga-carousel-nav-custom-holder -->';
                
                $render_modules .= '</div><!-- post-feature-slide-small -->';
                
                $render_modules .= '</div><!-- .post-feature--wrap -->';
                $render_modules .= '</div><!-- .container -->';
            endif;
                
            return $render_modules;
        }
    }
}