<?php
/**-------------------------------------------------------------------------------------------------------------------------
 * register ajax
 */
if ( ! function_exists( 'suga_enqueue_ajax_url' ) ) {
	function suga_enqueue_ajax_url() {
        echo '<script type="application/javascript">var ajaxurl = "' . esc_url(admin_url( 'admin-ajax.php' )) . '"</script>';
	}
	add_action( 'wp_enqueue_scripts', 'suga_enqueue_ajax_url' );
}
/**-------------------------------------------------------------------------------------------------------------------------
 * Enqueue All Scripts
 */
if ( ! function_exists( 'suga_scripts_method' ) ) {
    function suga_scripts_method() {

        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('imagesLoaded');
        wp_enqueue_script('jquery-masonry', array( 'imagesLoaded' ),'', true);
        
        add_editor_style('editor-style.css');
        wp_enqueue_style( 'suga_vendors', get_template_directory_uri().'/css/vendors.css', array(), '' );
        wp_enqueue_style( 'suga-style', get_template_directory_uri().'/css/style.css', array('suga_vendors'), '' );
        
        //vendors
        wp_enqueue_script('throttle-debounce', get_template_directory_uri() . '/js/vendors/throttle-debounce.min.js', array('jquery'),false, true);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/vendors/bootstrap.min.js', array('throttle-debounce'),false, true);
        wp_enqueue_script('final-countdown', get_template_directory_uri() . '/js/vendors/countdown.min.js', array('bootstrap'),false, true);
        wp_enqueue_script('flickity', get_template_directory_uri() . '/js/vendors/flickity.min.js', array('final-countdown'),false, true);
        wp_enqueue_script('fotorama', get_template_directory_uri() . '/js/vendors/fotorama.min.js', array('flickity'),false, true);
        wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/js/vendors/magnific-popup.min.js', array('fotorama'),false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/vendors/owl-carousel.min.js', array('magnific-popup'),false, true);
        wp_enqueue_script('perfect-scrollbar', get_template_directory_uri() . '/js/vendors/perfect-scrollbar.min.js', array('owl-carousel'),false, true);
        wp_enqueue_script('theiaStickySidebar', get_template_directory_uri() . '/js/vendors/theiaStickySidebar.min.js', array('perfect-scrollbar'),false, true);
        wp_enqueue_script('vticker', get_template_directory_uri() . '/js/vendors/vticker.min.js', array('theiaStickySidebar'),false, true);
        wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/vendors/fitvids.js', array('vticker'),false, true);
        
        
        
        //theme scripts
        wp_enqueue_script('suga-scripts', get_template_directory_uri() . '/js/scripts.js', array('fitvids'),false, true);              
        
        if ( is_singular() ) {wp_enqueue_script('comment-reply');}
     }
}

add_action('wp_enqueue_scripts', 'suga_scripts_method');

/**-------------------------------------------------------------------------------------------------------------------------
 * Enqueue Admin Scripts
 */
if ( ! function_exists( 'suga_post_admin_scripts_and_styles' ) ) {
    function suga_post_admin_scripts_and_styles($hook) {        
    	if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bootstrap-admin', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.js', array(), '', true );
            wp_enqueue_style( 'bootstrap-admin', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.css', array(), '' );
   		}
        
        wp_enqueue_style( 'datepicker', get_template_directory_uri().'/css/admin/bootstrap-datepicker3.min.css', array(), '' );
        
        wp_enqueue_style( 'colorpicker', get_template_directory_uri().'/css/admin/bootstrap-colorpicker.min.css', array(), '' );
        
        wp_enqueue_style( 'suga_admin', get_template_directory_uri().'/css/admin/admin.css', array(), '' );
        
        add_editor_style('css/admin/editorstyle.css');
        
        wp_enqueue_script( 'datepickerjs', get_template_directory_uri().'/js/admin/bootstrap-datepicker.min.js', array(), '', true );
        
        wp_enqueue_script( 'colorpickerjs', get_template_directory_uri().'/js/admin/bootstrap-colorpicker.min.js', array(), '', true );
        
        wp_enqueue_script( 'autosize', get_template_directory_uri().'/js/admin/jquery.autosize.min.js', array(), '', true );
        

        
        wp_enqueue_script( 'suga_admin_scripts', get_template_directory_uri().'/js/admin/admin.js', array('jquery-ui-sortable'), '', true );
    }
}
add_action('admin_enqueue_scripts', 'suga_post_admin_scripts_and_styles');