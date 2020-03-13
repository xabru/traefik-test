<?php
if (!class_exists('suga_posts_block_e')) {
    class suga_posts_block_e {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_block_e-');
            
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
                'iconPosition'  => 'left-bottom',
            );
               
            $the_query = bk_get_query::suga_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-h '.$moduleCustomClass.'">';
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
            $postOverlayHTML_L = new atbs_overlay_1;
            $postOverlayHTML_S = new atbs_overlay_1;
            $render_modules = '';
            
            $iconPosition = 'top-right';
            
            // Meta
            $meta_L = 2;
            $metaArray_L = suga_core::bk_get_meta_list($meta_L);
            
            $meta_S = 8;
            $metaArray_S = suga_core::bk_get_meta_list($meta_S);
            
            // Category
            $cat_L_Style = 4;
            $cat_S_Style = 4; 
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);            
            $cat_S_Class = suga_core::bk_get_cat_class($cat_S_Style);
            
            $excerpt_L = 20;
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = '1-col';
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
                    'thumbSize'         => 'suga-xs-1_1',
                    'typescale'         => 'typescale-2 custom-typescale-2 m-b-sm',
                    'additionalClass'   => 'post--overlay-bottom post--overlay-md post--overlay-floorfade',
                    'additionalTextClass'   => 'inverse-text',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'meta'              => $metaArray_S,
                    'postIcon'          => $postIconAttr,
                    'except_length'     => '',
                );
                $render_modules .= '<div class="row row--space-between grid-gutter-4">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($the_query->current_post == 0){
                        $postOverlayAttr_L = $postOverlayAttr;
                        
                        $postOverlayAttr_L['thumbSize'] = 'suga-s-4_3';
                        $postOverlayAttr_L['typescale'] = 'typescale-3 m-b-sm';
                        $postOverlayAttr_L['except_length'] = '';
                        $postOverlayAttr_L['meta']          = $metaArray_L;
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
                                                                                    
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition);
                            
                            $postOverlayAttr_L['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= '<div class="col-xs-12 col-md-6">';
                        $render_modules .= $postOverlayHTML_L->render($postOverlayAttr_L);
                        $render_modules .= '</div>';
                    }else {
                        $postOverlayAttr['comment_box'] = '';
                        $addClass = '';
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition == 'left-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition == 'right-bottom') {
                                $postOverlayHTML_S = new suga_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    }
                endwhile;
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}