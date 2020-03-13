<?php
if (!class_exists('suga_custom_html')) {
    class suga_custom_html {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('suga_custom_html-');
            
            $moduleConfigs['title']             = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['heading_style']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse']   = 'no';
            $moduleConfigs['customHTML']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_html', true );
            
            $moduleConfigs['custom_class']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_class', true );
            if($moduleConfigs['custom_class'] != '') {
                $moduleCustomClass = ' '.$moduleConfigs['custom_class'];
            }else {
                $moduleCustomClass = '';
            }
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = suga_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
                $blockOpen  = '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-custom-html '.$moduleCustomClass.'">';  
                $blockClose = '</div><!-- .atbssuga-block -->';                       
            }else {
                $blockOpen  = '<div id="'.$moduleID.'" class="atbssuga-block atbssuga-block--fullwidth atbssuga-custom-html"><div class="container">';  
                $blockClose = '</div><!-- .container --></div><!-- .atbssuga-block -->';
            }
            
            $block_str .= $blockOpen;
            $block_str .= suga_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= $moduleConfigs['customHTML'];
            $block_str .= $blockClose;

            return $block_str;
    	}
        
    }
}