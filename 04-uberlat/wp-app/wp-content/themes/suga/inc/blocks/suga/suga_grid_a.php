<?php
if (!class_exists('suga_grid_a')) {
    class suga_grid_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_grid_a-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config   
            $moduleConfigs['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 7;
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
                $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-a atbssuga-post--grid-multiple-style '.$moduleCustomClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
                
                $block_str .= '<div class="atbssuga-block__inner">';
                $block_str .= '<div class="row">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                $block_str .= '</div><!-- .atbssuga-block__inner -->';
                $block_str .= '</div>';
                $block_str .= '</div><!-- .atbssuga-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            
            $iconPosition = 'top-right';
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
            $postVerticalHTML = new suga_vertical_1;
            $postVerticalAttr = array (
                'additionalClass'   => '',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-s-1_1',
                'typescale'         => 'typescale-2',
                'postIcon'          => $postIconAttr,  
            );
            $postHorizontalHTML = new suga_horizontal_2;
            $postHorizontalAttr = array (
                'additionalClass'   => '',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xxs-1_1',
                'typescale'         => 'typescale-0 custom-typescale-0',
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules = '';
            $currentPost = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $currentPost = $the_query->current_post;
                if($currentPost == 0){
                    $render_modules .= '<div class="col-md-6 col-sm-6 col-xs-12 col-margin-bottom">';
                    $render_modules .= '<div class="col-inner--left post-lists">';
                }
                
                if($currentPost == 3){
                    $render_modules .= '<div class="col-md-6 col-sm-6 col-xs-12 col-margin-bottom">';
                    $render_modules .= '<div class="col-inner--right post-lists post-last--order-top">';
                }
                
                if($bypassPostIconDetech != 1) {
                    $addClass = '';
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                } 
                $render_modules .= '<div class="list-item">';
                if($currentPost == 0):
                    $postVerticalAttr['postID'] = get_the_ID();
                    $postVerticalAttr['additionalClass'] = 'post--vertical--xxl';
                    $postVerticalAttr['typescale'] = 'typescale-3 custom-typescale-3';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                elseif(($currentPost == 1) || ($currentPost == 2) || ($currentPost == 4) || ($currentPost == 5)):
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-middle post-thumb-sm';
                    $postHorizontalAttr['typescale'] = 'typescale-0 custom-typescale-0';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                elseif ($currentPost == 3):
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-middle post-thumb-md post--horizontal-big';
                    $postHorizontalAttr['typescale'] = 'typescale-2 custom-typescale-2';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                elseif ($currentPost == 6):
                    $postVerticalAttr['postID'] = get_the_ID();
                    $postVerticalAttr['thumbSize'] = 'suga-xs-4_3';
                    $postVerticalAttr['additionalClass'] = 'post--vertical--xl';
                    $postVerticalAttr['typescale'] = 'typescale-2 custom-typescale-2';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                endif;
                
                $render_modules .= '</div><!-- .list-item -->';
                
                if(($currentPost == 2) || ($currentPost == 6)):
                    $render_modules .= '</div></div><!-- col-md-6 col-sm-6 col-xs-12 -->';
                endif;
                
            endwhile;
            
            if(($currentPost != 2) && ($currentPost != 6)):
                $render_modules .= '</div></div><!-- col-md-6 col-sm-6 col-xs-12 -->';
            endif;
                
            return $render_modules;
        }
    }
}