<?php
if (!class_exists('suga_posts_listing_grid_small_no_sidebar')) {
    class suga_posts_listing_grid_small_no_sidebar {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_listing_grid_small_no_sidebar-');
            $moduleConfigs = array();
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $viewallButton = array();
            if ($moduleConfigs['ajax_load_more'] == 'viewall') :            
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
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
               
            );
            
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $the_query = bk_get_query::suga_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth posts-listing-grid-small-no-sidebar atbssuga-post--grid-vertical-readmore-small atbssuga-posts-listing-grid-small-no-sidebar'.$moduleCustomClass.'">';
            $block_str .= '<div class="container">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            $block_str .= '<div class="atbssuga-block__inner posts-list row row--space-between grid-gutter-w40-h70 items-clear-both-4">';
            $block_str .= $this->render_modules($the_query, 0, $moduleInfo);            //render modules
            $block_str .= '</div><!--Close Row -->';
            
            $sugaMaxPages = suga_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= suga_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $sugaMaxPages, $viewallButton);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '</div><!-- .js-ajax-load-post -->';
            }
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbssuga-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $iconSize = 'small';
            // Category

            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);

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
                $postVerticalHTML = new suga_vertical_3;                       
                $postVerticalAttr = array (
                    'additionalClass' => 'post__thumb-200 clearfix post--vertical-readmore-small',
                    'thumbSize'     => 'suga-xs-4_3',
                    'cat'           => $catStyle,
                    'catClass'      => $cat_Class,
                    'typescale'     => 'typescale-1 custom-typescale-1 flexbox__item',
                    'postIcon'      => $postIconAttr,
                );
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $postVerticalAttr['postID'] = get_the_ID();
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
                    $render_modules .= '<div class="col-md-6 col-sm-6 col-md-3 item-count">';
                    $render_modules .= '<div class="list-tem">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                    $render_modules .= '</div>';  
                endwhile;
            endif;
            
            return $render_modules;
        }
        
    }
}