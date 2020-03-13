<?php
/*
Plugin Name: SUGA Extension
Plugin URI: 
Description: SUGA extension (more functional, widgets, etc.)
Author: bkninja
Version: 1.0
Author URI: http://bk-ninja.com
*/
if (!defined('SUGA_FUNCTIONS_PLUGIN_DIR')) {
    define('SUGA_FUNCTIONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-posts-list.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-most-commented.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-review-list.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-social-counters.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-subscribe.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-category-tiles.php");
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/widget-instagram.php");
// widget suga
include(SUGA_FUNCTIONS_PLUGIN_DIR."/widgets/suga/widget-posts-slider.php");

if ( ! function_exists( 'bk_contact_data' ) ) {  
    function bk_contact_data($contactmethods) {
    
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['publicemail'] = 'Public Email';
        $contactmethods['twitter'] = 'Twitter URL';
        $contactmethods['facebook'] = 'Facebook URL';
        $contactmethods['youtube'] = 'Youtube Username';
        $contactmethods['googleplus'] = 'Google+ (Entire URL)';
         
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'bk_contact_data');

/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux sample config & notice
 */
if ( ! function_exists( 'suga_redux_remove_notice' ) ) {
	function suga_redux_remove_notice() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		}
	}
	add_action( 'redux/loaded', 'suga_redux_remove_notice' );
}
if ( ! function_exists( 'bk_set__cookie' ) ) {
    function bk_set__cookie(){
        if (class_exists('suga_core')) {
            $suga_option = suga_core::bk_get_global_var('suga_option');
            $cookietime = $suga_option['bk-post-view--cache-time'];
            //echo (preg_replace('/[^A-Za-z0-9]/', '', $_SERVER["REQUEST_URI"]));
            $bk_uri = explode('/', $_SERVER["REQUEST_URI"]);
            $bkcookied = 0;
            if($bk_uri[count($bk_uri) - 1] !== '') {
                $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 1]);
            }else {
                $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 2]);
            }
            if(!isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, '1', time() + $cookietime);  /* expire in 1 hour */
                $bkcookied = 1;
            }else {
                $bkcookied = 0;
            }
            return $bkcookied;
        }
    }
}
/**-------------------------------------------------------------------------------------------------------------------------
 * suga_extension_single_footer_interaction
 */
if ( ! function_exists( 'suga_extension_single_footer_interaction' ) ) {
	function suga_extension_single_footer_interaction($postID, $class= '') {
	   ?>
    	<div class="entry-interaction__right">
    		<?php echo suga_single::bk_entry_interaction_footer($postID);?>
    	</div>
    <?php
    }
}
/**-------------------------------------------------------------------------------------------------------------------------
 * suga_extension_single_entry_interaction
 */
if ( ! function_exists( 'suga_extension_single_entry_interaction' ) ) {
	function suga_extension_single_entry_interaction($postID, $class= '') {
	   ?>
        <div class="entry-interaction entry-interaction--horizontal">
        	<div class="entry-interaction__left">
        		<div class="post-sharing post-sharing--simple">
        			<ul>
        				<?php echo suga_single::bk_entry_interaction_share($postID);?>
        			</ul>
        		</div>
        	</div>
        
        	<div class="entry-interaction__right">
        		<?php echo suga_single::bk_entry_interaction_comments($postID);?>
        	</div>
        </div>
    <?php
    }
}
/**-------------------------------------------------------------------------------------------------------------------------
 * suga_extension_single_entry_interaction
 */
if ( ! function_exists( 'suga_extension_single_entry_interaction__sticky_share_box' ) ) {
	function suga_extension_single_entry_interaction__sticky_share_box($postID, $class= '') {
	   ?>
        <div class="single-content-left <?php echo esc_html($class);?>">
        	<div class="social-share">
    			<ul class="social-list social-list--md">
    				<?php echo suga_single::bk_entry_interaction_share($postID);?>
    			</ul>
        	</div>
            <div class="social-share-label-wrap">
                <span class="social-share-label"><?php esc_html_e('Share', 'the-next-mag'); ?> </span>
                <span class="social-share-label label-vertical-trl"><?php esc_html_e('Share', 'the-next-mag'); ?> </span>
            </div>
        </div>
    <?php
    }
}
?>