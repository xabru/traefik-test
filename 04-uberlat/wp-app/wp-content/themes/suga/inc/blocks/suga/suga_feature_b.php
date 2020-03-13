<?php
if (!class_exists('suga_feature_b')) {
    class suga_feature_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_feature_b-');
            
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
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-feature-b post-grid-3i-has-slider-fullwidth '.$moduleCustomClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                $block_str .= '</div>';
                $block_str .= '<div class="atbssuga-block__inner">';
                if($the_query->post_count <= 5):
                    $block_str .= $this->render_slider($the_query);            //render slider
                else: 
                    $block_str .= $this->render_slider($the_query, 'has-small-block');      //render slider
                    $block_str .= $this->render_small_block($the_query);                    //render small block
                endif;
                $block_str .= '</div><!-- .atbssuga-block__inner -->';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_slider ($the_query, $module_has_smallblock = ''){
            $carouselID = uniqid('carousel_feature_thumb_fullwidth-');
            
            $iconPosition = 'center';
            $currentPost = 0;
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }         
            $postOverlapHTML = new suga_overlap_1;
            $postOverlaplAttr = array (
                'additionalClass'   => 'post__fullwidth-text-center post__thumb-430 remove-margin-bottom-lastchild',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'postIcon'          => $postIconAttr,  
                'thumbSize'         => 'suga-m-16_9',
                'except_length'     => 23,
                'typescale'         => '',
                'additionalTextClass'       => 'post__text-background-logo remove-margin-bottom-lastchild',
                'additionalTextInnerClass'  => 'clearfix',
                'additionalExcerptClass'    => 'hidden-sm hidden-xs',
            );
            
            $render_modules = '';
            $currentPost = 'null';
            
            if($module_has_smallblock == '') :
                $totalItem = $the_query->post_count;
            else :
                $totalItem = $the_query->post_count - 4;
            endif;
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                if($currentPost == 0){
                    $render_modules .= '<div class="atbssuga-block-sub post-grid-3i-has-slider-fullwidth-a container-lg-custom">';
                    $render_modules .= '<div id="'.$carouselID.'" class="owl-carousel carousel_1i_stage_padding atbssuga-carousel">';
                }

                if($bypassPostIconDetech != 1) {
                    $addClass = '';
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, $addClass);
                    $postOverlaplAttr['postIcon'] = $postIconAttr;
                } 
                $postOverlaplAttr['postID'] = get_the_ID();
                   
                $render_modules .= '<div class="slide-content">';
                $render_modules .= $postOverlapHTML->render($postOverlaplAttr);   
                $render_modules .= '</div><!-- .slide-content -->';
                
                if($currentPost == $totalItem) :
                    break;
                endif;
                
            endwhile;
            
            if($currentPost != 'null'):
                $render_modules .= '</div><!-- .owl-carousel -->';
                
                $render_modules .= '<div class="suga-owl-background"></div>';
                $render_modules .= '<div class="atbssuga-carousel-nav-custom-holder" data-carouselid="'.$carouselID.'">';
                $render_modules .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-chevron-thin-left"></i></div>';
                $render_modules .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-chevron-thin-right"></i></div>';
                $render_modules .= '</div>';
                
                $render_modules .= '</div><!-- .atbssuga-block-sub -->';
            endif;
                
            return $render_modules;
        }
        
        public function render_small_block ($the_query, $module_has_smallblock = ''){
            $carouselID = uniqid('carousel_feature_thumb_fullwidth-');
            $currentPost = 0;
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            } 
            
            $postHorizontalHTML = new suga_horizontal_2;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-xxs post__thumb-width-80 post__thumb-80',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xxs-1_1',
                'typescale'         => 'typescale-0 custom-typescale-0',
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules = '';
            
            if($module_has_smallblock != '') :
                $totalItem = $the_query->post_count;
            else :
                $totalItem = $the_query->post_count - 3;
            endif;
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                if($currentPost == 0){
                    $render_modules .= '<div class="atbssuga-block-sub post-grid-3i-has-slider-fullwidth-b"><div class="container"><div class="post-list">';
                }
                $postHorizontalAttr['postID'] = get_the_ID();
                   
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);   
                $render_modules .= '</div><!-- .list-item -->';
                
                $currentPost ++;
                
            endwhile;
            
            $render_modules .= '</div><!-- .post-list -->';
            $render_modules .= '</div><!-- container -->';
            $render_modules .= '</div><!-- .atbssuga-block-sub -->';

            return $render_modules;
        }
    }
}