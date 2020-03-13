<?php
function suga_modify_main_query( $query ) {
    global $suga_option;
    if($suga_option == '') {
        return;
    }    
    if($query->is_main_query() AND !is_admin() ) {
        if ( is_category() ){
            $excludeIDs = array();
            $posts_per_page = 0;
            
            $term_id = get_queried_object_id();
            
            $featAreaOption  = suga_archive::bk_get_archive_option($term_id, 'bk_category_feature_area__post_option');
            
            if(function_exists('rwmb_meta')) {
                $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $term_id );
            }else {
                $is_exclude = '';
            }
            if (isset($is_exclude) && (($is_exclude == 'global_settings') || ($is_exclude == ''))): 
                $is_exclude = $suga_option['bk_category_exclude_posts'];
            endif;
            
            if(($is_exclude == 1) || ($featAreaOption == 'latest')) {                     

                $sticky = get_option('sticky_posts') ;
                rsort( $sticky );
                
                if(function_exists('rwmb_meta')) {
                    $featLayout = rwmb_meta( 'bk_category_feature_area', array( 'object_type' => 'term' ), $term_id );
                }else {
                    $featLayout = 'global_settings';
                }
                if (isset($is_exclude) && (($featLayout == 'global_settings') || ($featLayout == ''))): 
                    $featLayout = $suga_option['bk_category_feature_area'];
                endif;
                            
                $args = array (
                    'post_type'     => 'post',
                    'cat'           => $term_id, // Get current category only
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
                    return;
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
                            
                $query->set( 'post__not_in', $excludeIDs );
            }else {
                return;
            }
        }
    }
}
add_action( 'pre_get_posts', 'suga_modify_main_query' );

require_once (get_template_directory() . '/library/meta_box_config.php');

add_theme_support('title-tag');

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 1200;
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
}

/**
 * Remove Comment Default Style
 */
add_filter( 'show_recent_comments_widget_style', '__return_false' );
  
add_action( 'after_setup_theme', 'suga_thumbnail_setup' );
if ( ! function_exists( 'suga_thumbnail_setup' ) ){

    function suga_thumbnail_setup() {
        add_image_size( 'suga-xxs-4_3', 180, 135, true );
        add_image_size( 'suga-xxs-1_1', 180, 180, true );
        add_image_size( 'suga-xs-16_9 400x225', 400, 225, true );
        add_image_size( 'suga-xs-4_3', 400, 300, true );
        add_image_size( 'suga-xs-2_1', 400, 200, true );
        add_image_size( 'suga-xs-1_1', 400, 400, true );        
        add_image_size( 'suga-xs-16_9', 600, 338, true ); 
        add_image_size( 'suga-s-4_3', 600, 450, true );
        add_image_size( 'suga-s-2_1', 600, 300, true );
        add_image_size( 'suga-s-1_1', 600, 600, true );
        add_image_size( 'suga-m-16_9', 800, 450, true );
        add_image_size( 'suga-m-4_3', 800, 600, true );
        add_image_size( 'suga-m-2_1', 800, 400, true );
        add_image_size( 'suga-l-16_9', 1200, 675, true );
        add_image_size( 'suga-l-4_3', 1200, 900, true );
        add_image_size( 'suga-l-2_1', 1200, 600, true );
        add_image_size( 'suga-xl-16_9', 1600, 900, true );
        add_image_size( 'suga-xl-4_3', 1600, 1200, true );        
        add_image_size( 'suga-xl-2_1', 1600, 800, true ); 
        add_image_size( 'suga-xxl', 2000, 1125, true );
    }

}
/**
 * Post Format 
 */
 add_action('after_setup_theme', 'suga_add_theme_format', 11);
function suga_add_theme_format() {
    add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
}
/**
 * Add Image Column To Posts Page
 */
function suga_featured_image_column_image( $image ) {
    if ( !suga_core::bk_check_has_post_thumbnail(get_the_ID()) )
        return trailingslashit( get_stylesheet_directory_uri() ) . 'images/no-featured-image';
}
add_filter( 'featured_image_column_default_image', 'suga_featured_image_column_image' );

/**
 * Title
 */
add_filter( 'wp_title', 'suga_wp_title', 10, 2 );
if ( ! function_exists( 'suga_wp_title' ) ) {
    function suga_wp_title( $title, $sep ) {
    	global $paged, $page;
    
    	if ( is_feed() ) {
    		return $title;
    	}
    
    	// Add the site name.
    	$title .= get_bloginfo( 'name' );
    
    	// Add the site description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) ) {
    		$title = "$title $sep $site_description";
    	}
    
    	// Add a page number if necessary.
    	if ( $paged >= 2 || $page >= 2 ) {
    		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'suga' ), max( $paged, $page ) );
    	}
    
    	return $title;
    }
}
/**
 * Register menu locations
 *---------------------------------------------------
 */
