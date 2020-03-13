<?php
if (!class_exists('suga_feature_slider_b')) {
    class suga_feature_slider_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_feature_slider_b-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config   
            $moduleConfigs['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
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
            
            if($moduleConfigs['limit'] > 1) :
                $carouselEn__Class = 'owl-carousel js-carousel-1i30m';
            else :
                $carouselEn__Class = '';                            
            endif;

            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-feature-slider-b atbssuga-post-slider '.$moduleCustomClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                $block_str .= '<div class="atbssuga-block__inner clearfix">';
                $block_str .= '<div class="atbssuga-post-slide">';
                $block_str .= '<div class="atbssuga-carousel-heading-aside">';
                $block_str .= '<div class="carousel-wrap">';
                $block_str .= '<div id="carousel-1" class="owl-carousel atbssuga-carousel js-atbssuga-carousel-1i">';
                $block_str .= $this->render_modules($the_query);    //render modules
                $block_str .= '</div>';
                $block_str .= '<div class="atbssuga-carousel-nav-custom-holder flexbox flexbox--middle" data-carouselid="carousel-1">';
                $block_str .= '<div class="owl-prev js-carousel-prev">'.esc_html__('PREVIOUS',('suga')).'</div>';
                $block_str .= '<span class="line-skew"></span>';
                $block_str .= '<div class="owl-next js-carousel-next">'.esc_html__('NEXT',('suga')).'</div>';
                $block_str .= '</div>';
                $block_str .= '</div><!-- carousel-wrap -->';
                $block_str .= '</div><!-- .atbssuga-carousel-heading-aside -->';
                $block_str .= '</div><!-- .atbssuga-post-slide -->';
                $block_str .= '</div>';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            
            $iconPosition = 'top-right';
            
           
                        
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);

            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }            
            
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post__thumb-480',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-m-4_3',
                'typescale'         => 'typescale-3 custom-typescale-3',
                'except_length'     => 15,
                'meta'              => array('author'),
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                if($bypassPostIconDetech != 1) {
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    }

                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition, '');
                    
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                } 
                $render_modules .= '<div class="slide-content">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            return $render_modules;
        }
    }
}