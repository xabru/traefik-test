<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
add_filter( 'rwmb_meta_boxes', 'bk_register_meta_boxes' );
function bk_register_meta_boxes( $meta_boxes ) {
        
    // Better has an underscore as last sign
    
    global $meta_boxes;
    
    $bk_sidebar = array();
    foreach ( $GLOBALS['wp_registered_sidebars'] as $value => $label ) {
        $bk_sidebar[$value] = ucwords( $label['name'] );
    }
    $bk_sidebar['global_settings']  = esc_html__( 'From Theme Options', 'suga' );
    
    // Page Descriptipon
    $meta_boxes[] = array(
        'id'        => 'bk_page_description_section',
        'title'     => esc_html__( 'Page Description', 'suga' ),
        'pages'     => array( 'page' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'hidden'   => array( 'template', 'in', array('page_builder.php')),
    	'fields'    => array( 
            array(
                'name' => esc_html__( 'Page Description', 'suga' ),
                'id' => 'bk_page_description',
                'type' => 'textarea',
                'placeholder' => esc_html__('description ...', 'suga'),
                'std' => ''
            ),
        ),
    );  
    // Page Settings
    $meta_boxes[] = array(
        'id'        => 'bk_page_settings_section',
        'title'     => esc_html__( 'Page Settings', 'suga' ),
        'pages'     => array( 'page' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'hidden'   => array( 'template', 'in', array('blog.php', 'page_builder.php', 'authors-list.php')),
    	'fields'    => array(   
            array(
                'name' => 'Page Heading',
                'id'   => 'bk_page_header_style',
                'type' => 'select',
                'options'   => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                'line'              => esc_html__( 'Heading Line', 'suga' ),
                                'large-line'        => esc_html__( 'Heading Large Line', 'suga' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
        						'large-no-line'     => esc_html__( 'Heading Large No Line', 'suga' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                'large-line-under'  => esc_html__( 'Heading Large Line Under', 'suga' ),
                                'center'            => esc_html__( 'Heading Center', 'suga' ),
                                'large-center'      => esc_html__( 'Heading Large Center', 'suga' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
                                'large-line-around' => esc_html__( 'Heading Large Line Around', 'suga' ),
                            ),
                'std'       => 'global_settings',
            ), 
            // Featured Image Config
            array(
                'name'      => esc_html__( 'Featured Image', 'suga' ),
                'id'        => 'bk_page_feat_img',
                'type'      => 'button_group', 
    			'options'   => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'suga' ),                
                                1 => esc_html__( 'On', 'suga' ),
                                0 => esc_html__( 'Off', 'suga' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'global_settings',
            ),
            // Layout
            array(
                'name' => esc_html__( 'Layout', 'suga' ),
                'id' => 'bk_page_layout',
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'suga' ),
                                'has_sidebar' => esc_html__( 'Has Sidebar', 'suga' ),
                                'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
            ),
            
            // Sidebar
            array(
                'name' => esc_html__( 'Choose a sidebar for this page', 'suga' ),
                'id' => 'bk_page_sidebar_select',
                'type' => 'select',
                'options'  => $bk_sidebar,
                'std'  => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
            array(
                'name' => esc_html__( 'Sidebar Position -- Left/Right', 'suga' ),
                'id' => 'bk_page_sidebar_position',
                'type' => 'image_select',
                'options'   => array(
                        'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                        'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                        'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                ),
                'std'  => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
            array(
                'name'      => esc_html__( 'Sticky Sidebar', 'suga' ),
                'id'        => 'bk_page_sidebar_sticky',
                'type'      => 'button_group',
                'options'   => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Enable', 'suga' ),
            					0                   => esc_html__( 'Disable', 'suga' ),
                            ),
                'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Default Page Template','suga'),
                'std'       => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
        )
    );
    // Post Layout Options
    $meta_boxes[] = array(
        'id' => 'bk_post_ops',
        'title' => esc_html__( 'BK Layout Options', 'suga' ),
        'desc'   =>  esc_html__( 'From Theme Option: Theme Options -> Single Page', 'suga' ),        
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
    
        'fields' => array(
            array(
    			'id' => 'bk_post_layout_standard',
                'class' => 'post-layout-options',
                'name' => esc_html__( 'Post Layout Option', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings' => get_template_directory_uri().'/images/admin_panel/default.png',
                                'single-1' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                                'single-2' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                                'single-3' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                                'single-4' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                                'single-5' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                                'single-6' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                                'single-7' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                                'single-8' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                                'single-9' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                                'single-10' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                                'single-11' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                                'single-12' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                                'single-13' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                                'single-14' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                                'single-15' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                                'single-16' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                                'single-18' => get_template_directory_uri().'/images/admin_panel/single_page/single_suga_17.png',
        				    ),
                'std'         => 'global_settings',
            ),
            
            array(
                'type' => 'divider',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                           'single-5', 'single-6', 'single-9', 'single-10')),
                        ),
            ),
            // Feature Image Config
            array(
                'name' => esc_html__( 'Featured Image Config', 'suga' ),
                'id' => 'bk-feat-img-status',
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'suga' ),                
                                1 => esc_html__( 'On', 'suga' ),
                                0 => esc_html__( 'Off', 'suga' ),
        				    ),
    			'std'         => 'global_settings',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                           'single-5', 'single-6', 'single-9', 'single-10')),
                        ),
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'bk_section_show_hide',
        'title' => esc_html__( 'BK Single Post Section Show/Hide', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'fields' => array(
            array(
    			'id' => 'bk-authorbox-sw',
                'class' => 'bk-authorbox-sw',
                'name' => esc_html__( 'Author Box', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Show', 'suga' ),
            					0                   => esc_html__( 'Hide', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-postnav-sw',
                'class' => 'bk-postnav-sw',
                'name' => esc_html__( 'Post Nav Section', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Show', 'suga' ),
            					0                   => esc_html__( 'Hide', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-related-sw',
                'class' => 'bk-related-sw',
                'name' => esc_html__( 'Related Section', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Show', 'suga' ),
            					0                   => esc_html__( 'Hide', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-same-cat-sw',
                'class' => 'bk-same-cat-sw',
                'name' => esc_html__( 'Same Category Section', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Show', 'suga' ),
            					0                   => esc_html__( 'Hide', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        ),
    );
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_related_post_ops',
        'title' => esc_html__( 'BK Related Post Setting', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'hidden' => array(
                        'when' => array(
                             array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-related-sw', 0 )
                         ),
                         'relation' => 'or'
                    ),
        'fields' => array(
            array(
    			'id' => 'bk_related_heading_style',
                'class' => 'related_heading_style',
                'name' => esc_html__( 'Heading Style', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'suga' ),
                                'line'              => esc_html__( 'Heading Line', 'suga' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                'center'            => esc_html__( 'Heading Center', 'suga' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_source',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Related Posts', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'suga' ),
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'suga' ),
            					'tag'          => esc_html__( 'Same Tags', 'suga' ),
                                'category'     => esc_html__( 'Same Categories', 'suga' ),
                                'author'       => esc_html__( 'Same Author', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_number_related',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Number of Related Posts', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                '1'                 => esc_html__( '1', 'suga' ),
            					'2'                 => esc_html__( '2', 'suga' ),
                                '3'                 => esc_html__( '3', 'suga' ),
                                '4'                 => esc_html__( '4', 'suga' ),
                                '5'                 => esc_html__( '5', 'suga' ),
            					'6'                 => esc_html__( '6', 'suga' ),
                                '7'                 => esc_html__( '7', 'suga' ),
                                '8'                 => esc_html__( '8', 'suga' ),
                                '9'                 => esc_html__( '9', 'suga' ),
            					'10'                => esc_html__( '10', 'suga' ),
                                '11'                => esc_html__( '11', 'suga' ),
                                '12'                => esc_html__( '12', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_layout',
                'class' => 'related_post_layout',
                'name' => esc_html__( 'Layout', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                'listing_list_c'       => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_icon',
                'class' => 'related_post_icon',
                'name' => esc_html__( 'Post Icon', 'suga' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
            					'disable'           => esc_html__( 'Disable', 'suga' ),
		                        'enable'            => esc_html__( 'Enable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_related_post_ops_wide',
        'title' => esc_html__( 'BK Related Post Section - Wide Setting', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                         array( 'bk-related-sw', '!=', 0 )
                    ),
        'fields' => array(
            array(
    			'id' => 'bk_related_heading_style_wide',
                'class' => 'related_heading_style',
                'name' => esc_html__( 'Heading Style', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'suga' ),
                                'line'              => esc_html__( 'Heading Line', 'suga' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                'center'            => esc_html__( 'Heading Center', 'suga' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_source_wide',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Related Posts', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'suga' ),
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'suga' ),
            					'tag'          => esc_html__( 'Same Tags', 'suga' ),
                                'category'     => esc_html__( 'Same Categories', 'suga' ),
                                'author'       => esc_html__( 'Same Author', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_layout_wide',
                'class' => 'related_post_layout',
                'name' => esc_html__( 'Layout', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_c.png',
                                'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
                                'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_icon_wide',
                'class' => 'related_post_icon',
                'name' => esc_html__( 'Post Icon', 'suga' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
            					'disable'           => esc_html__( 'Disable', 'suga' ),
		                        'enable'            => esc_html__( 'Enable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );  
    // Same Category Posts Options
    $allCategories = get_categories();
    $catArray = array();
    $catArray['current_cat'] = esc_html__('Current Category', 'suga');
    foreach ( $allCategories as $key => $category ) {
        $catArray[$category->term_id] = $category->name;
    }
    $meta_boxes[] = array(
        'id' => 'bk_same_cat_post_ops',
        'title' => esc_html__( 'BK Same Category Posts Setting', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'hidden' => array(
                        'when' => array(
                             array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-same-cat-sw', 0 )
                         ),
                         'relation' => 'or'
                    ),
        'fields' => array(
            array(
    			'id'         => 'bk_same_cat_id',
                'class'      => 'same_cat_id',
                'name'       => esc_html__( 'Category: ', 'suga' ),
                'type'       => 'select', 
    			'options'    => $catArray,
    			'multiple'   => false,
    			'std'        => 'current_cat',
    		),
            array(
    			'id' => 'bk_same_cat_heading_style',
                'class' => 'same_cat_heading_style',
                'name' => esc_html__( 'Heading Style', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'suga' ),
                                'line'              => esc_html__( 'Heading Line', 'suga' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                'center'            => esc_html__( 'Heading Center', 'suga' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_layout',
                'class' => 'same_cat_post_layout',
                'name' => esc_html__( 'Layout', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                'listing_list_c'       => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_number_posts',
                'class' => 'same_cat_number_posts',
                'name' => esc_html__( 'Number of Posts', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                '1'                 => esc_html__( '1', 'suga' ),
            					'2'                 => esc_html__( '2', 'suga' ),
                                '3'                 => esc_html__( '3', 'suga' ),
                                '4'                 => esc_html__( '4', 'suga' ),
                                '5'                 => esc_html__( '5', 'suga' ),
            					'6'                 => esc_html__( '6', 'suga' ),
                                '7'                 => esc_html__( '7', 'suga' ),
                                '8'                 => esc_html__( '8', 'suga' ),
                                '9'                 => esc_html__( '9', 'suga' ),
            					'10'                => esc_html__( '10', 'suga' ),
                                '11'                => esc_html__( '11', 'suga' ),
                                '12'                => esc_html__( '12', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_icon',
                'class' => 'same_cat_post_icon',
                'name' => esc_html__( 'Post Icon', 'suga' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
            					'disable'           => esc_html__( 'Disable', 'suga' ),
		                        'enable'            => esc_html__( 'Enable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_more_link',
                'class' => 'same_cat_more_link',
                'name' => esc_html__( 'More Link', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Enable', 'suga' ),
            					0                   => esc_html__( 'Disable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_same_cat_post_ops_wide',
        'title' => esc_html__( 'BK Same Category Post Section - Wide Setting', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                         array( 'bk-same-cat-sw', '!=', 0 )
                    ),
        'fields' => array(
            array(
    			'id'         => 'bk_same_cat_id_wide',
                'class'      => 'same_cat_id_wide',
                'name'       => esc_html__( 'Category: ', 'suga' ),
                'type'       => 'select', 
    			'options'    => $catArray,
    			'multiple'   => false,
    			'std'        => 'disable',
    		),
            array(
    			'id' => 'bk_same_cat_heading_style_wide',
                'class' => 'same_cat_heading_style',
                'name' => esc_html__( 'Heading Style', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'suga' ),
                                'line'              => esc_html__( 'Heading Line', 'suga' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                'center'            => esc_html__( 'Heading Center', 'suga' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_layout_wide',
                'class' => 'same_cat_post_layout_wide',
                'name' => esc_html__( 'Layout', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_c.png',
                                'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
                                'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_icon_wide',
                'class' => 'same_cat_post_icon_wide',
                'name' => esc_html__( 'Post Icon', 'suga' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
            					'disable'           => esc_html__( 'Disable', 'suga' ),
		                        'enable'            => esc_html__( 'Enable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_more_link_wide',
                'class' => 'same_cat_more_link_wide',
                'name' => esc_html__( 'More Link', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Enable', 'suga' ),
            					0                   => esc_html__( 'Disable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );  
    $meta_boxes[] = array(
        'id' => 'bk_single_post_sidebar',
        'title' => esc_html__( 'Sidebar Option', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
    
        'fields' => array(
            // Sidebar Select
            array(
                'name' => esc_html__( 'Choose a sidebar for this post', 'suga' ),
                'id' => 'bk_post_sb_select',
                'type' => 'select',
                'options'  => $bk_sidebar,
                'desc' => esc_html__( 'Sidebar Select', 'suga' ),
                'std'  => 'global_settings',
            ),
            array(
    			'id' => 'bk_post_sb_position',
                'class' => 'post_sb_position',
                'name' => esc_html__( 'Sidebar Position', 'suga' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'   => get_template_directory_uri().'/images/admin_panel/default.png',
                                'right'             => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
            					'left'              => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_post_sb_sticky',
                'class' => 'post_sb_sticky',
                'name' => esc_html__( 'Sidebar Sticky', 'suga' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                1                   => esc_html__( 'Enable', 'suga' ),
            					0                   => esc_html__( 'Disable', 'suga' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    
    $meta_boxes[] = array(
        'id' => 'bk_video_post_format',
        'title' => esc_html__( 'BK Video Post Format', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'visible' => array( 'post_format', 'in', array('video')),
    	'fields' => array(        
            //Video
            array(
                'name' => esc_html__( 'Format Options: Video', 'suga' ),
                'desc' => esc_html__('Support Youtube, Vimeo Link', 'suga'),
                'id' => 'bk_video_media_link',
                'type'  => 'oembed',
                'placeholder' => esc_html__('Link ...', 'suga'),
                'std' => ''
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'bk_gallery_post_format',
        'title' => esc_html__( 'BK Gallery Post Format', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'visible' => array( 'post_format', 'in', array('gallery')),
    	'fields' => array(  
            //Gallery
            array(
                'name' => esc_html__( 'Format Options: Gallery', 'suga' ),
                'desc' => esc_html__('Gallery Images', 'suga'),
                'id' => 'bk_gallery_content',
                'type' => 'image_advanced',
                'std' => ''
            ),
            array(
    			'id' => 'bk_gallery_type',
                'name' => esc_html__( 'Gallery Type', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
            					'gallery-1' => esc_html__( 'Gallery 1', 'suga' ),
            					'gallery-2' => esc_html__( 'Gallery 2 ', 'suga' ),
                                'gallery-3' => esc_html__( 'Gallery 3', 'suga' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'left',
    		),
        )
    );
    // Post Review Options
    $meta_boxes[] = array(
        'id' => 'bk_review',
        'title' => esc_html__( 'BK Review System', 'suga' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
    
        'fields' => array(
            // Enable Review
            array(
                'name' => esc_html__( 'Review Box', 'suga' ),
                'id' => 'bk_review_checkbox',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Enable Review On This Post', 'suga' ),
                'std'  => 0,
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            array(
    			'id' => 'bk_review_box_position',
                'name' => esc_html__( 'Review Box Position', 'suga' ),
                'type' => 'select', 
    			'options'  => array(
            					'default'      => esc_html__( 'Default -- Under the post content', 'suga' ),
            					'aside-left'   => esc_html__( 'Aside Left ', 'suga' ),
                                'aside-right'  => esc_html__( 'Aside Right', 'suga' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'default',
                'visible'     => array( 'bk_review_checkbox', '=', 1),
    		),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => 'Product Image',
                'id'   => 'bk_review_product_img',
                'type' => 'single_image',
                'visible'     => array( 'bk_review_checkbox', '=', 1),
            ),  
            array(
                'name' => esc_html__( 'Product name', 'suga' ),
                'id'   => 'bk_review_box_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Description', 'suga' ),
                'id'   => 'bk_review_box_sub_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            //Review Score
            array(
                'name' => esc_html__( 'Review Score', 'suga' ),
                'id' => 'bk_review_score',
                'class' => 'suga-',
                'type' => 'slider',
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'js_options' => array(
                    'min'   => 0,
                    'max'   => 10.05,
                    'step'  => .1,
                ),
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            // Summary
            array(
                'name' => esc_html__( 'Summary', 'suga' ),
                'id'   => 'bk_review_summary',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 4,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            
            //Pros & Cons
            array(
                'name' => esc_html__( 'Pros and Cons', 'suga' ),
                'id' => 'bk_pros_cons',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Enable Pros and Cons On This Post', 'suga' ),
                'std'  => 0,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'visible' => array( 'bk_pros_cons', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => esc_html__( 'Pros Title', 'suga' ),
                'id'   => 'bk_review_pros_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Pros (Advantages)', 'suga' ),
                'id'   => 'bk_review_pros',
                'type' => 'textarea',
                'cols' => 20,
                'clone' => true,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'visible' => array( 'bk_pros_cons', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => esc_html__( 'Cons Title', 'suga' ),
                'id'   => 'bk_review_cons_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Cons (Disadvantages)', 'suga' ),
                'id'   => 'bk_review_cons',
                'type' => 'textarea',
                'cols' => 20,
                'clone' => true,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
        )
    );
    if ( function_exists( 'mb_term_meta_load' ) ) {
        $meta_boxes[] = array(
            'title'      => 'Advance Category Options',
            'taxonomies' => array('category'), // List of taxonomies. Array or string
    
            'fields' => array(
                array(
        			'id' => 'bk_category_feature_area',
                    'class' => 'bk_archive_feature_area',
                    'name' => esc_html__( 'Feature Area', 'suga' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'disable'            => get_template_directory_uri().'/images/admin_panel/disable.png',
                                    'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                    'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_c.png',
                                    'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
        		),
                array(
                    'name' => 'Feature Area Post Option',
                    'id'   => 'bk_category_feature_area__post_option',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    'featured'          => esc_html__( 'Show Featured Posts', 'suga' ),
        			                'latest'            => esc_html__( 'Show Latest Posts', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                ), 
                array(
                    'name' => 'Show Feature Area only on 1st page',
                    'id'   => 'bk_feature_area__show_hide',
                    'type' => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    1                   => esc_html__( 'Yes', 'suga' ),
        			                0                   => esc_html__( 'No', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                ), 
                array(
                    'name' => 'Page Heading',
                    'id'   => 'bk_category_header_style',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    'line'              => esc_html__( 'Heading Line', 'suga' ),
                                    'large-line'        => esc_html__( 'Heading Large Line', 'suga' ),
                                    'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
            						'large-no-line'     => esc_html__( 'Heading Large No Line', 'suga' ),
                                    'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                    'large-line-under'  => esc_html__( 'Heading Large Line Under', 'suga' ),
                                    'center'            => esc_html__( 'Heading Center', 'suga' ),
                                    'large-center'      => esc_html__( 'Heading Large Center', 'suga' ),
                                    'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
                                    'large-line-around' => esc_html__( 'Heading Large Line Around', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                ), 
                array(
                    'name' => 'Heading Color',
                    'id'   => 'bk_category_heading__color',
                    'type' => 'color',
                ),
                array(
    				'name'    => esc_html__('Content Layouts','suga'),
    				'id'      => 'bk_category_content_layout',
    				'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                    'listing_list_c'       => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                    'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                    'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
                					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                    'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_10.png',
                                    'listing_list_b_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_11.png',
                                    'listing_list_alt_a_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_12.png',
                                    'listing_list_alt_b_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_13.png',
                                
            				    ),
                    'std' => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
    			),
                array(
                    'name' => 'Pagination',
                    'id'   => 'bk_category_pagination',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    'default'           => esc_html__( 'Default Pagination', 'suga' ),
        			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                ), 
                array(
                    'name' => '[Content Section] Exclude Posts',
                    'id'   => 'bk_category_exclude_posts',
                    'type'     => 'button_group',
                    'hidden'    => array( 'bk_category_feature_area', 'in', array('disable')),
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    1                   => esc_html__( 'Enable', 'suga' ),
                                    0                   => esc_html__( 'Disable', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('Content Section: Exclude Featured Posts that are shown on the Feature Area','suga')
                ),
                array(
                    'name' => esc_html__( 'Choose a sidebar for this page', 'suga' ),
                    'id' => 'bk_category_sidebar_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => esc_html__( 'Sidebar Position -- Left/Right', 'suga' ),
                    'id' => 'bk_category_sidebar_position',
                    'type' => 'image_select',
                    'options'   => array(
                            'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                            'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                            'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                    ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name'      => esc_html__( 'Sticky Sidebar', 'suga' ),
                    'id'        => 'bk_category_sidebar_sticky',
                    'type'      => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    1                   => esc_html__( 'Enable', 'suga' ),
                					0                   => esc_html__( 'Disable', 'suga' ),
                                ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                    'std'       => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => 'Category Color',
                    'id'   => 'bk_category__color',
                    'type' => 'color',
                ),   
                array(
                    'name' => 'Featured Image',
                    'id'   => 'bk_category_feat_img',
                    'type' => 'single_image',
                ),  
            ),
        );
        $meta_boxes[] = array(
            'title'      => ' ',
            'taxonomies' => array('post_tag'), // List of taxonomies. Array or string
    
            'fields' => array(
                array(
                    'name' => 'Page Heading',
                    'id'   => 'bk_archive_header_style',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    'line'              => esc_html__( 'Heading Line', 'suga' ),
                                    'large-line'        => esc_html__( 'Heading Large Line', 'suga' ),
                                    'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
            						'large-no-line'     => esc_html__( 'Heading Large No Line', 'suga' ),
                                    'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                    'large-line-under'  => esc_html__( 'Heading Large Line Under', 'suga' ),
                                    'center'            => esc_html__( 'Heading Center', 'suga' ),
                                    'large-center'      => esc_html__( 'Heading Large Center', 'suga' ),
                                    'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
                                    'large-line-around' => esc_html__( 'Heading Large Line Around', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
                ), 
                array(
                    'name' => 'Heading Color',
                    'id'   => 'bk_archive_heading__color',
                    'type' => 'color',
                ),
                array(
    				'name'    => esc_html__('Content Layouts','suga'),
    				'id'      => 'bk_archive_content_layout',
    				'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                    'listing_list_b'       => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                    'listing_list_c'       => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                    'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                    'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
                					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                    'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_10.png',
                                    'listing_list_b_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_11.png',
                                    'listing_list_alt_a_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_12.png',
                                    'listing_list_alt_b_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_13.png',
            				    ),
                    'std' => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
    			),
                array(
                    'name' => 'Pagination',
                    'id'   => 'bk_archive_pagination',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    'default'           => esc_html__( 'Default Pagination', 'suga' ),
        			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','suga'),
                ), 
                array(
                    'name' => esc_html__( 'Choose a sidebar for this page', 'suga' ),
                    'id' => 'bk_archive_sidebar_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => esc_html__( 'Sidebar Position -- Left/Right', 'suga' ),
                    'id' => 'bk_archive_sidebar_position',
                    'type' => 'image_select',
                    'options'   => array(
                            'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                            'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                            'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                    ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name'      => esc_html__( 'Sticky Sidebar', 'suga' ),
                    'id'        => 'bk_archive_sidebar_sticky',
                    'type'      => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'suga' ),
                                    1                   => esc_html__( 'Enable', 'suga' ),
                					0                   => esc_html__( 'Disable', 'suga' ),
                                ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','suga'),
                    'std'       => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_b','listing_list_c', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b','listing_grid','listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => 'Featured Image',
                    'id'   => 'bk_archive_feat_img',
                    'type' => 'single_image',
                ),  
            ),
        );
    }
    return $meta_boxes;
}