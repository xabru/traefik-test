<?php
if (!class_exists('suga_featured_block_c')) {
    class suga_featured_block_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_featured_block_c-');
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

            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'footerStyle'   => '1-col',
            );
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = suga_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            $the_query = bk_get_query::suga_query($moduleConfigs);   //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block suga-grid-d atbssuga-block--fullwidth atbssuga-featured-block-c '.$moduleCustomClass.'">';
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
        public function render_modules ($the_query, $moduleInfo){
            $currentPost = 0;
            $postCount = $the_query->post_count;
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            
            // Category
            $cat_L_Style = 4; //Category Top Left
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            
            $cat_S_Style = 3; //Category Top Left
            $cat_S_Class = suga_core::bk_get_cat_class($cat_S_Style);
                
            $meta = 1;
            $metaArray = suga_core::bk_get_meta_list($meta);
            
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
            
            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $postOverlayHTML = new atbs_overlay_1;
                $postOverlayAttr = array (
                    'additionalClass'       => 'post--overlay-bottom post--overlay-md post--overlay-floorfade post--overlay-padding-lg post--overlay-primary-xs',
                    'cat'                   => $cat_L_Style,
                    'catClass'              => $cat_L_Class,
                    'meta'                  => $metaArray,
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'] . ' m-t-md',
                    'thumbSize'             => 'suga-m-4_3',
                    'typescale'             => 'typescale-3 m-b-sm',
                    'except_length'         => 20,
                    'additionalExcerptClass' => 'post__excerpt--lg hidden-xs hidden-sm',
                    'postIcon'              => $postIconAttr,
                );
                
                $postHorizontalHTML = new atbs_horizontal_1;
                $postHorizontalAttr = array (
                    'additionalClass'       => 'post--horizontal-middle post--horizontal-xs',
                    'cat'                   => 3,
                    'catClass'              => suga_core::bk_get_cat_class(3),
                    'thumbSize'             => 'suga-xxs-1_1',
                    'additionalThumbClass'  => 'post__thumb--circle',
                    'typescale'             => 'typescale-1',
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0) {
                        $postOverlayHTML_L = $postOverlayHTML;
                        $render_modules .= '<div class="row row--space-between grid-gutter-20">';
                        $render_modules .= '<div class="col-xs-12 col-sm-7 col-md-8">';
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML_L = new suga_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML_L = new suga_overlay_icon_side_right;
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
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= $postOverlayHTML_L->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    }elseif($currentPost == 1) {
                        $postOverlayHTML_S = $postOverlayHTML;
                        $render_modules .= '<div class="col-xs-12 col-sm-5 col-md-4">';
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_S == 'left-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_S == 'right-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_right;
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
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $postOverlayAttr['additionalClass'] = 'post--overlay-bottom post--overlay-md post--overlay-floorfade post--overlay-padding-lg';
                        $postOverlayAttr['typescale'] = 'typescale-2 custom-typescale-2 m-b-sm';
                        $postOverlayAttr['thumbSize'] = 'suga-s-1_1';
                        $postOverlayAttr['except_length'] = 0;
                        
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= '</div> <!-- End Row -->';
                    }else {
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($currentPost == 2) {
                            $render_modules .= '<div class="row row--space-between">';
                        }
                        $render_modules .= '<div class="col-xs-12 col-md-4">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    }
                endwhile;
                if($currentPost != 1)  {
                    $render_modules .= '</div> <!-- End Row -->';
                }
            endif;
            
            return $render_modules;
        }
    }
}