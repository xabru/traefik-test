<?php
if (!class_exists('suga_posts_block_l')) {
    class suga_posts_block_l {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_block_l-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 8;
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
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-l post-grid-multiple-style-has-radius atbssuga-suga-grid-l '.$moduleCustomClass.'">';
            $block_str .= '<div class="container">';
             $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="atbssuga-block__inner">';
            $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            $block_str .= '</div><!-- .atbssuga-block__inner -->';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbssuga-block -->';
            
            endif;
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo = ''){
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition= 'top-right';
            $iconSize = 'medium';
            // Category
            
            $catStyle = 3; //Top-left
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $catStyle_L = 4;
            $cat_Class_L = suga_core::bk_get_cat_class($catStyle_L);

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
                $postOverlayHTML = new suga_overlay_3;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-height-510 post-grid-video-space-between',
                    'cat'               => $catStyle_L,
                    'catClass'          => $cat_Class_L,
                    'thumbSize'         => 'suga-l-2_1',
                    'typescale'         => '',
                    'except_length'     => 23,
                    'postIcon'          => $postIconAttr,  
                    'iconPosition'      => 'right-center',
                );
                $postOverlay_Nothumb_1_HTML = new suga_overlay_nothumb_1;
                $postOverlay_Nothumb_1_Attr = array (
                    'additionalClass'   => 'post--nothumb-has-line-readmore remove-margin-bottom-lastchild',
                    'cat'               => $catStyle,
                    'additionalTextClass' => 'remove-margin-bottom-lastchild inverse-text',
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xs-4_3',
                    'typescale'         => '',
                    'except_length'     => 23,
                    'readmore'          => 1,
                    'meta'          => array('author'),
                    'postIcon'          => $postIconAttr,  
                );
                $postVerticalHTML = new suga_vertical_1;                   
                $postVerticalAttr = array (
                    'additionalClass' => 'post--nothumb-small-has-background remove-margin-bottom-lastchild',
                    'cat'           => $catStyle,
                    'catClass'      => $cat_Class,
                    'typescale'     => 'typescale-2 custom-typescale-2',
                );
                
                $postHorizontalHTML = new suga_horizontal_2;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post__thumb-70 post--horizontal-middle post--horizontal-xxs',
                    'thumbSize'         => 'suga-xxs-1_1',
                    'typescale'         => 'typescale-0 m-b-0',
                );

                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    
                    if($currentPost == 0):
                        $render_modules .= '<div class="post-grid-multiple-style-has-radius__top">';
                        
                        if($bypassPostIconDetech != 1) :
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            //$postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', 'right-center');
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                            
                        endif;
                        $postOverlayAttr['postID'] = get_the_ID();
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            
                        $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__top -->';
                    elseif($currentPost == 1):
                        $render_modules .= '<div class="post-grid-multiple-style-has-radius__body">';
                        $render_modules .= '<div class="post-grid-has-radius-body--left">';
                        
                        $postOverlayAttr['additionalClass'] = 'post--overlay-bottom post--overlay-height-560 post--overlay-author-top';
                        $postOverlayAttr['meta']            = array('author');
                        $postOverlayAttr['iconPosition']    = '';
                        $postOverlayAttr['thumbSize']      = 'suga-l-2_1';
                        $postOverlayAttr['postID']          = get_the_ID();
                        
                        if($bypassPostIconDetech != 1) :
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition);
                            $postOverlayAttr['postIcon'] = $postIconAttr;
                            
                        endif;
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div><!-- .post-grid-has-radius-body--left -->';
                        
                    elseif(($currentPost == 2) || ($currentPost == 3)):
                        if($currentPost == 2):
                            $render_modules .= '<div class="post-grid-has-radius-body--center">';
                            $render_modules .= '<div class="post-list">';
                            $render_modules .= '<div class="list-item">';
                            $postOverlay_Nothumb_1_Attr['postID'] = get_the_ID();
                            $render_modules .= $postOverlay_Nothumb_1_HTML -> render($postOverlay_Nothumb_1_Attr);
                            $render_modules .= '</div><!-- .list-item -->';
                        endif;
                        
                        if($currentPost == 3):
                            $render_modules .= '<div class="list-item">';
                            $postVerticalAttr['postID'] = get_the_ID();
                            $render_modules .= $postVerticalHTML -> render($postVerticalAttr);
                            $render_modules .= '</div><!-- .list-item -->';
                            $render_modules .= '</div><!-- .post-list -->';
                            $render_modules .= '</div><!-- .post-grid-has-radius-body--center -->';
                        endif;
                    
                    elseif($currentPost > 3):
                        if($currentPost == 4):
                            $render_modules .= '<div class="post-grid-has-radius-body--right">';
                            $render_modules .= '<div class="post-list">';
                            $render_modules .= '<div class="item-main list-item">';
                            
                            $postOverlayAttr['postID']          = get_the_ID();
                            $postOverlayAttr['additionalClass'] = 'post--notext-radius post--overlay-radius-text-hidden post--overlay-bottom post--overlay-height-280';
                            $postOverlayAttr['meta']            = '';
                            $postOverlayAttr['except_length']   = '';
                            $postOverlayAttr['iconPosition']    = '';
                            $postOverlayAttr['typescale']       = 'typescale-0 custom-typescale-0';
                            $postOverlayAttr['thumbSize']      = 'suga-xs-1_1';
                            
                            if($bypassPostIconDetech != 1) :
                                if($postSource != 'all') {
                                    $postIconAttr['iconType'] = $postSource;
                                }else {
                                    $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                                }
                                $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition);
                                $postOverlayAttr['postIcon']    = $postIconAttr;
                                
                            endif;
                            $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                            $render_modules .= '</div><!-- .item-main list-item -->';
                        else:
                            if($currentPost == 5):
                                $render_modules .= '<div class="item-sub">';
                            endif;
                            
                            $render_modules .= '<div class="list-item">';
                            $postHorizontalAttr['postID'] = get_the_ID();
                            $render_modules .= $postHorizontalHTML -> render($postHorizontalAttr);
                            $render_modules .= '</div><!-- .list-item -->';
                            
                            if($currentPost == 7):
                                $render_modules .= '</div><!-- .item-sub -->';
                                $render_modules .= '</div><!-- .post-list -->';
                                $render_modules .= '</div><!-- .post-grid-has-radius-body--right -->';
                                $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__body -->';                                
                            endif;
                        endif;
                    endif;
                endwhile;
                if(($currentPost == 1) || ($currentPost == 3)):
                    $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__body -->';    
                elseif($currentPost == 2):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .post-grid-has-radius-body--center -->';
                    $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__body -->'; 
                elseif($currentPost == 4):
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .post-grid-has-radius-body--right -->';
                    $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__body -->';
                elseif(($currentPost == 5) || ($currentPost == 6)):
                    $render_modules .= '</div><!-- .item-sub -->';
                    $render_modules .= '</div><!-- .post-list -->';
                    $render_modules .= '</div><!-- .post-grid-has-radius-body--right -->';
                    $render_modules .= '</div><!-- .post-grid-multiple-style-has-radius__body -->'; 
                endif;
            endif;
            
            return $render_modules;
        
        }
    }
}