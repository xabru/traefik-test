<?php
if (!class_exists('suga_posts_block_c')) {
    class suga_posts_block_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_posts_block_c-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
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
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = $moduleConfigs['custom_class'].' ';
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
                'iconPosition'  => 'center',
                'footerStyle'   => '1-col',
            );   
            
            $moduleConfigs['bg_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bg_option', true );
            if($moduleConfigs['bg_option'] == 'image') :
                $moduleConfigs['background_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_img', true );            
                if($moduleConfigs['background_img'] != '') {          
                    $imgBGStyle = "background-image: url('".$moduleConfigs['background_img']."')";
                    $moduleBackground = '<div class="background-img" style="'.$imgBGStyle.'"></div>';
                    $hasBG_Class = 'has-background';
                }else {
                    $moduleBackground = '';
                    $hasBG_Class = '';
                }
            elseif($moduleConfigs['bg_option'] == 'no_bg') :
                $moduleBackground = '';
                $hasBG_Class = '';
            else:
                $gradient_bg__from  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_from', true );
                $gradient_bg__to    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_to', true );
                $gradient_bg__direction = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_direction', true );
                $background_pattern  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_pattern', true );
                $patternHTML = '';
                if($background_pattern == 1) :
                    $patternHTML = '<div class="background-svg-pattern"></div>';
                endif;  
                
                if(($gradient_bg__to != '') || ($gradient_bg__to != '')) {                        
                    $moduleBackground = '<div class="background-img gradient-4" style="
                        background: '.$gradient_bg__from.';
                        background: -webkit-linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                        background: linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                    ">'.$patternHTML.'</div>';
                    $hasBG_Class = 'has-background';
                }else {
                    $moduleBackground = '';
                    $hasBG_Class = '';
                }
            endif; 
            
            $the_query = bk_get_query::suga_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth suga-grid-f '.$moduleCustomClass.$hasBG_Class.'">';
            $block_str .= $moduleBackground;
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
            $postCardHTML = new atbs_card_1;
            $render_modules = '';
            
            $footerStyle = $moduleInfo['footerStyle'];
            $iconPosition = 'top-right';
            
            // Category
            $catStyle = 2; //Overlap
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $articleAdditionalClass = 'post--vertical-cat-overlap';

            $metaArray = suga_core::bk_get_meta_list(8);

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
                $postCardAttr = array (
                    'additionalClass'   => 'post--card-sm text-center '.$articleAdditionalClass,
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'suga-xs-16_9 400x225',
                    'typescale'         => 'typescale-1 custom-typescale-1',
                    'footerType'        => $footerStyle,       
                    'meta'              => $metaArray,
                    'postIcon'          => $postIconAttr,                   
                );
                $render_modules .= '<div class="row row--space-between items-clear-both-4">';                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postCardAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = suga_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition, $addClass);
                        
                        $postCardAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules .= $postCardHTML->render($postCardAttr);
                    $render_modules .= '</div>';
                endwhile;
                $render_modules .= '</div>';                
            endif;
            
            return $render_modules;
        }
    }
}