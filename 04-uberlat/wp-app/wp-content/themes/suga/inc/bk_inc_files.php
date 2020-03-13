<?php
    require_once (SUGA_INC.'composer/bk_pd_cfg.php');
    require_once (SUGA_INC.'composer/render-sections.php');
    
    //require_once (get_template_directory().'/plugins/sitelinks-search-box.php');
// Section


// Suga Block 
    require_once (SUGA_BLOCKS.'suga/suga_feature_a.php');
    require_once (SUGA_BLOCKS.'suga/suga_feature_b.php');
    require_once (SUGA_BLOCKS.'suga/suga_feature_slider_a.php');
    require_once (SUGA_BLOCKS.'suga/suga_feature_slider_b.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_a.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_b.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_c.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_d.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_e.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_f.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_g.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_h.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_i.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_j.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_k.php');
    require_once (SUGA_BLOCKS.'suga/suga_grid_l.php');
    
 
    // Has Sidebar 
    require_once (SUGA_BLOCKS.'suga/posts_listing_list_b.php');
    require_once (SUGA_BLOCKS.'suga/posts_listing_list_b_no_sidebar.php');
    require_once (SUGA_BLOCKS.'suga/posts_listing_list_c.php');
    require_once (SUGA_BLOCKS.'suga/suga_main_col_grid_a.php');
    require_once (SUGA_BLOCKS.'suga/suga_main_col_grid_b.php');
    require_once (SUGA_BLOCKS.'suga/suga_main_col_grid_c.php');
    require_once (SUGA_BLOCKS.'suga/suga_main_col_grid_d.php');
    
// Suga Module 
    require_once(SUGA_MODULES.'suga/suga_horizontal_1.php');
    require_once(SUGA_MODULES.'suga/suga_horizontal_2.php');
    require_once(SUGA_MODULES.'suga/suga_horizontal_3.php');// 2 post thumb
    require_once(SUGA_MODULES.'suga/suga_vertical_1.php');
    require_once(SUGA_MODULES.'suga/suga_vertical_2.php');
    require_once(SUGA_MODULES.'suga/suga_vertical_3.php');
    require_once(SUGA_MODULES.'suga/suga_vertical_4.php');
    require_once(SUGA_MODULES.'suga/suga_overlay_1.php');
    require_once(SUGA_MODULES.'suga/suga_overlay_2.php');
    require_once(SUGA_MODULES.'suga/suga_overlay_3.php');
    require_once(SUGA_MODULES.'suga/suga_overlay_4.php');
    
    require_once(SUGA_MODULES.'suga/suga_overlay_nothumb_1.php');
    require_once(SUGA_MODULES.'suga/suga_overlay_nothumb_2.php');
    
    require_once(SUGA_MODULES.'suga/suga_overlap_1.php');
    
// Block Fullwidth
    require_once (SUGA_BLOCKS.'news_ticker.php');
    require_once (SUGA_BLOCKS.'countdown.php');
    require_once (SUGA_BLOCKS.'carousel_heading_aside.php');
 

    require_once (SUGA_BLOCKS.'posts_listing_grid.php');
    require_once (SUGA_BLOCKS.'posts_listing_grid_no_sidebar.php');
    require_once (SUGA_BLOCKS.'posts_listing_grid_small_no_sidebar.php');
    require_once (SUGA_BLOCKS.'posts_listing_list_no_sidebar.php');
    require_once (SUGA_BLOCKS.'posts_listing_list_alt_a_no_sidebar.php');
    require_once (SUGA_BLOCKS.'posts_listing_list_alt_b_no_sidebar.php');
// Block has sidebar

    require_once (SUGA_BLOCKS.'posts_listing_list_alt_a.php');
    require_once (SUGA_BLOCKS.'posts_listing_list_alt_b.php');
    require_once (SUGA_BLOCKS.'posts_listing_list.php');
    require_once (SUGA_BLOCKS.'posts_listing_grid_small.php');
    require_once (SUGA_BLOCKS.'custom_html.php');
    require_once (SUGA_BLOCKS.'short_code.php');
        
// Include Post Modules
    require_once(SUGA_MODULES.'horizontal_1.php');
    require_once(SUGA_MODULES.'horizontal_2.php');
    require_once(SUGA_MODULES.'horizontal_feat_block_a.php');
    require_once(SUGA_MODULES.'vertical_1.php'); 
    require_once(SUGA_MODULES.'vertical_1_ratio_2by1.php'); 
    require_once(SUGA_MODULES.'vertical_icon_side_right.php'); 
    require_once(SUGA_MODULES.'vertical_icon_side_right_ratio_2by1.php'); 
    require_once(SUGA_MODULES.'vertical_icon_side_left.php');
    require_once(SUGA_MODULES.'vertical_with_default_thumb.php'); 
    require_once(SUGA_MODULES.'overlay_1.php');
    require_once(SUGA_MODULES.'overlay_icon_side_right.php');
    require_once(SUGA_MODULES.'overlay_icon_side_left.php');
    require_once(SUGA_MODULES.'card_1.php');
    require_once(SUGA_MODULES.'thumb_overlap.php');
    require_once(SUGA_MODULES.'category_tile.php');
    
//Libs        
// Header Libs
    require_once(SUGA_HEADER_TEMPLATES.'suga_header.php');
    require_once(SUGA_FOOTER_TEMPLATES.'suga_footer.php');
    require_once(SUGA_SINGLE_TEMPLATES.'suga_single.php');
    
    require_once(SUGA_INC_LIBS.'suga_get_configs.php');
    require_once(SUGA_INC_LIBS.'suga_core.php');
    require_once(SUGA_INC_LIBS.'suga_tgm_activation.php');
    require_once(SUGA_INC_LIBS.'suga_query.php');
    require_once(SUGA_INC_LIBS.'suga_cache.php');
    require_once(SUGA_INC_LIBS.'suga_youtube.php');
    require_once(SUGA_LIBS.'meta_box_config.php');
    
// Include Ajax Files
    require_once(SUGA_AJAX.'ajax-function.php');
    require_once(SUGA_AJAX.'ajax-search.php');
    require_once(SUGA_AJAX.'ajax-megamenu.php');
    require_once(SUGA_AJAX.'ajax-post-list.php');
//Widgets
    //include(get_template_directory()."/framework/widgets/widget_facebook.php");
    require_once(SUGA_INC_LIBS.'suga_widget.php');
// Archive
    require_once(SUGA_INC_LIBS.'suga_archive.php');
