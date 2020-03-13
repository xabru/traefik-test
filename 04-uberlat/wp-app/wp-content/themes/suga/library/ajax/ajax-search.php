<?php
if (!class_exists('suga_ajax_search')) {
    class suga_ajax_search {
        //Search Query
        static function suga_query($searchTerm) {
            $args = array(
                's' => esc_sql($searchTerm),
                'post_type' => array('post'),
                'post_status' => 'publish',
                'posts_per_page' => 5,
            );
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function suga_ajax_content( $the_query, $users_found ) {
            $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
            
            // Category
            $cat_L_Style = 4; //Category Top Left
            $cat_L_Class = suga_core::bk_get_cat_class($cat_L_Style);
            
            $postOverlayHTML = new atbs_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'       => 'post--overlay-height-320 post-grid-video-space-between',
                'cat'                   => $cat_L_Style,
                'catClass'              => $cat_L_Class . ' color-white',
                'meta'                  => array('date'),
                'thumbSize'             => 'suga-m-2_1',
                'typescale'             => '',
                'postIcon'              => $postIconAttr,
            );
            
            $postVerticalHTML = new suga_vertical_1;
            $postVerticalAttr = array (
                'additionalClass'   => 'post--vertical-thumb-reverse post__thumb-220',
                'thumbSize'         => 'suga-s-1_1',
                'typescale'         => 'typescale-2 custom-typescale-2',
            );
            
            $postHorizontalHTML = new suga_horizontal_2;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-search post--horizontal-reverse post--horizontal-xxs post__thumb-70',
                'thumbSize'         => 'suga-xxs-1_1',
                'typescale'         => 'typescale-0 custom-typescale-0',
                'postIcon'          => $postIconAttr,  
            );
                                    
            $search_data = '';
            $search_data .= '<div class="atbssuga-search-full--result-inner">';                        
            $search_data .= '<div class="show-content">';
            
            $maxPosts = $the_query->post_count;
            
            $postCount = 1;                                    
            if ( $the_query->have_posts() ): $the_query->the_post();
                $postOverlayAttr['postID'] = get_the_ID();
                $search_data .= $postOverlayHTML->render($postOverlayAttr);
                $postCount ++;                
            endif;
            $search_data .= '<div class="post-grid-result post-list">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                if($postCount == 2):
                    $search_data .= '<div class="post-grid-result--left">';
                    $search_data .= '<div class="list-item">';
                    $postVerticalAttr['postID'] = get_the_ID();                    
                    $search_data .= $postVerticalHTML->render($postVerticalAttr);
                    $search_data .= '</div> <!-- list-item -->';
                    $search_data .= '</div> <!-- post-grid-result--left -->';
                endif;
                
                if($postCount > 2) :
                    if($postCount == 3) :                
                        $search_data .= '<div class="post-grid-result--body">';
                    endif;
                                                            
                    $search_data .= '<div class="list-item">';
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $search_data .= $postHorizontalHTML->render($postHorizontalAttr);
                    $search_data .= '</div> <!-- list-item -->';
                    
                    if($postCount == $maxPosts) :                                                
                        $search_data .= '</div> <!-- post-grid-result--body -->';
                    endif;                                                            
                endif;                                                
                $postCount ++;
            endwhile;
            if($postCount > 1) :            
                $search_data .= '</div> <!-- post-grid-result -->';
                $search_data .= '<nav class="atbssuga-pagination text-center">';
                $search_data .= '<button class="btn btn-default js-ajax-load-post-trigger"><a href="' . get_search_link($searchTerm) . '">' .esc_html__('Show all results', 'suga'). '</a></button>';
                $search_data .= '</nav>';
            endif;
                                                
            $search_data .= '</div> <!-- Show Content -->';
            $search_data .= '</div> <!-- atbssuga-search-full--result-inner -->';
                                                                        
            return $search_data;
        }
    }
}
add_action('wp_ajax_nopriv_suga_ajax_search', 'suga_ajax_search');
add_action('wp_ajax_suga_ajax_search', 'suga_ajax_search');
if (!function_exists('suga_ajax_search')) {
    function suga_ajax_search()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        
        $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
        
        $dataReturn = '<div class="suga-ajax-no-result">' . esc_html__('No results', 'suga') . '</div>';
    
        $the_query = suga_ajax_search::suga_query($searchTerm);
        
        $users = new WP_User_Query( array(
            'search'         => '*'.esc_attr( $searchTerm ).'*',
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ),
        ) );
        
        $users_found = $users->get_results();
        
        if (( $the_query->have_posts() ) || count($users_found)) {
            $dataReturn = suga_ajax_search::suga_ajax_content($the_query, $users_found);
        }else {
            $dataReturn = '<div class="suga-ajax-no-result">' . esc_html__('No results', 'suga') . '</div>';
        }
        die(json_encode($dataReturn));
    }
}