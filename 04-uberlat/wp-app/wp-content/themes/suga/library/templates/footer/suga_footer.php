<?php
if (!class_exists('suga_footer')) {
    class suga_footer {
        static function bk_footer_mailchimp(){
            $suga_option = suga_core::bk_get_global_var('suga_option');
            $htmlOutput = '';
			
            if(isset($suga_option['footer-mailchimp--shortcode']) && ($suga_option['footer-mailchimp--shortcode'] != '')) :
    			$htmlOutput .= do_shortcode($suga_option['footer-mailchimp--shortcode']);
            endif;
            
            return $htmlOutput;
        }
        
    } // Close suga_single
    
}