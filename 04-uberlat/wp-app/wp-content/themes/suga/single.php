<?php
    $suga_option = suga_core::bk_get_global_var('suga_option');
    
    if(function_exists('bk_set__cookie')) {
        $suga_cookie = bk_set__cookie();
    }else {
        $suga_cookie = 1;
    }
    
    get_header();
    
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    
    $postID = get_the_ID();  
    
    if ($suga_cookie == 1) {
        suga_core::bk_setPostViews($postID);
    }
    
    $suga_single_template = 'single-1';
    
    if (isset($suga_option) && ($suga_option != '')): 
        $bk_single_template = $suga_option['bk-single-template'];
    endif;
    
    if(function_exists('has_post_format')):
        $postFormat = get_post_format($postID);
    else :
        $postFormat = 'standard';
    endif;
    
    $sidebar_option = '';
    $sidebar        =  suga_single::bk_get_post_option($postID, 'bk_post_sb_select'); 
    if(!is_active_sidebar($sidebar)) {
        $sidebar_option = 'disable';
    }
    
    $bkPostLayout = get_post_meta($postID,'bk_post_layout_standard',true);
    
    if($bkPostLayout == 'global_settings') {
        $finalPostLayout = $bk_single_template;
    }else {
        $finalPostLayout = $bkPostLayout;
    }
    if($finalPostLayout == '') {
        $finalPostLayout = 'single-1';
    }
    
    if($finalPostLayout == 'single-1') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-1' ); //single-1
        }else {
            get_template_part( '/library/templates/single/partials/single-style-a--no-sidebar' ); //single-style-nosidebar
        }
    }else if($finalPostLayout == 'single-2') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-2' ); //single-1-alt
        }else {
            get_template_part( '/library/templates/single/partials/single-style-a--no-sidebar' ); //single-style-nosidebar
        }
    }else if($finalPostLayout == 'single-3') {
        get_template_part( '/library/templates/single/partials/single-3' ); //single-1--no-sidebar
    }else if($finalPostLayout == 'single-4') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-4' ); //single-2
        }else {
            get_template_part( '/library/templates/single/partials/single-style-a--no-sidebar' ); //single-style-nosidebar
        }
    }else if($finalPostLayout == 'single-5') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-5' ); //single-2-alt
        }else {
            get_template_part( '/library/templates/single/partials/single-style-a--no-sidebar' ); //single-style-nosidebar
        }
    }else if($finalPostLayout == 'single-6') {
        get_template_part( '/library/templates/single/partials/single-6' ); //single-2--no-sidebar
    }else if($finalPostLayout == 'single-7') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-7' ); //single-3
        }else {
            get_template_part( '/library/templates/single/partials/single-8' ); //single-3--no-sidebar
        }
    }else if($finalPostLayout == 'single-8') {
        get_template_part( '/library/templates/single/partials/single-8' ); //single-3--no-sidebar
    }else if($finalPostLayout == 'single-9') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-9' ); //single-4
        }else {
            get_template_part( '/library/templates/single/partials/single-10' ); //single-4--no-sidebar
        }
    }else if($finalPostLayout == 'single-10') {
        get_template_part( '/library/templates/single/partials/single-10' ); //single-4--no-sidebar
    }else if($finalPostLayout == 'single-11') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-11' ); //single-5
        }else {
            get_template_part( '/library/templates/single/partials/single-13' ); //single-5--No Sidebar
        }
    }else if($finalPostLayout == 'single-12') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-12' ); //single-5--Center
        }else {
            get_template_part( '/library/templates/single/partials/single-13' ); //single-5--No Sidebar
        }
    }else if($finalPostLayout == 'single-13') {
        get_template_part( '/library/templates/single/partials/single-13' ); //single-5--No Sidebar
    }else if($finalPostLayout == 'single-14') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-14' ); //single-6
        }else {
            get_template_part( '/library/templates/single/partials/single-16' ); //single-6--No Sidebar
        }
    }else if($finalPostLayout == 'single-15') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-15' ); //single-6--Center
        }else {
            get_template_part( '/library/templates/single/partials/single-16' ); //single-6--No Sidebar
        }
    }else if($finalPostLayout == 'single-16') {
        get_template_part( '/library/templates/single/partials/single-16' ); //single-6--No Sidebar
    }else if($finalPostLayout == 'single-18') {
        if($sidebar_option != 'disable') {
            get_template_part( '/library/templates/single/partials/single-18' ); //single-18
        }else {
            get_template_part( '/library/templates/single/partials/single-style-a--no-sidebar' ); //single-style-nosidebar
        }
    }else if($finalPostLayout == 'single-17') {
        if($postFormat != 'video') :
            get_template_part( '/library/templates/single/single-1' );
        else :
            get_template_part( '/library/templates/single/partials/single-17' ); //single-7 - Video
        endif;        
    }else {
        get_template_part( '/library/templates/single/partials/'.$bk_single_template );
    }
    
    endwhile; endif;
    
    get_footer(); 
?>