<?php
if (!class_exists('suga_grid_b')) {
    class suga_grid_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_grid_b-');
            
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
            
            $moduleConfigs['module_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_style', true );
            
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
            
            if($moduleConfigs['module_style'] == 'style_2') {
                $moduleStyle = 'suga_grid_b_style_2';
            }else {
                $moduleStyle = '';
            }

            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-b atbssuga-post--grid-multiple-style__fullwidth '.$moduleCustomClass.' '.$moduleStyle.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                $block_str .= '</div>';
                $block_str .= '<div class="atbssuga-block__inner clearfix">';
                $block_str .= $this->render_top_block($the_query);            //render modules
                
                if ( $the_query->have_posts() ) :
                    $block_str .= $this->render_bottom_block($the_query);            //render modules
                endif;
                
                $block_str .= '</div><!-- atbssuga-block__inner -->';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_top_block ($the_query){
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
            
            $meta = 1;
            $metaArray = suga_core::bk_get_meta_list($meta);
            
            $postOverlayHTML = new suga_overlay_1;
            
            $postOverlayAttr = array (
                'additionalClass'   => '',
                'thumbSize'         => 'suga-xl-2_1',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'meta'              => $metaArray,
                'typescale'         => 'typescale-3 custom-typescale-3',
                'additionalTextClass'   => 'inverse-text text-center max-width-md',
                'postIcon'          => $postIconAttr,
            );
            
            $postVerticalHTML = new suga_vertical_1;
                                        
            $postVerticalAttr = array (
                'additionalClass' => 'post--nothumbnail',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-0 custom-typescale-0',
            );
            $render_modules = '';
            $currentPostIndex = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPostIndex = $the_query->current_post;
                if($currentPostIndex == 0) :
                    $render_modules .= '<div class="atbssuga-post--grid-multiple-style__fullwidth-a">';
                    if($bypassPostIconDetech != 1) :
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                        }
                        
                        if($iconPosition == 'left-bottom') {
                            $postOverlayHTML = new suga_overlay_icon_side_left;
                            if($postIconAttr['iconType'] != 'gallery') { 
                                $postIconAttr['postIconClass']  = 'post-type-icon--lg';
                            }else {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }
                            $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                        }else if($iconPosition == 'right-bottom') {
                            $postOverlayHTML = new suga_overlay_icon_side_right;
                            if($postIconAttr['iconType'] != 'gallery') { 
                                $postIconAttr['postIconClass']  = 'post-type-icon--lg';
                            }else {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }
                            $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                        }else {
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition);
                            }
                        }
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    endif;
                    $postOverlayAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="main-post post-fullwidth">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div><!-- .main-post post-fullwidth -->';
                elseif($currentPostIndex < 5) :
                    if($currentPostIndex == 1) :
                        $render_modules .= '<div class="sub-posts post-not-fullwidth"><div class="container">';
                        $render_modules .= '<div class="atbssuga-featured-with-list--horizontal-list">';
                        $render_modules .= '<ul class="posts-list list-unstyled">';
                    endif;
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_modules .= '<li>';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</li>';
                    
                    if($currentPostIndex == 4) :
                        $render_modules .= '</ul></div> <!-- .atbssuga-featured-with-list--horizontal-list -->';
                        $render_modules .= '</div></div><!-- .sub-posts -->';
                        $render_modules .= '</div> <!-- .atbssuga-post--grid-multiple-style__fullwidth-a -->';
                        break;
                    endif;
                endif;
                
            endwhile;
            
            if(($currentPostIndex > 0) && ($currentPostIndex < 4)) :
                $render_modules .= '</ul></div> <!-- .atbssuga-featured-with-list--horizontal-list -->';
                $render_modules .= '</div></div><!-- .sub-posts -->';
                $render_modules .= '</div> <!-- .atbssuga-post--grid-multiple-style__fullwidth-a -->';
            endif;
            
            return $render_modules;
        }
        public function render_bottom_block ($the_query){
            $render_modules = '';
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
            
            $postVerticalHTML = new suga_vertical_2;
                                        
            $postVerticalAttr = array (
                'additionalClass' => '',
                'thumbSize'     => 'suga-xs-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-2 custom-typescale-2 flexbox__item',
            );
            
            $currentPostIndex = '';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $currentPostIndex = $the_query->current_post - 5;
                
                if($currentPostIndex < 0) return '';
                
                if($currentPostIndex == 0) :
                    $postVerticalAttr['additionalClass'] = 'post__thumb-580';
                    $postVerticalAttr['thumbSize'] = 'suga-s-1_1';
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
                elseif($currentPostIndex == 3) :
                    $postVerticalAttr['additionalClass'] = 'post__thumb-450';
                    $postVerticalAttr['thumbSize'] = 'suga-s-1_1';
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
                else :
                    $postVerticalAttr['additionalClass'] = 'post__thumb-260';
                    $postVerticalAttr['thumbSize'] = 'suga-s-2_1';
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
                endif;
                
                if($currentPostIndex == 0) :
                    $render_modules .= '<div class="atbssuga-post--grid-multiple-style__fullwidth-b"><div class="container"><div class="row">';
                    $render_modules .= '<div class="col-md-6 col-sm-6 col-margin-bottom-xs"><div class="col-inner-left col-inner-padding--left">';
                     
                endif;
                
                if($currentPostIndex == 2) :
                    $render_modules .= '<div class="col-md-6 col-sm-6"><div class="col-inner-right col-inner-padding--right">';
                endif;
                
                
                $render_modules .= '<div class="post-item">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div><!-- .post-item -->';
                
                if(($currentPostIndex == 1) || ($currentPostIndex == 3)) :
                    $render_modules .= '</div></div><!-- End col-md-6 col-sm-6 -->';
                    
                endif;
                
                if($currentPostIndex == 3) :
                    $render_modules .= '</div></div></div><!-- .atbssuga-post--grid-multiple-style__fullwidth-b -->';
                    break;
                endif;
                
            endwhile;
            
            if(($currentPostIndex == 0) || ($currentPostIndex == 2)) :
                $render_modules .= '</div></div><!-- End col-md-6 col-sm-6 -->';
                 
            endif;
            
            if($currentPostIndex < 3) :
                $render_modules .= '</div></div></div><!-- .atbssuga-post--grid-multiple-style__fullwidth-b -->';
            endif;
            
            return $render_modules;
        }
    }
}