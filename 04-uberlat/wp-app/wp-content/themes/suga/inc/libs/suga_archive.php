<?php
if (!class_exists('suga_archive')) {
    class suga_archive {
        static function the_query__sticky($catID, $posts_per_page){
            $feat_tag = '';                            
            $feat_area_option  = suga_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');

            $args = array(
                'cat' => $catID,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $posts_per_page,
            );
                                    
            if($feat_area_option !== 'latest') {
                $args['post__in'] = get_option( 'sticky_posts' );
            }
                        
            $the_query = new WP_Query( $args );
            wp_reset_postdata();
            return $the_query;
        }
    /**
     * ************* Get Option *****************
     *---------------------------------------------------
     */
        static function bk_get_archive_option($termID, $theoption = '') {
            $suga_option = suga_core::bk_get_global_var('suga_option');
            $output = '';
            
            if($theoption != '') :
                $output  = suga_core::suga_rwmb_meta( $theoption, array( 'object_type' => 'term' ), $termID );  
                if (isset($output) && (($output == 'global_settings') || ($output == ''))): 
                    $output = $suga_option[$theoption];
                endif;
            endif;
            
            return $output;
        }
        static function bk_pagination_render($pagination){
            global $wp_query;
            $max_page = $wp_query->max_num_pages;
            $render = '';
            if($max_page <= 1) {
                return '';
            }
            if($pagination == 'default') {
                $render = suga_core::suga_get_pagination();
            }else if($pagination == 'ajax-pagination') {
                $render = suga_ajax_function::ajax_load_buttons('pagination', $max_page);
            }else if($pagination == 'ajax-loadmore') {
                $render = suga_ajax_function::ajax_load_buttons('loadmore', $max_page);
            }
            return $render;
        }
        static function bk_author_pagination_render($pagination, $userMaxPages){
            $render = '';
            if($pagination == 'ajax-pagination') {
                $render = suga_ajax_function::ajax_load_buttons('pagination', $userMaxPages);
            }else if($pagination == 'ajax-loadmore') {
                $render .= '<nav class="atbssuga-pagination text-center">';
                $render .= '<button class="btn btn-default js-ajax-load-post-trigger">'.esc_html__('Load more authors', 'suga').'<i class="mdicon mdicon-cached mdicon--last"></i></button>';
    			$render .= '</nav>';
            }
            return $render;
        }
        static function bk_archive_pages_post_icon(){
            global $post;
            $suga_option = suga_core::bk_get_global_var('suga_option');
            $postIcon = '';
            
            if(is_category()) {
                $postIcon = isset($suga_option['bk_category_post_icon']) ? $suga_option['bk_category_post_icon'] : 'disable';
            }elseif(is_author()) {
                $postIcon = isset($suga_option['bk_author_post_icon']) ? $suga_option['bk_author_post_icon'] : 'disable';
            }elseif(is_search()) {
                $postIcon = isset($suga_option['bk_search_post_icon']) ? $suga_option['bk_search_post_icon'] : 'disable';
            }elseif(is_archive()){
                $postIcon = isset($suga_option['bk_archive_post_icon']) ? $suga_option['bk_archive_post_icon'] : 'disable';
            }else {
                $pageTemplate =  get_post_meta($post->ID,'_wp_page_template',true);
                if($pageTemplate == 'blog.php') {
                    $postIcon = isset($suga_option['bk_blog_post_icon']) ? $suga_option['bk_blog_post_icon'] : 'disable';
                }
            }
            return $postIcon;
        }
        static function bk_render_authors($users_found) {
            $render = '';
            if(count($users_found) > 0):
                $render .= '<ul class="authors-list list-unstyled list-space-lg">';
                foreach($users_found as $user) :
                    $render .= '<li>';
                    $render .= suga_archive::author_box($user->data->ID);
                    $render .= '</li>';
                endforeach;
                $render .= '</ul> <!-- End Author Results -->';
            endif;            
            return $render;
        }
        static function get_sticky_ids__category_feature_area($catID, $featLayout){
            $featAreaOption  = self::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
            $excludeIDs = array();
            $posts_per_page = 0;
            $sticky = get_option('sticky_posts') ;
            rsort( $sticky );
            
            $args = array (
                'post_type'     => 'post',
                'cat'           => $catID, // Get current category only
                'order'         => 'DESC',
            );
            
            switch($featLayout){
                case 'posts_block_b' :
                    $posts_per_page = 6;
                    break;
                case 'mosaic_a' :
                case 'mosaic_a_bg' :
                case 'featured_block_e' :
                case 'featured_block_f' :
                case 'posts_block_i' :
                    $posts_per_page = 5;
                    break;
                case 'mosaic_b' :
                case 'mosaic_b_bg' :
                case 'posts_block_c' :
                    $posts_per_page = 4;
                    break;
                case 'mosaic_c' :
                case 'mosaic_c_bg' :
                case 'posts_block_e' :
                case 'posts_block_e_bg' :
                    $posts_per_page = 3;
                    break;
                default:
                    $posts_per_page = 0;                
                    break;
            }
            if($posts_per_page == 0) :
                wp_reset_postdata();
                return '';
            endif;
            $args['posts_per_page'] = $posts_per_page;
            if($featAreaOption == 'featured') {
                $args['post__in'] = $sticky; // Get stickied posts
            }
            $sticky_query = new WP_Query( $args );
            while ( $sticky_query->have_posts() ): $sticky_query->the_post();
                $excludeIDs[] = get_the_ID();
            endwhile;
            wp_reset_postdata();
            return $excludeIDs;
        }
        static function archive_feature_area($term_id, $featLayout){  
            $featArea = '';
            switch( $featLayout ) {
                default:
                    break;
                case 'mosaic_b':
                    $featArea .= self::mosaic_b__render($term_id);
                    break;
                case 'posts_block_c':
                    $featArea .= self::posts_block_c__render($term_id);
                    break;
                case 'posts_block_e':
                    $featArea .= self::posts_block_e__render($term_id);
                    break;
            }
            return $featArea;
        }
        static function suga_archive_header($term_id){
            $archiveHeader = '';
            
            $headingColor = '';            
            if(is_category()) :
                $headingColor  = suga_archive::bk_get_archive_option($term_id, 'bk_category_heading__color');
            else :
                $headingColor  = suga_archive::bk_get_archive_option($term_id, 'bk_archive_heading__color');
            endif;
                        
            $styleInline = '';
            if($headingColor != '') :
                $styleInline = 'style="color: '.$headingColor.';"';
            endif;
            
            if(is_category()) :
                $headingStyle = suga_archive::bk_get_archive_option($term_id, 'bk_category_header_style');  
            else :
                $headingStyle = suga_archive::bk_get_archive_option($term_id, 'bk_archive_header_style');
            endif;
            
            $headingInverse = 'no';
            
            $headingClass = suga_core::bk_get_block_heading_class($headingStyle, $headingInverse);

            $archiveHeader .= '<div class="container">';
            
            if(is_category()) :
                $archiveHeader .= '<div class="block-heading '.$headingClass.'">';
                $archiveHeader .= '<h2 class="page-heading__title block-heading__title" '.$styleInline.'>'.get_cat_name($term_id).'</h2>';
                if ( category_description($term_id) ) :
                    $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                endif;
                $archiveHeader .= '</div><!-- block-heading -->';
            elseif(is_tag()) :
                $tag = get_tag($term_id);            
                $archiveHeader .= '<div class="block-heading '.$headingClass.'">';
                $archiveHeader .= '<h2 class="page-heading__title block-heading__title" '.$styleInline.'>'.esc_html__('Tag: ', 'suga'). $tag->name.'</h2>';
                if ( $tag->description ) :
                    $archiveHeader .= '<div class="page-heading__subtitle"><p>'.$tag->description.'</p></div>';
                endif;
                $archiveHeader .= '</div><!-- block-heading -->';
            endif;                        
            
            $archiveHeader .= '</div><!-- container -->';
            return $archiveHeader;
        }
        
        static function render_page_heading($pageID, $headingStyle, $headingColor = '') {
            $headingInverse = 'no';
            $headingClass = suga_core::bk_get_block_heading_class($headingStyle, $headingInverse);
            
            $styleInline = '';
            if($headingColor != '') :
                $styleInline = 'style="color:'.$headingColor.';"';
            endif;
            
            $page_description  = get_post_meta($pageID,'bk_page_description',true);
            
            $archiveHeader = '';
            
            $archiveHeader .= '<div class="block-heading '.$headingClass.'">';
            $archiveHeader .= '<h1 class="page-heading__title block-heading__title" '.$styleInline.'>'. get_the_title($pageID) .'</h1>';
            if ( $page_description != '' ) :
                $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
            endif;
            
            $archiveHeader .= '</div><!-- block-heading -->';
            
            return $archiveHeader;                        
                    
        }      
    
        static function mosaic_b__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new suga_mosaic_b;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= '<div class="atbssuga-block atbssuga-block--fullwidth atbssuga-mosaic atbssuga-mosaic--gutter-10">';
            $dataOutput .= '<div class="container container--wide">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            return $dataOutput;
        }
       
        static function posts_block_c__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new suga_posts_block_c;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'center',
                'cat'           => '', 
                'footerStyle'   => '1-cols',
            );
            
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= '<div class="atbssuga-block atbssuga-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_e__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new suga_posts_block_e;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'textAlign'       => '',
                'footerStyle'     => '1-col',
            );
            
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= '<div class="atbssuga-block atbssuga-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        
        static function archive_fullwidth($archiveLayout, $moduleID = '', $pagination = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_grid_no_sidebar':
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID);
                    break;
                case 'listing_grid_small_no_sidebar':
                    $dataOutput .= self::listing_grid_small_no_sidebar__render($moduleID, $pagination);
                    break;
                case 'listing_list_no_sidebar':
                    $dataOutput .= self::listing_list_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_b_no_sidebar':
                    $dataOutput .= self::listing_list_b_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_alt_a_no_sidebar':
                    $dataOutput .= self::listing_list_alt_a_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_alt_b_no_sidebar':
                    $dataOutput .= self::listing_list_alt_b_no_sidebar__render($moduleID);
                    break;
                default: 
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID);
                    break;                                                        
            } 
            return $dataOutput;
        }
        static function archive_main_col($archiveLayout, $moduleID = '', $pagination = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_list':
                    $dataOutput .= self::listing_list__render($moduleID);
                    break;
                case 'listing_list_b':
                    $dataOutput .= self::listing_list_b__render($moduleID);
                    break;
                case 'listing_list_c':
                    $dataOutput .= self::listing_list_c__render($moduleID);
                    break;    
                case 'listing_list_alt_a':
                    $dataOutput .= self::listing_list_alt_a__render($moduleID);
                    break;
                case 'listing_list_alt_b':
                    $dataOutput .= self::listing_list_alt_b__render($moduleID);
                    break;
                case 'listing_grid':
                    $dataOutput .= self::listing_grid__render($moduleID, $pagination);
                    break;
                case 'listing_grid_alt_a':
                    $dataOutput .= self::listing_grid_alt_a__render($moduleID, $pagination);
                    break;
                case 'listing_grid_alt_b':
                    $dataOutput .= self::listing_grid_alt_b__render($moduleID, $pagination);
                    break;
                case 'listing_grid_small':
                    $dataOutput .= self::listing_grid_small__render($moduleID, $pagination);
                    break;
                default:
                    $dataOutput .= self::listing_list__render($moduleID);
                    break;                                    
            } 
            return $dataOutput;
        }
