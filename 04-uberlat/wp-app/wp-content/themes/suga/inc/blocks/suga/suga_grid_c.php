<?php
if (!class_exists('suga_grid_c')) {
    class suga_grid_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_grid_c-');
            
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
            
    

            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-c atbssuga-post--grid-has-postlist '.$moduleCustomClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                
                $block_str .= '<div class="atbssuga-block__inner">';
                $block_str .= $this->render_big_vertical_posts_block($the_query, 'top');            //render modules
                $block_str .= $this->render_small_vertical_posts_block($the_query);            //render modules
                $block_str .= $this->render_big_vertical_posts_block($the_query, 'bottom');            //render modules
                $block_str .= '</div><!-- .atbssuga-block__inner -->';
                $block_str .= '</div>';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_big_vertical_posts_block($the_query, $position = ''){
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
                'additionalClass' => 'post__thumb-300',
                'thumbSize'     => 'suga-s-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-2 custom-typescale-2 flexbox__item',
            );
            
            $currentPostIndex = '';
                        
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($position == 'bottom') :
                    $currentPostIndex = $the_query->current_post - 5;
                else:
                    $currentPostIndex = $the_query->current_post;
                endif;
                
                if($currentPostIndex < 0) return '';
                                                
                if($currentPostIndex == 0) :
                    $render_modules .= '<div class="atbssuga-post-grid--vertical clearfix"><div class="row"><div class="col-md-6 col-sm-6 col-margin-bottom-xs">';
                endif;
                
                if($currentPostIndex == 1) :
                    $render_modules .= '<div class="col-md-6 col-sm-6">';
                endif;
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
                $render_modules .= '<div class="post-item">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div><!-- .post-item -->';
                $render_modules .= '</div><!-- col-md-6 col-sm-6 -->';
                
                if($currentPostIndex == 1) :
                    $render_modules .= '</div></div><!-- End atbssuga-post-grid--vertical -->';
                    break;
                endif;
                
            endwhile;
            
            if($currentPostIndex == 0) :
                $render_modules .= '</div></div><!-- End atbssuga-post-grid--vertical -->';
            endif;
            
            return $render_modules;            
        }
        public function render_small_vertical_posts_block($the_query){
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
            
            $postVerticalHTML = new suga_vertical_1;
                                        
            $postVerticalAttr = array (
                'additionalClass' => 'post--vertical-nothumb',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-0 custom-typescale-0',
                'except_length' => 15,
            );
            
            $currentPostIndex = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $currentPostIndex = $the_query->current_post - 2;
                
                if($currentPostIndex < 0) return '';
                
                if($currentPostIndex == 0) :
                    $render_modules .= '<div class="atbssuga-post-list--vertical clearfix"><div class="row">';
                    
                    $render_modules .= '<div class="col-md-2">';
                    $render_modules .= '<div class="block-heading block-title-small">';
                    $render_modules .= '<h4 class="block-heading__title typescale-2 custom-typescale-2">'.esc_html__('What', 'suga').' <span>'.esc_html__('to read?', 'suga').'</span></h4>';
                    $render_modules .= '</div>';
                    $render_modules .= '</div><!-- col-md-2 -->';
                    
                    $render_modules .= '<div class="col-md-10"><div class="post-lists">';
                endif;
                
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div><!-- .list-item -->';               
                
                if($currentPostIndex == 2) :
                    $render_modules .= '</div></div><!--col-md-10--></div></div><!-- End atbssuga-post-grid--vertical -->';
                    break;
                endif;
                
            endwhile;
            
            if(($currentPostIndex >= 0) && ($currentPostIndex < 2)) :
                $render_modules .= '</div></div><!--col-md-10--></div></div><!-- End atbssuga-post-grid--vertical -->';
            endif;
            
            return $render_modules;
        }
    }
}