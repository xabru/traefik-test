<?php
if (!class_exists('suga_ajax_megamenu')) {
    class suga_ajax_megamenu {
        //Search Query
        static function suga_query($CatID) {
            $args = array(
                'cat' => $CatID,  
                'post_type' => 'post',  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1,  
                'posts_per_page' => 4
            );
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function suga_ajax_content( $the_query, $hasBigPost ) {
            $contentReturn = '';
            if($hasBigPost == 1) {
                $contentReturn .= suga_header::bk_get_megamenu_1stlarge_posts($the_query); 
            }else {
                $contentReturn .= suga_header::bk_get_megamenu_posts($the_query); 
            }
            return $contentReturn;
        }
    }
}
add_action('wp_ajax_nopriv_suga_ajax_megamenu', 'suga_ajax_megamenu');
add_action('wp_ajax_suga_ajax_megamenu', 'suga_ajax_megamenu');
if (!function_exists('suga_ajax_megamenu')) {
    function suga_ajax_megamenu()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        
        $CatID      = isset( $_POST['thisCatID'] ) ? $_POST['thisCatID'] : null; 
        $hasBigPost = isset( $_POST['hasBigPost'] ) ? $_POST['hasBigPost'] : null; 
        
        $dataReturn = 'no-result';
        
        $the_query = suga_ajax_megamenu::suga_query($CatID);
        
        if ( $the_query->have_posts() ) {
            $dataReturn = suga_ajax_megamenu::suga_ajax_content($the_query, intval($hasBigPost));
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}