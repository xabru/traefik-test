<?php
if (!class_exists('suga_posts_block_k')) {
    class suga_posts_block_k {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_block_k-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 3;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
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
            
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition'  => 'top-right',
                'footerStyle'   => '1-col',
            );
            $the_query = bk_get_query::suga_query($moduleConfigs);              //get query
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-k posts--vertical-first-big atbssuga-suga-grid-k '.$moduleCustomClass.'">';
            $block_str .= '<div class="atbssuga-block__inner">';
           	$block_str .= '<div class="container">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="post-list">';
            $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            $block_str .= '</div><!-- .post-list -->';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbssuga-block__inner -->';
            $block_str .= '</div><!-- .atbssuga-block -->';
            
            endif;
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition= $moduleInfo['iconPosition'];
            $iconSize = 'medium';
            // Category
            
            $cat_Style = 3; //Top-left
            $cat_Class = suga_core::bk_get_cat_class($cat_Style);

            $excerptLength = 20;
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = $moduleInfo['footerStyle'];
            $footerArgs = suga_core::bk_overlay_footer_style($footerStyle);
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            
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
                    'cat'               => $cat_Style,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-s-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    $render_modules .= '<div class="list-item">';
                    if($currentPost == 0):
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $postVerticalAttr['catClass'] .=' cat-color-logo';
                        $postVerticalAttr['additionalClass'] = 'post--vertical-first-big post--vertical-of-post-first-big post__thumb-360';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    elseif ($currentPost > 0 ):
                        $iconSize = '';
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $postVerticalAttr['catClass']   .='cat-color-logo';
                        $postVerticalAttr['thumbSize'] = 'suga-xs-1_1';
                        $postVerticalAttr['additionalClass'] = 'post--vertical-of-post-first-big post__thumb-360';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    endif;
                    $render_modules .= '</div>';
                endwhile;
            endif;
            return $render_modules;
            
        }
    }
}