if ( ! function_exists( 'suga_register_menu' ) ) {
    function suga_register_menu() {
        register_nav_menu('top-menu', esc_html__( 'Top Menu', 'suga' ));
        register_nav_menu('main-menu', esc_html__( 'Main Menu', 'suga' ));
        register_nav_menu('footer-menu', esc_html__( 'Footer Menu', 'suga' )); 
        register_nav_menu('offcanvas-menu', esc_html__( 'Offcanvas Menu', 'suga' )); 
    }
}
add_action( 'init', 'suga_register_menu' );

function suga_category_nav_class( $classes, $item ){
    /*
    if(isset($item->bkmegamenu[0])) :
        if ($item->bkmegamenu[0]) {
            $classes[] = 'menu-category-megamenu';
        }
        if( 'category' == $item->object ){
            $classes[] = 'menu-item-cat-' . $item->object_id;
        }
    endif;
    */
    if( 'category' == $item->object ){
        $classes[] = 'menu-item-cat-' . $item->object_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'suga_category_nav_class', 10, 4 );

function suga_custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'suga_custom_excerpt_length', 999 );

/**
 * ReduxFramework
 */
/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux admin page
 */
if ( ! function_exists( 'suga_remove_redux_page' ) ) {
	function suga_remove_redux_page() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}
	add_action( 'admin_menu', 'suga_remove_redux_page', 12 );
}
/**-------------------------------------------------------------------------------------------------------------------------
 * Init
 */
if ( !isset( $suga_option ) && file_exists( SUGA_LIBS.'theme-option.php' ) ) {
    require_once( SUGA_LIBS.'theme-option.php' );
}
/**
 * Register sidebars and widgetized areas.
 *---------------------------------------------------
 */
 if ( ! function_exists( 'suga_widgets_init' ) ) {
    function suga_widgets_init() {
        $suga_option = suga_core::bk_get_global_var('suga_option');
        $headingStyle = isset($suga_option['bk-default-widget-heading']) ? $suga_option['bk-default-widget-heading'] : '';
        if($headingStyle) {
            $headingClass = suga_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = 'block-heading--line';
        }
        register_sidebar( array(
    		'name' => esc_html__('Sidebar', 'suga'),
    		'id' => 'home_sidebar',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading '.$headingClass.'"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Desktop OffCanvas Area', 'suga'),
    		'id' => 'offcanvas-widget-area',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading no-line"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Mobile OffCanvas Area', 'suga'),
    		'id' => 'mobile-offcanvas-widget-area',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading no-line"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 1', 'suga'),
    		'id' => 'footer_sidebar_1',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 2', 'suga'),
    		'id' => 'footer_sidebar_2',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 3', 'suga'),
    		'id' => 'footer_sidebar_3',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
    }
}
add_action( 'widgets_init', 'suga_widgets_init' );

/**
 * Save Post Content Word Count
 *---------------------------------------------------
 */
function bk_post_content__word_count($postID){
    $content = get_post_field( 'post_content', $postID );
    $word_count = str_word_count( strip_tags( $content ) );
    $lastLength = get_post_meta($postID, 'bk_post_content__word_count');
    if(!empty($lastLength)) :
        if(($lastLength[0] != '') && ($lastLength[0] != $word_count)) :
            update_post_meta($postID, 'bk_post_content__word_count', $word_count);
        elseif($lastLength[0] == '') :
            add_post_meta($postID, 'bk_post_content__word_count', $word_count, true);
        endif;
    endif;
}

add_action( 'post_updated', 'bk_post_content__word_count', 10, 1 ); //don't forget the last argument to allow all three arguments of the function

/**
 * Add responsive container to embeds video
 */
if ( !function_exists('bk_embed_html') ){
	function bk_embed_html( $embed, $url = '', $attr = '' ) {
		$accepted_providers = array(
			'youtube',
			'vimeo',
			'slideshare',
			'dailymotion',
			'viddler.com',
			'hulu.com',
			'blip.tv',
			'revision3.com',
			'funnyordie.com',
			'wordpress.tv',
		);
		$resize = false;

		// Check each provider
		foreach ( $accepted_providers as $provider ) {
			if ( strstr( $url, $provider ) ) {
				$resize = true;
				break;
			}
		}
		if ( $resize ) {
	    	return '<div class="atbssuga-responsive-video">' . $embed . '</div>';
	    } else {
	    	return $embed;
	    }
	}
}
add_filter( 'embed_oembed_html', 'bk_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'bk_embed_html' ); // Jetpack

/**
 * Limit number of tags in widget tag cloud
 */
if ( !function_exists('suga_tag_widget_limit') ) {
  function suga_tag_widget_limit($args){

    //Check if taxonomy option inside widget is set to tags
    if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
      $args['number'] = 16; //Limit number of tags
      $args['smallest'] = 12; //Size of lowest count tags
      $args['largest'] = 12; //Size of largest count tags
      $args['unit'] = 'px'; //Unit of font size
      $args['orderby'] = 'count'; //Order by counts
      $args['order'] = 'DESC';
    }

    return $args;
  }
}
add_filter('widget_tag_cloud_args', 'suga_tag_widget_limit');
?>