<?php
if (!class_exists('suga_ajax_post_list')) {
    class suga_ajax_post_list {
        //Search Query
        static function suga_query($args) {    
            $the_query = new WP_Query($args);
            unset($args);
            wp_reset_postdata();                                                            
            return $the_query;
        }
    }
}
add_action('wp_ajax_nopriv_suga_author_results', 'suga_author_results');
add_action('wp_ajax_suga_author_results', 'suga_author_results');
if (!function_exists('suga_author_results')) {
    function suga_author_results()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null; 
        $args['offset'] = $postOffset;
        $dataReturn = 'no-result';
        
        $users = new WP_User_Query( $args );
        $users_found = $users->get_results();
        $user_count = count($users_found);
        
        if ( $user_count > 0 ) :
            $dataReturn = suga_archive::bk_render_authors($users_found);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_a', 'suga_posts_listing_list_alt_a');
add_action('wp_ajax_suga_posts_listing_list_alt_a', 'suga_posts_listing_list_alt_a');
if (!function_exists('suga_posts_listing_list_alt_a')) {
    function suga_posts_listing_list_alt_a()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_a;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_a_no_sidebar', 'suga_posts_listing_list_alt_a_no_sidebar');
add_action('wp_ajax_suga_posts_listing_list_alt_a_no_sidebar', 'suga_posts_listing_list_alt_a_no_sidebar');
if (!function_exists('suga_posts_listing_list_alt_a_no_sidebar')) {
    function suga_posts_listing_list_alt_a_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_a_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_b_no_sidebar', 'suga_posts_listing_list_alt_b_no_sidebar');
add_action('wp_ajax_suga_posts_listing_list_alt_b_no_sidebar', 'suga_posts_listing_list_alt_b_no_sidebar');
if (!function_exists('suga_posts_listing_list_alt_b_no_sidebar')) {
    function suga_posts_listing_list_alt_b_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
    
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_b_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_c_no_sidebar', 'suga_posts_listing_list_alt_c_no_sidebar');
add_action('wp_ajax_suga_posts_listing_list_alt_c_no_sidebar', 'suga_posts_listing_list_alt_c_no_sidebar');
if (!function_exists('suga_posts_listing_list_alt_c_no_sidebar')) {
    function suga_posts_listing_list_alt_c_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
    
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_c_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_b', 'suga_posts_listing_list_alt_b');
add_action('wp_ajax_suga_posts_listing_list_alt_b', 'suga_posts_listing_list_alt_b');
if (!function_exists('suga_posts_listing_list_alt_b')) {
    function suga_posts_listing_list_alt_b()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;      
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_b;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_alt_c', 'suga_posts_listing_list_alt_c');
add_action('wp_ajax_suga_posts_listing_list_alt_c', 'suga_posts_listing_list_alt_c');
if (!function_exists('suga_posts_listing_list_alt_c')) {
    function suga_posts_listing_list_alt_c()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) :
            $thismodule = new suga_posts_listing_list_alt_c;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        else :
            $dataReturn = 'no-result';        
        endif;
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list', 'suga_posts_listing_list');
add_action('wp_ajax_suga_posts_listing_list', 'suga_posts_listing_list');
if (!function_exists('suga_posts_listing_list')) {
    function suga_posts_listing_list()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_list;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_b', 'suga_posts_listing_list_b');
add_action('wp_ajax_suga_posts_listing_list_b', 'suga_posts_listing_list_b');
if (!function_exists('suga_posts_listing_list_b')) {
    function suga_posts_listing_list_b()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_list_b;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_c', 'suga_posts_listing_list_c');
add_action('wp_ajax_suga_posts_listing_list_c', 'suga_posts_listing_list_c');
if (!function_exists('suga_posts_listing_list_c')) {
    function suga_posts_listing_list_c()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_list_c;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_no_sidebar', 'suga_posts_listing_list_no_sidebar');
add_action('wp_ajax_suga_posts_listing_list_no_sidebar', 'suga_posts_listing_list_no_sidebar');
if (!function_exists('suga_posts_listing_list_no_sidebar')) {
    function suga_posts_listing_list_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_list_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_list_b_no_sidebar', 'suga_posts_listing_list_b_no_sidebar');
add_action('wp_ajax_suga_posts_listing_list_b_no_sidebar', 'suga_posts_listing_list_b_no_sidebar');
if (!function_exists('suga_posts_listing_list_b_no_sidebar')) {
    function suga_posts_listing_list_b_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_list_b_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid', 'suga_posts_listing_grid');
add_action('wp_ajax_suga_posts_listing_grid', 'suga_posts_listing_grid');
if (!function_exists('suga_posts_listing_grid')) {
    function suga_posts_listing_grid()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args       = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $type       = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid;
            $dataReturn = $thismodule->render_modules($the_query, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid_alt_a', 'suga_posts_listing_grid_alt_a');
add_action('wp_ajax_suga_posts_listing_grid_alt_a', 'suga_posts_listing_grid_alt_a');
if (!function_exists('suga_posts_listing_grid_alt_a')) {
    function suga_posts_listing_grid_alt_a()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid_alt_a;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid_alt_b', 'suga_posts_listing_grid_alt_b');
add_action('wp_ajax_suga_posts_listing_grid_alt_b', 'suga_posts_listing_grid_alt_b');
if (!function_exists('suga_posts_listing_grid_alt_b')) {
    function suga_posts_listing_grid_alt_b()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null; 
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid_alt_b;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid_no_sidebar', 'suga_posts_listing_grid_no_sidebar');
add_action('wp_ajax_suga_posts_listing_grid_no_sidebar', 'suga_posts_listing_grid_no_sidebar');
if (!function_exists('suga_posts_listing_grid_no_sidebar')) {
    function suga_posts_listing_grid_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid_no_sidebar;
                                    
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid_small', 'suga_posts_listing_grid_small');
add_action('wp_ajax_suga_posts_listing_grid_small', 'suga_posts_listing_grid_small');
if (!function_exists('suga_posts_listing_grid_small')) {
    function suga_posts_listing_grid_small()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid_small;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
    }
}
add_action('wp_ajax_nopriv_suga_posts_listing_grid_small_no_sidebar', 'suga_posts_listing_grid_small_no_sidebar');
add_action('wp_ajax_suga_posts_listing_grid_small_no_sidebar', 'suga_posts_listing_grid_small_no_sidebar');
if (!function_exists('suga_posts_listing_grid_small_no_sidebar')) {
    function suga_posts_listing_grid_small_no_sidebar()
    {        
        check_ajax_referer( 'suga_ajax_security', 'securityCheck' );
        $args      = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $postOffset = isset( $_POST['postOffset'] ) ? $_POST['postOffset'] : null;    
        $type      = isset( $_POST['type'] ) ? $_POST['type'] : null;   
        $moduleInfo = isset( $_POST['moduleInfo'] ) ? $_POST['moduleInfo'] : null;   
        $the__lastPost = isset( $_POST['the__lastPost'] ) ? $_POST['the__lastPost'] : 0;   
        
        $dataReturn = 'no-result';
        
        $args['offset'] = $postOffset;
        
        $the_query = suga_ajax_post_list::suga_query($args);
        
        if ( $the_query->have_posts()) {
            $thismodule = new suga_posts_listing_grid_small_no_sidebar;
            $dataReturn = $thismodule->render_modules($the_query, 0, $moduleInfo);
        }else {
            $dataReturn = 'no-result';        
        }
        die(json_encode($dataReturn));
        
    }
}