/** Full Width Modules ( No sidebar)**/
        static function listing_grid_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
                    
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new suga_vertical_3;                       
            $postVerticalAttr = array (
                'additionalClass' => 'post__thumb-295 clearfix post--vertical-readmore-big',
                'thumbSize'     => 'suga-xs-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-2 custom-typescale-2 flexbox__item',
                'postIcon'      => $postIconAttr,
            );

            $render_modules .= '<div class="posts-list row row--space-between grid-gutter-w50-h80 items-clear-both-3">';
            
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                }
                
                $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-4">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!--Close Row -->';
            return $render_modules;
        }
        
        static function listing_grid_small_no_sidebar__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',

            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $postVerticalHTML = new suga_vertical_3;                       
            $postVerticalAttr = array (
                'additionalClass' => 'post__thumb-200 clearfix post--vertical-readmore-small',
                'thumbSize'     => 'suga-xs-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-1 custom-typescale-1 flexbox__item',
                'postIcon'      => $postIconAttr,
            );
            
			$render_modules .= '<div class="posts-list row row--space-between grid-gutter-w40-h70 items-clear-both-4">';

            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                }
                                                
                $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';

            endwhile;
               
            $render_modules .= '</div><!-- .Posts-List -->';
            
            return $render_modules;
        }
        static function listing_list_no_sidebar__render($moduleID) {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
            $render_modules .= '<div class="posts-list">';

            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_b_no_sidebar__render($moduleID) {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'postIcon'          => $postIconAttr,  
                'except_length'     => 17,
            );
            
            $render_modules .= '<div class="atbssuga-post--list-horizontal-hasbackground">';
            $render_modules .= '<div class="posts-list">';

            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_a_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new atbs_horizontal_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                        
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            

            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            
            $postHorizontalAttr_L = array (
                'additionalClass'   => 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground',
            );
            
            $render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                if($currentPost % 5) : //Normal Posts 
                    $postHorizontalAttr['thumbSize']  = 'suga-xs-4_3';
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    $postHorizontalAttr_L['thumbSize']  = 'suga-s-4_3';
                    $postHorizontalAttr_L['additionalClass'] = 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground';
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
          
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'center',
                'footer_style'    => '1-col',
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $cat_L_Style = 4;
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            
            $postOverlayHTML = new atbs_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-md post--overlay-padding-xl',
                'cat'               => $cat_L_Style,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'suga-m-16_9',
                'typescale'         => 'typescale-3 m-b-sm',
                'except_length'     => 20,
                'additionalExcerptClass' => 'm-b-md hidden-xs',
                'meta'              => array('author'),
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        
/** Main Col Modules **/
        static function listing_list__render($moduleID) {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postIcon = self::bk_archive_pages_post_icon();
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            $render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_b__render($moduleID) {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postIcon = self::bk_archive_pages_post_icon();
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post--horizontal-reverse  post__thumb-300 clearfix post--horizontal-reverse-big',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'postIcon'          => $postIconAttr,  
                'meta'              => array('author'),
                
            );
            
			$render_modules .= '<div class="atbssuga-post--list-horizontal-reverse">';
            $render_modules .= '<div class="posts-list">';
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_c__render($moduleID) {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postIcon = self::bk_archive_pages_post_icon();
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            $postHorizontalHTML = new suga_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-s-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'postIcon'          => $postIconAttr,  
                'except_length'     => 13,
            );
            
            
            $render_modules .= '<div class="atbssuga-post--list-horizontal-hasbackground">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_a__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $postHorizontalHTML = new suga_horizontal_1;
            
            
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $catStyle = 3; //Above the Title - No BG
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postHorizontalAttr = array (
                'additionalClass'   => 'post__thumb-250 clearfix post--horizontal__title-line',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            
            $postHorizontalAttr_L = array (
                'additionalClass'   => '',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'suga-s-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'postIcon'          => $postIconAttr,  
                'except_length'     => 13,
            );
            $render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                
                
                if($postIcon !== 'disable') {
                    $addClass = '';
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($currentPost % 5) : //Normal Posts 
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    
                    $postHorizontalAttr_L['additionalClass'] = 'post--horizontal-middle post__thumb-380 clearfix post--horizontal-hasbackground';
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div><!-- posts-list -->';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new suga_horizontal_1;
            $postOverlayHTML = new atbs_overlay_1;
            
            

            
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'center',
                'footer_style'    => '1-col',
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L_Style = 4; //Above the Title - No BG
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            
            $catStyle = 3; //Above the Title - No BG
            $cat_S_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-md post--overlay-padding-xl',
                'cat'               => $cat_L_Style,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'suga-m-16_9',
                'typescale'         => 'typescale-3 m-b-sm',
                'except_length'     => 20,
                'additionalExcerptClass' => 'm-b-md hidden-xs',
                'meta'              => array('author'),
                'postIcon'          => $postIconAttr,  
            );
            
            $postHorizontalAttr = array (
                'additionalClass'   => '',
                'cat'               => $catStyle,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'suga-xs-4_3',
                'typescale'         => 'typescale-2 custom-typescale-2',
                'except_length'     => 13,
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="atbssuga-post--grid-horizontal-title-hasline">';
			$render_modules .= '<div class="posts-list">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post__thumb-250 clearfix post--horizontal__title-line';
                    
                    if($postIcon !== 'disable') {
                        $addClass = '';
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div><!-- posts-list -->';
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        
        static function listing_grid__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
               
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new suga_vertical_3;                       
            $postVerticalAttr = array (
                'additionalClass' => 'post__thumb-295 clearfix post--vertical-readmore-big',
                'thumbSize'     => 'suga-xs-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-2 custom-typescale-2 flexbox__item',
            );
            
			$render_modules .= '<div class="posts-list row row--space-between grid-gutter-w50-h80 items-clear-both-2">';
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                
                if($postIcon !== 'disable') {
                    $postIconAttr['iconType'] = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                }
                $postVerticalAttr['postID'] = get_the_ID();
                $render_modules .= '<div class="col-md-6 col-sm-6 item-count">';
                $render_modules .= '<div class="list-tem">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
                $render_modules .= '</div>'; 
                
            endwhile;
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        
        
        static function listing_grid_small__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
            );
            suga_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            $catStyle = 3;
            $cat_Class = suga_core::bk_get_cat_class($catStyle);
            
            $postVerticalHTML = new suga_vertical_3;                       
            $postVerticalAttr = array (
                'additionalClass' => 'post__thumb-200 clearfix post--vertical-readmore-small',
                'thumbSize'     => 'suga-xs-2_1',
                'cat'           => $catStyle,
                'catClass'      => $cat_Class,
                'typescale'     => 'typescale-1 custom-typescale-1 flexbox__item',
                'postIcon'      => $postIconAttr,
            );
            
		
            $render_modules .= '<div class="row row--space-between posts-list grid-gutter-w40-h70 items-clear-both-3">';
            
            while (have_posts()): the_post();
                $currentPost = $wp_query->current_post;
               
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon !== 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType']       = suga_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = suga_core::get_post_icon_class($postIconAttr['iconType'], 'small', $moduleInfo['iconPosition'], $addClass);
                    $postVerticalAttr['postIcon']   = $postIconAttr;
                }
                $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-4">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div><!-- .row - posts-list -->';
           
            
            return $render_modules;
        }
        static function author_box($authorID){  
            $bk_author_email = get_the_author_meta('publicemail', $authorID);
            $bk_author_name = get_the_author_meta('display_name', $authorID);
            $bk_author_tw = get_the_author_meta('twitter', $authorID);
            $bk_author_go = get_the_author_meta('googleplus', $authorID);
            $bk_author_fb = get_the_author_meta('facebook', $authorID);
            $bk_author_yo = get_the_author_meta('youtube', $authorID);
            $bk_author_www = get_the_author_meta('url', $authorID);
            $bk_author_desc = get_the_author_meta('description', $authorID);
            $bk_author_posts = count_user_posts( $authorID ); 
    
            $authorImgALT = $bk_author_name;
            $authorArgs = array(
                'class' => 'avatar photo',
            );
            
            $render = '';
            $render .= '<div class="author-box author-page">';
            $render .= '<div class="author-box__image">';
            $render .= '<div class="author-avatar">';
            $render .= get_avatar($authorID, '180', '', esc_attr($authorImgALT), $authorArgs);
            $render .= '</div>';
            $render .= '</div>';
            $render .= '<div class="author-box__text">';
            $render .= '<div class="author-name meta-font">';
            $render .= '<a href="'.get_author_posts_url($authorID).'" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
            $render .= '</div>';
            $render .= '<div class="author-bio">';
            $render .= $bk_author_desc;
            $render .= '</div>';
            $render .= '<div class="author-info">';
            $render .= '<div class="row row--space-between row--flex row--vertical-center grid-gutter-20">';
            $render .= '<div class="author-socials col-xs-12">';
            $render .= '<ul class="list-unstyled list-horizontal list-space-xs">';

            if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_go != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {
                if ($bk_author_email != NULL) { $render .= '<li><a href="mailto:'. esc_attr($bk_author_email) .'"><i class="mdicon mdicon-mail_outline"></i><span class="sr-only">e-mail</span></a></li>'; } 
                if ($bk_author_www != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_www) .'" target="_blank"><i class="mdicon mdicon-public"></i><span class="sr-only">Website</span></a></li>'; } 
                if ($bk_author_tw != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_tw).'" target="_blank" ><i class="mdicon mdicon-twitter"></i><span class="sr-only">Twitter</span></a></li>'; } 
                if ($bk_author_go != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_go) .'" rel="publisher" target="_blank"><i class="mdicon mdicon-google-plus"></i><span class="sr-only">Google+</span></a></li>'; }
                if ($bk_author_fb != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_fb) . '" target="_blank" ><i class="mdicon mdicon-facebook"></i><span class="sr-only">Facebook</span></a></li>'; }
                if ($bk_author_yo != NULL) { $render .= ' <li><a href="http:www.youtube.com/user/'. esc_attr($bk_author_yo) . '" target="_blank" ><span class="sr-only">Youtube</span></a></li>'; }
            }       
                               
            $render .= '</ul>';
            $render .= '</div>';
            $render .= '</div>';
            $render .= '</div>';
            
            $render .= '</div>';
            $render .= '</div>';
            
            
            return $render;
         
        }
    } // Close suga_archive class
    
}
