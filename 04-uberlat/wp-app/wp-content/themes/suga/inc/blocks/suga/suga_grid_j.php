<?php
if (!class_exists('suga_posts_block_j')) {
    class suga_posts_block_j {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_block_j-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 5;
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
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'footerStyle'   => '1-col',
            );
              
            $the_query = bk_get_query::suga_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-j '.$moduleCustomClass.'">';
           	$block_str .= '<div class="container">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbssuga-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo = ''){
            $postOverlayHTML = new atbs_overlay_1;
            $postVerticalHTML = new suga_vertical_1;
            $postHorizontalHTML = new atbs_horizontal_1;
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            $iconSize_L = 'medium';
            $iconSize_S = '';
            
            // Meta
            $meta_L = 1;
            $metaArray_L = suga_core::bk_get_meta_list($meta_L);
            $meta_S = 8;
            $metaArray_S = suga_core::bk_get_meta_list($meta_S);
            // Category
            $cat_L_Style = 4;
            $cat_S_Style = 3; //Top-left
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            $cat_S_Class = suga_core::bk_get_cat_class($cat_S_Style);

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
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-sm',
                    'cat'               => $cat_L_Style,
                    'catClass'          => $cat_L_Class,
                    'meta'              => $metaArray_L,
                    'thumbSize'         => 'suga-s-4_3',
                    'typescale'         => 'typescale-3 custom-typescale-3 m-b-sm',
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],
                    'postIcon'          => $postIconAttr,
                );
                $postVerticalAttr = array (
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'meta'              => $metaArray_S,
                    'thumbSize'         => 'suga-xs-4_3',
                    'additionalThumbClass' => 'm-b-md',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,
                );
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xs post--horizontal-reverse',
                    'thumbSize'         => 'suga-xxs-1_1',
                    'meta'              => array('date'),
                    'typescale'         => 'typescale-0 custom-typescale-0',
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0){
                        $colClass = "col-xs-12 col-sm-6 col-md-5";
                    }else if($currentPost == 1){
                        $colClass = "col-xs-12 col-sm-6 col-md-3";
                    }else{
                        $colClass = "col-xs-12 col-sm-12 col-md-4";
                    }
                    if($currentPost == 2){
                        $render_modules .= '<div class="'.$colClass.'">';
                        $render_modules .= '<ul class="posts-list list-space-sm list-unstyled list-seperated">';
                    }
                    if($currentPost == 0){
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                                                                                    
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML = new suga_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML = new suga_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= '<div class="'.$colClass.'">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    }else if($currentPost == 1){
                        $postVerticalAttr['postID']         = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
  
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S, $addClass);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                            
                        }
                        $render_modules .= '<div class="'.$colClass.'">';
                        $postVerticalAttr['additionalClass']    = 'post__thumb-200';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    }else {
                        $postHorizontalAttr['postID'] = get_the_ID();
                        
                        $render_modules .= '<li>';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</li> <!-- end small item -->';
                    }
                endwhile;
                if($currentPost >= 2){
                    $render_modules .= '</ul></div>';
                }
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}