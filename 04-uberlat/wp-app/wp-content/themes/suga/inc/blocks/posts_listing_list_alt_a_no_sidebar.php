<?php
if (!class_exists('suga_posts_listing_list_alt_a_no_sidebar')) {
    class suga_posts_listing_list_alt_a_no_sidebar {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_listing_list_alt_a_no_sidebar-');
            $moduleConfigs = array();
            $moduleData = array();
            
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
                'meta'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta', true ),
                'cat'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_style', true ), // Category Style
                'excerpt'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt', true ),
            );
            
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $the_query = bk_get_query::suga_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth atbssuga-posts-listing-list-alt-a-no-sidebar atbssuga-post--grid-horizontal-title-hasline '.$moduleCustomClass.'">';
            $block_str .= '<div class="container container--narrow">';
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="atbssuga-block__inner posts-list">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, 0, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            
            $sugaMaxPages = suga_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= suga_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $sugaMaxPages, $viewallButton);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '</div>';
            }
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .atbssuga-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $currentPost = 0;
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';

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
                
                $postHorizontalHTML = new suga_horizontal_1;
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-s-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'except_length'     => 13,
                    'postIcon'          => $postIconAttr,  
                );
                
                $postHorizontalAttr_L = array (
                    'additionalClass'   => 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xs-4_3',
                    'typescale'         => 'typescale-2 custom-typescale-2',
                    'postIcon'          => $postIconAttr,  
                    'except_length'     => 13,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $currentPost = $the_query->current_post + $the__lastPost;    
                    $postHorizontalAttr['postID'] = get_the_ID();   
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, '');
                        
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }   
                    if($currentPost % 5) : //Normal Posts 
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    else: //Large Posts
                        $postHorizontalAttr_L['postIcon']['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition);
                        $postHorizontalAttr_L['postID'] = get_the_ID();   
                        
                        $render_modules .= '<div class="list-item list-item-large">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
                
            endif;
            
            return $render_modules;
        }
    }
}