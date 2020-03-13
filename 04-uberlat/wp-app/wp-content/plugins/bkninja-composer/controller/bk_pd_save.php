<?php
/*
 * Save Page Builder
 */
add_action( 'wp_ajax_bk_gutenberg_save_page', 'bk_gutenberg_save_page' );
add_action('wp_ajax_nopriv_bk_gutenberg_save_page', 'bk_gutenberg_save_page');
if ( ! function_exists( 'bk_gutenberg_save_page' ) ) {
    function bk_gutenberg_save_page() {
        global $post;
        $maxCount = 100;
        
        if(!is_admin()) {
            return;
        } 
        
    	if(!isset($_POST['post_ID'])) die();
    	if (isset($_POST['post_type']) && ( 'page' != $_POST['post_type'] )) die();
    
    	$section_counter = 1;
        $module_counter = 1;
        
        // Delete all data in page before update the new config
        for($section_counter=1; $section_counter < $maxCount; $section_counter++) {
            $field_prefix = 'bk_section_'.$section_counter;
            for($module_counter=1; $module_counter < $maxCount; $module_counter++) {
                $field_prefix_fw  = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                $field_prefix_rsb = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                bk_delete_section( $_POST['post_ID'], $field_prefix_fw );
                bk_delete_section( $_POST['post_ID'], $field_prefix_rsb );
            }
            bk_delete_section( $_POST['post_ID'], $field_prefix );                    
        }
                
    	if ( isset( $_POST['bk_section_order'] ) && ! empty( $_POST['bk_section_order'] ) ) {
            $section_counter = 1;
            $module_counter = 1;
    		foreach ( $_POST['bk_section_order'] as $id ) {
    			$field_prefix = 'bk_section_'.$section_counter;
                
    			bk_delete_section( $_POST['post_ID'], $field_prefix );
    			update_post_meta( $_POST['post_ID'], $field_prefix, $_POST[ 'bk_sections' ][ $id ]['_type'] );
                if ( isset( $_POST['bk_sidebar_order_'.$section_counter]) ) {
                    $field_prefix = 'bk_sidebar_'.$section_counter;
                    update_post_meta( $_POST['post_ID'], $field_prefix, $_POST['bk_sidebar_order_'.$section_counter] );
                }else{
                    $field_prefix = 'bk_sidebar_'.$section_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                if ( isset( $_POST['bk_sidebarpos_order_'.$section_counter]) ) {
                    $field_prefix = 'bk_sidebarpos_'.$section_counter;
                    update_post_meta( $_POST['post_ID'], $field_prefix, $_POST['bk_sidebarpos_order_'.$section_counter] );
                }else{
                    $field_prefix = 'bk_sidebarpos_'.$section_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }               
                if ( isset( $_POST['bk_fullwidth_module_order_'.$section_counter] ) && ! empty( $_POST['bk_fullwidth_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_fullwidth_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $_POST['post_ID'], $field_prefix );          
                        update_post_meta( $_POST['post_ID'], $field_prefix, $_POST[ 'bk_fullwidth_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_fullwidth_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $_POST['post_ID'], $field_prefix.'_'.$field );
        					if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $_POST[ 'bk_fullwidth_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_fullwidth_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                $module_counter = 1;
                
    // Has right sidebar section
                if ( isset( $_POST['bk_has_rsb_module_order_'.$section_counter] ) && ! empty( $_POST['bk_has_rsb_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_has_rsb_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $_POST['post_ID'], $field_prefix );          
                        update_post_meta( $_POST['post_ID'], $field_prefix, $_POST[ 'bk_has_rsb_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_rsb_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $_POST['post_ID'], $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $_POST[ 'bk_has_rsb_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_rsb_modules' ][ $id ][ $field ]);
                                update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $cat_id);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_123'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                $module_counter = 1;
                
    //bk_leftsec_module_order_[]                
                if ( isset( $_POST['bk_leftsec_module_order_'.$section_counter] ) && ! empty( $_POST['bk_leftsec_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_leftsec_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $_POST['post_ID'], $field_prefix );          
                        update_post_meta( $_POST['post_ID'], $field_prefix, $_POST[ 'bk_has_innersb_left_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_innersb_left_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $_POST['post_ID'], $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $_POST[ 'bk_has_innersb_left_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_innersb_left_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                $module_counter = 1;
    //bk_rsec_module_order_[]                
                if ( isset( $_POST['bk_rsec_module_order_'.$section_counter] ) && ! empty( $_POST['bk_rsec_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_rsec_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $_POST['post_ID'], $field_prefix );          
                        update_post_meta( $_POST['post_ID'], $field_prefix, $_POST[ 'bk_has_innersb_right_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_innersb_right_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $_POST['post_ID'], $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $_POST[ 'bk_has_innersb_right_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_innersb_right_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $_POST['post_ID'], $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $_POST['post_ID'], $field_prefix );
                }
                
    			$section_counter++;	
                $module_counter=1;		
    		}
    	}
    
    	// Delete the next section
    	$field_prefix = 'bk_section_'.$section_counter;
    	bk_delete_section( $_POST['post_ID'], $field_prefix );
        
        die();
    }
}
if ( ! function_exists( 'bk_classic_save_page' ) ) {
	function bk_classic_save_page() {
		global $post;
        $maxCount = 100;
        
        if(!is_admin()) {
            return;
        } 
        
		if ( 'page' != get_post_type( $post ) ) return;

		$section_counter = 1;
        $module_counter = 1;
        
        // Delete all data in page before update the new config
        for($section_counter=1; $section_counter < $maxCount; $section_counter++) {
            $field_prefix = 'bk_section_'.$section_counter;
            for($module_counter=1; $module_counter < $maxCount; $module_counter++) {
                $field_prefix_fw  = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                $field_prefix_rsb = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                bk_delete_section( $post->ID, $field_prefix_fw );
                bk_delete_section( $post->ID, $field_prefix_rsb );
            }
            bk_delete_section( $post->ID, $field_prefix );                    
        }
                
		if ( isset( $_POST['bk_section_order'] ) && ! empty( $_POST['bk_section_order'] ) ) {
            $section_counter = 1;
            $module_counter = 1;
			foreach ( $_POST['bk_section_order'] as $id ) {
				$field_prefix = 'bk_section_'.$section_counter;
                
				bk_delete_section( $post->ID, $field_prefix );
				update_post_meta( $post->ID, $field_prefix, $_POST[ 'bk_sections' ][ $id ]['_type'] );
                if ( isset( $_POST['bk_sidebar_order_'.$section_counter]) ) {
                    $field_prefix = 'bk_sidebar_'.$section_counter;
                    update_post_meta( $post->ID, $field_prefix, $_POST['bk_sidebar_order_'.$section_counter] );
                }else{
                    $field_prefix = 'bk_sidebar_'.$section_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                if ( isset( $_POST['bk_sidebarpos_order_'.$section_counter]) ) {
                    $field_prefix = 'bk_sidebarpos_'.$section_counter;
                    update_post_meta( $post->ID, $field_prefix, $_POST['bk_sidebarpos_order_'.$section_counter] );
                }else{
                    $field_prefix = 'bk_sidebarpos_'.$section_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }               
                if ( isset( $_POST['bk_fullwidth_module_order_'.$section_counter] ) && ! empty( $_POST['bk_fullwidth_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_fullwidth_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $post->ID, $field_prefix );          
                        update_post_meta( $post->ID, $field_prefix, $_POST[ 'bk_fullwidth_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_fullwidth_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $post->ID, $field_prefix.'_'.$field );
        					if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $post->ID, $field_prefix.'_'.$field, $_POST[ 'bk_fullwidth_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_fullwidth_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_fullwidth_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                $module_counter = 1;
                
// Has right sidebar section
                if ( isset( $_POST['bk_has_rsb_module_order_'.$section_counter] ) && ! empty( $_POST['bk_has_rsb_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_has_rsb_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $post->ID, $field_prefix );          
                        update_post_meta( $post->ID, $field_prefix, $_POST[ 'bk_has_rsb_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_rsb_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $post->ID, $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $post->ID, $field_prefix.'_'.$field, $_POST[ 'bk_has_rsb_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_rsb_modules' ][ $id ][ $field ]);
                                update_post_meta( $post->ID, $field_prefix.'_'.$field, $cat_id);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $post->ID, $field_prefix.'_123'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_has_rsb_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                $module_counter = 1;
                
//bk_leftsec_module_order_[]                
                if ( isset( $_POST['bk_leftsec_module_order_'.$section_counter] ) && ! empty( $_POST['bk_leftsec_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_leftsec_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $post->ID, $field_prefix );          
                        update_post_meta( $post->ID, $field_prefix, $_POST[ 'bk_has_innersb_left_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_innersb_left_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $post->ID, $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $post->ID, $field_prefix.'_'.$field, $_POST[ 'bk_has_innersb_left_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_innersb_left_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_leftsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                $module_counter = 1;
//bk_rsec_module_order_[]                
                if ( isset( $_POST['bk_rsec_module_order_'.$section_counter] ) && ! empty( $_POST['bk_rsec_module_order_'.$section_counter] ) ) {
                    foreach ( $_POST['bk_rsec_module_order_'.$section_counter] as $id ) {
                        $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                        bk_delete_section( $post->ID, $field_prefix );          
                        update_post_meta( $post->ID, $field_prefix, $_POST[ 'bk_has_innersb_right_modules' ][ $id ]['_type'] );
                        foreach ( array_keys( $_POST[ 'bk_has_innersb_right_modules' ][ $id ] ) as $field ) {
        					if ( '_type' == $field ) continue;
                            bk_delete_section( $post->ID, $field_prefix.'_'.$field );
                            if(($field != "category") && ($field != "category_1") && ($field != "category_2") && ($field != "category_3") && ($field != "category_4") && ($field != "categorytabs") ){
                                update_post_meta( $post->ID, $field_prefix.'_'.$field, $_POST[ 'bk_has_innersb_right_modules' ][ $id ][ $field ] );
                            }else {
                                $cat_id = implode(",",$_POST[ 'bk_has_innersb_right_modules' ][ $id ][ $field ]);
                                if ($cat_id[0] == 0){
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, 0);
                                }else {
                                    update_post_meta( $post->ID, $field_prefix.'_'.$field, $cat_id);
                                }
                            }
        				}
                        $module_counter++;
                    }
                    // Delete the next section
                    $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                if ($module_counter == 1){
                    $field_prefix = 'bk_rsec_module_'.$section_counter.'_'.$module_counter;
                    bk_delete_section( $post->ID, $field_prefix );
                }
                
				$section_counter++;	
                $module_counter=1;		
			}
		}

		// Delete the next section
		$field_prefix = 'bk_section_'.$section_counter;
		bk_delete_section( $post->ID, $field_prefix );
	}
}