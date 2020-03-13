<?php
if (!class_exists('suga_shortcode')) {
    class suga_shortcode {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_custom_html-');
            $i=0;
            
            $moduleConfigs['title']             = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['heading_style']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse']   = 'no';
            $moduleConfigs['shortcode']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_shortcode', true );
            
            $shortcodes = explode("[shortcode_separator]",$moduleConfigs['shortcode']);
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = suga_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
                $blockOpen  = '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-shortcode-module">';  
                $blockClose = '</div><!-- .atbssuga-block -->';                       
            }else {
                $blockOpen  = '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth atbssuga-shortcode-module"><div class="container">';  
                $blockClose = '</div><!-- .container --></div><!-- .atbssuga-block -->';
            }
            
            $block_str .= $blockOpen;
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            for ($i=0; $i< count($shortcodes); $i++) {
                $block_str .= do_shortcode($shortcodes[$i]);
            }
            $block_str .= $blockClose;

            return $block_str;
    	}
        
    }
}