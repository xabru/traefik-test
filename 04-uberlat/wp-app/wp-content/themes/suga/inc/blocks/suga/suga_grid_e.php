<?php
if (!class_exists('suga_mosaic_b')) {
    class suga_mosaic_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_mosaic_b-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['limit']     = 4;
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
            
            $block_str .= '<div id="'.$moduleID.'"  class="atbssuga-block atbssuga-block--fullwidth suga-grid-e atbssuga-mosaic atbssuga-mosaic--gutter-10 '.$moduleCustomClass.'">';
            $block_str .= '<div class="container">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;

            $block_str .= '</div>';
            $block_str .= '</div><!-- .atbssuga-block -->';
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($the_query, $moduleInfo = ''){
            $render_modules = '';
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            
            // Meta
            $meta = 1;
            $metaArray = suga_core::bk_get_meta_list($meta);
            
            $meta_S = 8;
            $metaArray_S = suga_core::bk_get_meta_list($meta_S);
            
            // Category
            // Category
            $cat_L_Style = 4; //Category Top Left
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            
            $cat_S_Style = 4; //Category Top Left
            $cat_S_Class = suga_core::bk_get_cat_class($cat_S_Style);
            
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
                $postOverlayHTML_L = new atbs_overlay_1;
                $postOverlayHTML_S = new atbs_overlay_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'suga-xs-4_3',
                    'typescale'         => 'typescale-1',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade',
                    'except_length'     => '',
                    'postIcon'          => $postIconAttr,
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();         
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($the_query->current_post == 0) :
                        $postOverlayAttr_L = $postOverlayAttr;
                        $postOverlayAttr_L['thumbSize']     = 'suga-m-4_3';
                        $postOverlayAttr_L['typescale']     = 'typescale-3 m-b-sm';
                        $postOverlayAttr_L['except_length'] = '';
                        $postOverlayAttr_L['meta']          = $metaArray;
                        $postOverlayAttr_L['cat']           = $cat_L_Style;
                        $postOverlayAttr_L['catClass']      = $cat_L_Class;        
                        $postOverlayAttr_L['footerType']          = $footerArgs['footerType'];
                        $postOverlayAttr_L['additionalMetaClass'] = $footerArgs['footerClass'];
                        
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
                                $postOverlayAttr_L['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML_L = new suga_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr_L['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr_L['postIcon']    = $postIconAttr;
                        } 
                        
                        $render_modules .= '<div class="mosaic-item col-xs-12 col-lg-6">';
                        $render_modules .= $postOverlayHTML_L->render($postOverlayAttr_L);
                        $render_modules .= '</div>';
                    elseif($the_query->current_post == 1) :
                        $postOverlayAttr_M = $postOverlayAttr;
                        $postOverlayAttr_M['thumbSize']     = 'suga-s-1_1';
                        $postOverlayAttr_M['typescale']     = 'typescale-2 custom-typescale-2 m-b-sm';
                        $postOverlayAttr_M['meta']          = $metaArray_S;
                        
                        $addClass = 'overlay-item--sm-p';
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_S == 'left-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr_M['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_S == 'right-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr_M['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S, $addClass);
                                }
                            }
                            
                            $postOverlayAttr_M['postIcon']    = $postIconAttr;
                        } 
                        
                        $render_modules .= '<div class="mosaic-item col-xs-12 col-md-6 col-lg-3">';
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr_M);
                        $render_modules .= '</div>';
                    else:                    
                        $render_modules .= '<div class="mosaic-item mosaic-item--half col-xs-12 col-sm-6 col-lg-3">';
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}