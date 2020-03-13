<?php

/**
	ReduxFramework Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_config" ) ) {
	class Redux_Framework_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

			add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );

		}


		/**

			This is a test function that will let you see when the compiler hook occurs. 
			It only runs if a field	set with compiler=>true is changed.

		**/

		function compiler_action($options, $css) {

		}

		/**
		 
		 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 	Simply include this function in the child themes functions.php file.
		 
		 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 	so you must use get_template_directory_uri() if you want to use any of the built in icons
		 
		 **/

		function dynamic_section($sections){
		    return $sections;
		}
		
		
		/**

			Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		**/
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		}


		public function setSections() {

			/**
			 	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 **/


			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns      = array();

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name'); 
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;','suga' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
					<a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
						<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'suga' ); ?>" />
					</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'suga' ); ?>" />
				<?php endif; ?>

				<h4>
					<?php echo esc_attr($this->theme->display('Name')); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( esc_html__('By %s','suga'), $this->theme->display('Author') ); ?></li>
						<li><?php printf( esc_html__('Version %s','suga'), $this->theme->display('Version') ); ?></li>
						<li><?php echo '<strong>'.__('Tags', 'suga').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_attr($this->theme->display('Description')); ?></p>
					<?php if ( $this->theme->parent() ) {
						printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'suga' ) . '</p>',
							__( 'http://codex.wordpress.org/Child_Themes','suga' ),
							$this->theme->parent()->display( 'Name' ) );
					} ?>
					
				</div>

			</div>

			<?php
			$item_info = ob_get_contents();
			    
			ob_end_clean();

			$sampleHTML = '';

            /*
             * ---> CSS selectors outputs
             */

            $primary_color_output_bg = '';
            $primary_color_output = '';

            // Primary color background.
            $primary_color_output_bg .= '.primary-color-bg, .btn[class*="st-btn-"]:before, input[type="submit"][type="submit"]:hover, .st-btn-solid-primary, a.btn.st-btn-solid-primary';

            // Primary color.
            $primary_color_output .= 'a, a:visited, a:hover, a:focus, a:active, .primary-color, .bypostauthor .comment-author .fn, .st-btn-primary, .st-btn-primary:hover, .st-btn-primary:focus, .st-btn-primary:active, input[type="submit"][type="submit"], .st-btn-outline-primary, a.btn.st-btn-outline-primary';

            $primary_font = array('.post__title, .entry-title, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .text-font-primary, .social-tile__title, .widget_recent_comments .recentcomments > a, .widget_recent_entries li > a, .modal-title.modal-title, .author-box .author-name a, .comment-author, .widget_calendar caption, .widget_categories li>a, .widget_meta ul, .widget_recent_comments .recentcomments>a, .widget_recent_entries li>a, .widget_pages li>a,
            .widget__title-text');

            $secondary_font = array('.text-font-secondary, .block-heading__subtitle, .widget_nav_menu ul, .typography-copy blockquote, .comment-content blockquote');

            $tertiary_font = array('.mobile-header-btn, .meta-text, a.meta-text, .meta-font, a.meta-font, .text-font-tertiary, .block-heading, .block-heading__title, .block-heading-tabs, .block-heading-tabs > li > a, input[type="button"]:not(.btn), input[type="reset"]:not(.btn), input[type="submit"]:not(.btn), .btn, label, .category-tile__name, .page-nav, .post-score, .post-score-hexagon .post-score-value, .post__cat, a.post__cat, .entry-cat, a.entry-cat, .read-more-link, .post__meta, .entry-meta, .entry-author__name, a.entry-author__name, .comments-count-box, .atbssuga-widget-indexed-posts-a .posts-list > li .post__thumb:after, .atbssuga-widget-indexed-posts-b .posts-list > li .post__title:after, .atbssuga-widget-indexed-posts-c .list-index, .social-tile__count, .widget_recent_comments .comment-author-link, .atbssuga-video-box__playlist .is-playing .post__thumb:after, .atbssuga-posts-listing-a .cat-title, .atbssuga-news-ticker__heading, .page-heading__title, .post-sharing__title, .post-sharing--simple .sharing-btn, .entry-action-btn, .entry-tags-title, .post-categories__title, .posts-navigation__label, .comments-title, .comments-title__text, .comments-title .add-comment, .comment-metadata, .comment-metadata a, .comment-reply-link, .comment-reply-title, .countdown__digit, .modal-title, .comment-reply-title, .comment-meta, .comment .reply, .wp-caption, .gallery-caption, .widget-title, .btn, .logged-in-as, .countdown__digit, .atbssuga-widget-indexed-posts-a .posts-list>li .post__thumb:after, .atbssuga-widget-indexed-posts-b .posts-list>li .post__title:after, .atbssuga-widget-indexed-posts-c .list-index, .atbssuga-horizontal-list .index, .atbssuga-pagination, .atbssuga-pagination--next-n-prev .atbssuga-pagination__label');
            
            $nav_font = array('.navigation--main>li>a, .navigation .sub-menu, .navigation-bar-btn, .navigation, .menu, .atbssuga-mega-menu__inner > .sub-menu > li > a, .navigation');
            /*
             * ---> END CSS selectors outputs
             */

            
			// ACTUAL DECLARATION OF SECTIONS
            
                $this->sections[] = array(
    				'icon' => 'el-icon-wrench',
    				'title' => esc_html__('General Settings', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk-primary-color',
    						'type' => 'color',
    						'title' => esc_html__('Primary color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the theme.', 'suga'),
    						'default' => '#EF3A2B',
                            'transparent' => false,
    						'validate' => 'color',
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-font',
    				'title' => esc_html__('Typography', 'suga'),
                    'desc'  => esc_html__( 'It is recommended to use maximum 3 different font families for the sake of design consistency and load speed.', 'suga' ),
    				'fields' => array(
                        array(
                            'id'          => 'body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Body text', 'suga' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            'preview'       => true, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => 'body',
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for body text.', 'suga' ),
                            'default'     => array(
                                'font-family' => 'Lato',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'heading-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Heading', 'suga' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            'preview'       => true, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $primary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for title and heading.', 'suga' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'meta-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Secondary', 'suga' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            //'preview'       => false, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $secondary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for secondary text such as subtitle, sub menu, ...', 'suga' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'tertiary-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Tertiary font', 'suga' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'text-align'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'word-spacing'  => false,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            //'preview'       => false, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $tertiary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for tertiary text such as post meta, button, ...', 'suga' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'navigation-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Navigation', 'suga' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => true,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            'preview'       => true, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $nav_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for title and heading.', 'suga' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'=>'section-text-button-start',
                            'title' => esc_html__('Text Button', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'      =>'bk-load-more-text',
    						'type'    => 'text',
    						'title'   => esc_html__('Load More Text', 'suga'),
                            'default' => esc_html__('Load more news', 'suga'),
						),
                        array(
    						'id'      =>'bk-no-more-text',
    						'type'    => 'text',
    						'title'   => esc_html__('No More Text', 'suga'),
                            'default' => esc_html__('No more news', 'suga'),
						),
                        array(
                            'id'=>'section-text-button-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-wrench',
    				'title' => esc_html__('Module Heading Style', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk-default-module-heading',
    						'type' => 'select',
    						'title' => esc_html__('Default Module Heading', 'suga'), 
    						'subtitle' => esc_html__('Default setting of all module heading style.', 'suga'),
    						'options'   => array(
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
                            'default'    => 'line',
						),
                        array(
    						'id'=>'bk-module-heading-color',
    						'type' => 'color',
    						'title' => esc_html__('Module Heading Text Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a color for the heading.', 'suga'),
    						'default' => '#222',
                            'output' => '.block-heading .block-heading__title',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk-default-widget-heading',
    						'type' => 'select',
    						'title' => esc_html__('Default Widget Heading', 'suga'), 
    						'subtitle' => esc_html__('Default setting of all widget heading style.', 'suga'),
                            'options'   => array(
                                            'line'              => esc_html__( 'Heading Line', 'suga' ),
                                            'no-line'           => esc_html__( 'Heading No Line', 'suga' ),
                                            'line-under'        => esc_html__( 'Heading Line Under', 'suga' ),
                                            'center'            => esc_html__( 'Heading Center', 'suga' ),
                                            'line-around'       => esc_html__( 'Heading Line Around', 'suga' ),
                    				    ),
                			'default'    => 'line',
						),
                        array(
    						'id'=>'bk-widget-heading-color',
    						'type' => 'color',
                            'output' => '.widget__title .widget__title-text',
    						'title' => esc_html__('Widget Heading Text Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a color for the heading.', 'suga'),
    						'default' => '#333',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk-footer-widget-heading-color',
    						'type' => 'color',
                            'output' => '.site-footer .widget__title .widget__title-text',
    						'title' => esc_html__('Footer Widget Heading Text Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a color for the heading.', 'suga'),
    						'default' => '#333',
                            'transparent' => false,
    						'validate' => 'color',
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-photo',
    				'title' => esc_html__('Header', 'suga'),
    				'fields' => array(
    					array(
    						'id'=>'bk-header-type',
    						'title' => esc_html__('Header Type', 'suga'),
    						'subtitle' => esc_html__('Choose a Header Type', 'suga'),
                            'type' => 'image_select', 
                            'options'  => array(
                                'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/1.png',
                                'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/2.png',
                                'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/3.png',
                                'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/4.png',
            					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/5.png',
                                'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/6.png',
                                'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/7.png',
                                'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/8.png',
                                'site-header-10' => get_template_directory_uri().'/images/admin_panel/header/9.png',
                            ),
                            'default' => 'site-header-1',
						),
                        array(
    						'id'=>'bk-header-bg-style',                            
    						'type' => 'select',
    						'title' => esc_html__('Header Background Style', 'suga'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'suga' ),
				                'image'      => esc_html__( 'Background Image', 'suga' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'suga' ),
                                'color'      => esc_html__( 'Background Color', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-image',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'image' )),
                            ),
    						'type' => 'background',
    						'output' => array('.site-header .background-img, .header-4 .navigation-bar, .header-5 .navigation-bar, .header-6 .navigation-bar, .header-10 .navigation-bar'),
    						'title' => esc_html__('Header Background Image', 'suga'), 
    						'subtitle' => esc_html__('Choose background image for the site header', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'transparent' => false,
                            'background-color' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-gradient',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Header Background Gradient', 'suga'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-gradient-direction',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'suga'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-header-bg-color',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Header Background Color', 'suga'), 
    						'subtitle' => esc_html__('Choose background color for the site header', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
                            'id'             =>'bk-header-spacing',
                            'type'           => 'spacing',
                            'output'         => array('.header-main'),
                            'required'  => array (
                                'bk-header-type','equals',array( 'site-header-1', 'site-header-2', 'site-header-3', 'site-header-7', 'site-header-8', 'site-header-9' )
                            ),
                            'mode'           => 'padding',
                            'left'           => 'false',
                            'right'          => 'false',
                            'units'          => array('px'),
                            'units_extended' => 'false',
                            'title'          => esc_html__('Header Padding', 'suga'),
                            'default'            => array(
                                'padding-top'     => '40px', 
                                'padding-bottom'  => '40px', 
                                'units'          => 'px', 
                            )
                        ),
                        array(
    						'id'=>'bk-header-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Header Text', 'suga'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'suga' ),
                                    1   => esc_html__( 'White', 'suga' ),
                            ),
						),
                        array(
                            'id' => 'section-sticky-menu-start',
                            'title' => esc_html__('Sticky Menu', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-sticky-menu-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Sticky Menu', 'suga'),
    						'subtitle' => esc_html__('Enable / Disable Sticky Menu Function', 'suga'),
    						'default'   => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-sticky-header-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Sticky Header Logo', 'suga'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in sticky headeer', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-style',
                            'required' => array(
                                'bk-sticky-menu-switch','equals', 1
                            ),
    						'type' => 'select',
    						'title' => esc_html__('Sticky Menu Background Style', 'suga'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'suga' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'suga' ),
                                'color'      => esc_html__( 'Background Color', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-gradient',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'suga'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-gradient-direction',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'suga'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-color',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'suga'), 
    						'subtitle' => esc_html__('Choose background color for the sticky menu', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Sticky Menu Text', 'suga'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'suga' ),
                                    1   => esc_html__( 'White', 'suga' ),
                            ),
						),
                        array(
                            'id' => 'section-sticky-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-mobile-menu-start',
                            'title' => esc_html__('Mobile Menu', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-mobile-menu-bg-style',
    						'type' => 'select',
    						'title' => esc_html__('Mobile Menu Background Style', 'suga'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'suga' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'suga' ),
                                'color'      => esc_html__( 'Background Color', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-gradient',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'suga'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-gradient-direction',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'suga'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-color',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'suga'), 
    						'subtitle' => esc_html__('Choose background color for the mobile menu', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Mobile Menu Text', 'suga'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'suga' ),
                                    1   => esc_html__( 'White', 'suga' ),
                            ),
						),
                        array(
                            'id' => 'section-mobile-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-site-branding-start',
                            'title' => esc_html__('Site Branding', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Site Logo', 'suga'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in header', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
    						'id'=>'bk-site-logo-size-option',
    						'type' => 'select',
                            'required'  => array (
                                'bk-header-type','equals',array( 'site-header-1', 'site-header-2', 'site-header-3', 'site-header-7', 'site-header-8', 'site-header-9', 'site-header-10' )
                            ),
    						'title' => esc_html__('Site Logo Size Option ', 'suga'),
    						'subtitle' => esc_html__('Select between Original Logo Image Size or Customize the Logo Size', 'suga'),
    						'default' => 'original',
                            'options'   => array(
				                'original'      => esc_html__( 'Original Logo Image Size', 'suga' ),
                                'customize'     => esc_html__( 'Customize the Logo Size', 'suga' ),
                            ),
						),
                        array(
                            'id' => 'site-logo-width',
                            'type' => 'slider',
                            'required' => array(
                                'bk-site-logo-size-option', 'equals' , array( 'customize' )
                            ),
                            'title' => esc_html__('Site Logo Width (px)', 'suga'),
                            'default' => 300,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
    						'id'=>'bk-mobile-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Mobile Logo', 'suga'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in mobile header', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
                            'id' => 'section-site-branding-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-offcanvas-desktop-menu-start',
                            'title' => esc_html__('Off-Canvas Menu - Desktop', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-offcanvas-desktop-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Off-Canvas Switch ', 'suga'),
    						'subtitle' => esc_html__('Enable/Disable the Offcanvas Menu', 'suga'),
    						'default' => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
						),	
                        array(
    						'id'=>'bk-offcanvas-desktop-menu',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
    						'type' => 'select',
                            'data' => 'menu_location',
    						'title' => esc_html__('Select a Menu', 'suga'),
    						'default' => 'offcanvas-menu',
						),
                        array(
    						'id'=>'bk-offcanvas-desktop-logo',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Off-Canvas Logo', 'suga'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
    						'id'       =>'bk-offcanvas-desktop-social',
    						'type'     => 'select',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
                            'multi'    => true,
    						'title' => esc_html__('Off-Canvas Social Media', 'suga'),
    						'subtitle' => esc_html__('Set up social items for site', 'suga'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
						),
                        array(
    						'id'=>'bk-offcanvas-desktop-mailchimp-shortcode',
                            'required' => array( 
                                array('bk-offcanvas-desktop-subscribe-switch','equals',1), 
                                array('bk-offcanvas-desktop-switch','=',1),
                            ),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'suga'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'suga'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-offcanvas-desktop-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-offcanvas-mobile-menu-start',
                            'title' => esc_html__('Off-canvas Menu - Mobile', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-offcanvas-mobile-menu',
    						'type' => 'select',
                            'data' => 'menu_location',
    						'title' => esc_html__('Select a Menu', 'suga'),
    						'default' => 'main-menu',
						),	
                        array(
    						'id'=>'bk-offcanvas-mobile-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Off-Canvas Logo', 'suga'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
    						'id'       =>'bk-offcanvas-mobile-social',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Off-Canvas Social Media', 'suga'),
    						'subtitle' => esc_html__('Set up social links for site', 'suga'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
						),
                        array(
    						'id'=>'bk-offcanvas-mobile-mailchimp-shortcode',
                            'required' => array( 
                                array('bk-offcanvas-mobile-subscribe-switch','equals',1), 
                            ),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'suga'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'suga'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-offcanvas-mobile-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),                                                              
                        array(
                            'id' => 'section-social-header-start',
                            'title' => esc_html__('Header Social Items', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'       =>'bk-social-header',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Social Media', 'suga'),
    						'subtitle' => esc_html__('Select social items for the website', 'suga'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
						),
                        array(
                            'id' => 'section-social-header-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                       
                        
                        array(
                            'id' => 'section-ads-header-start',
                            'title' => esc_html__('Show Ads on this header instead of the Social Items', 'suga'),
                            'type' => 'section',                             
                            'indent' => true, // Indent all options below until the next 'section' option is set.
                            'required'  => array (
                                'bk-header-type','equals',array( 'site-header-3', 'site-header-8', 'site-header-9' )
                            ),
                        ),
                        array(
    						'id'=>'bk-header-ads',
    						'type' => 'switch', 
    						'title' => esc_html__('Header Ads', 'suga'),
                            'default' => 0
						), 
                        
                        array(
    						'id'=>'bk-ads-html',
                            'required' => array('bk-header-ads','=',1),
    						'type' => 'textarea', 
    						'title' => esc_html__('HTML Ads Code', 'suga'),
    						'subtitle' => esc_html__('Insert the HTML Ads Code here', 'suga'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-ads-header-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        
                        array(
                            'id' => 'section-header-subscribe-start',
                            'title' => esc_html__('Header Subscribe Form', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-header-subscribe-switch',
    						'type' => 'switch',
    						'title' => esc_html__('Header Subscribe Switch', 'suga'),
    						'subtitle'=> esc_html__('On/Off Header Subscribe', 'suga'),
    						'default' => 0
						),
                        array(
    						'id'=>'bk-mailchimp-title',
                            'required' => array('bk-header-subscribe-switch','=',1),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Form Title', 'suga'),
                            'default' => '',
						),
                        array(
    						'id'=>'bk-mailchimp-shortcode',
                            'required' => array('bk-header-subscribe-switch','=',1),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'suga'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'suga'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-header-subscribe-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-share',
    				'title' => esc_html__('Social Media Links', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk-social-media-links',
    						'type' => 'text',
    						'title' => esc_html__('Social media', 'suga'),
    						'subtitle' => esc_html__('Set up social links for the website', 'suga'),
    						'options' => array('fb'=>'Facebook Url', 'twitter'=>'Twitter Url', 'gplus'=>'GPlus Url', 'linkedin'=>'Linkedin Url',
                                               'pinterest'=>'Pinterest Url', 'instagram'=>'Instagram Url', 'dribbble'=>'Dribbble Url', 
                                               'youtube'=>'Youtube Url', 'vimeo'=>'Vimeo Url', 'vk'=>'VK Url', 'vine'=>'Vine URL',
                                               'snapchat'=>'SnapChat Url', 'telegram'=>'Telegram Url', 'rss'=>'RSS Url'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Single Page', 'suga'),
    				'fields' => array(
                        array(
                			'id'        => 'bk-post-view--cache-time',
                            'title'     => esc_html__('Post View Cache Time (in second)', 'suga'),
                            'desc'      => esc_html__('Default: 300 means 5 minutes', 'suga'),
                            'type'      => 'slider',
                            'default'   => 300,
                            'min'       => 0,
                            'step'      => 5,
                            'max'       => 3600,
                            'display_value' => 'text'
                		),
                        array(
    						'id'=>'bk-single-template',
    						'type' => 'image_select', 
                            'class' => 'bk-single-post-layout--global-option',
    						'title' => esc_html__('Post Layout', 'suga'),
                            'options' => array(
                                'single-1' => array(
                                    'alt' => 'Single Template 1',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                                ),
                                'single-2' => array(
                                    'alt' => 'Single Template 2',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                                ),
                                'single-3' => array(
                                    'alt' => 'Single Template 3',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                                ),
                                'single-4' => array(
                                    'alt' => 'Single Template 4',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                                ),
                                'single-5' => array(
                                    'alt' => 'Single Template 5',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                                ),
                                'single-6' => array(
                                    'alt' => 'Single Template 6',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                                ),
                                'single-7' => array(
                                    'alt' => 'Single Template 7',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                                ),
                                'single-8' => array(
                                    'alt' => 'Single Template 8',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                                ),
                                'single-9' => array(
                                    'alt' => 'Single Template 9',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                                ),
                                'single-10' => array(
                                    'alt' => 'Single Template 10',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                                ),
                                'single-11' => array(
                                    'alt' => 'Single Template 11',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                                ),
                                'single-12' => array(
                                    'alt' => 'Single Template 12',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                                ),
                                'single-13' => array(
                                    'alt' => 'Single Template 13',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                                ),
                                'single-14' => array(
                                    'alt' => 'Single Template 14',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                                ),
                                'single-15' => array(
                                    'alt' => 'Single Template 15',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                                ),
                                'single-16' => array(
                                    'alt' => 'Single Template 16',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                                ),
                                'single-18' => array(
                                    'alt' => 'Single Template 18',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single_suga_17.png',
                                ),
                            ),
                            'default' => 'single-1',
						),
                        array(
                            'title' => esc_html__( 'Featured Image Config', 'suga' ),
                            'id' => 'bk-feat-img-status',
                            'type'     => 'button_set',
                			'options'  => array(              
                                1 => esc_html__( 'On', 'suga' ),
                                0 => esc_html__( 'Off', 'suga' ),
        				    ),
                			'default'   => 1,
                        ),
                        array(
                            'title' => esc_html__( 'Single Page Meta Items', 'suga' ),
                            'id' => 'bk-single-meta-items',
                            'type'     => 'select',
                			'options'  => array(              
                                8 => esc_html__( 'Author + Date', 'suga' ),
                                9 => esc_html__( 'Author + Date + Comments', 'suga' ),
                                10 => esc_html__( 'Author + Date + Views', 'suga' ),
                                11 => esc_html__( 'Author + Date + Comments + Views', 'suga' ),
                                12 => esc_html__( 'Author + Comments + Views', 'suga' ),
        				    ),
                			'default'   => 10,
                        ),
                        array(
                            'id'=>'section-single-sorter-start',
                            'title' => esc_html__('Sections Sorter', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'      => 'single-sections-sorter',
                            'type'    => 'sorter',
                            'title'   => 'Manage Layouts',
                            'desc'    => 'Organize the layout of Singe Page',
                            'options' => array(
                                'enabled'  => array(
                                    'related'  => esc_html__('Related Section', 'suga'),
                                    'comment'  => esc_html__('Comment Section', 'suga'),
                                    'same-cat' => esc_html__('Same Category Section', 'suga'),
                                ),
                            ),
                        ),
                        array(
                            'id'=>'section-single-sorter-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-single-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_post_sb_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Single Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose sidebar for single page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_post_sb_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_post_sb_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-single-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-sharebox-start',
                            'title' => esc_html__('Social Share', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-sharebox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable share box', 'suga'),
    						'subtitle' => esc_html__('Enable share links below single post', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                            'indent' => true
						),
                        array(
                            'id'=>'bk-fb-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Facebook share link', 'suga'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                        ),
                        array(
                            'id'=>'bk-tw-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Twitter share link', 'suga'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                        ),
                        array(
                            'id'=>'bk-gp-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Google+ share link', 'suga'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                        ),
                        array(
                            'id'=>'bk-pi-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Pinterest share link', 'suga'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                        ),
                        array(
                            'id'=>'bk-li-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Linkedin share link', 'suga'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
                        ),
                        array(
                            'id'=>'section-sharebox-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-author-start',
                            'title' => esc_html__('Post Author Section Setting', 'suga'),                        
                            'type' => 'section', 
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-authorbox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable author box', 'suga'),
    						'subtitle' => esc_html__('Enable author information below single post', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                            'id'=>'section-author-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-postnav-start',
                            'title' => esc_html__('Post Nav Section Setting', 'suga'),                        
                            'type' => 'section', 
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-postnav-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable post navigation', 'suga'),
    						'subtitle' => esc_html__('Enable post navigation below single post', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                            'id'=>'section-postnav-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Advance Single Page - With Sidebar', 'suga'),
    				'fields' => array(
                        array(
                            'id' => 'section-related-start',
                            'title' => esc_html__('Related Posts Section Setting - Has Sidebar Layout', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),  
                         array(
    						'id'=>'bk-related-sw',
    						'type' => 'switch',
    						'title' => esc_html__('Enable related posts', 'suga'),
    						'subtitle' => esc_html__('Enable related posts below single post', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                			'id'        => 'bk_related_post_layout',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Layout', 'suga'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                'listing_list_b'     => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                'listing_list_c'     => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
        				    ),
                			'default'   => 'listing_list',
                		),
                        array(
                			'id'        => 'bk_related_heading_style',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Heading Style', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_related_source',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Related Posts', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
                                            'category_tag' => esc_html__( 'Same Categories and Tags', 'suga' ),
                        					'tag'          => esc_html__( 'Same Tags', 'suga' ),
                                            'category'     => esc_html__( 'Same Categories', 'suga' ),
                                            'author'       => esc_html__( 'Same Author', 'suga' ),
                    				    ),
                			'default'    => 'category_tag',
                		),
                        array(
                			'id'        => 'bk_number_related',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Number of Related Posts', 'suga'),
                            'type'      => 'text', 
                            'validate'  => 'numeric',
                			'default'   => '3',
                		),
                        array(
                			'id'        => 'bk_related_post_icon',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                            'id' => 'section-related-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-same-cat-start',
                            'title' => esc_html__('More From Category Section Setting - Has Sidebar Layout', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-same-cat-sw',
    						'type' => 'switch',
    						'title' => esc_html__('Enable More From Category Section', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                			'id'        => 'bk_same_cat_post_layout',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Layout', 'suga'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                'listing_list_b'     => get_template_directory_uri().'/images/admin_panel/archive/suga_9.png',
                                'listing_list_c'     => get_template_directory_uri().'/images/admin_panel/archive/suga_10.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_4.png',
                                'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_5.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_6.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_7.png',
        				    ),
                			'default'   => 'listing_list',
                		),
                        array(
                			'id'        => 'bk_same_cat_heading_style',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Heading Style', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_same_cat_number_posts',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Number of Posts', 'suga'),
                            'type'      => 'text', 
                            'validate'  => 'numeric',
                			'default'   => '3',
                		),
                        array(
                			'id'        => 'bk_same_cat_post_icon',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                			'id'        => 'bk_same_cat_more_link',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('More Link', 'suga'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1    => esc_html__( 'Enable', 'suga' ),
                                0    => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 0,
                		),
                        array(
                            'id' => 'section-same-cat-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                    )
                );
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Advance Single Page - Full Width', 'suga'),
    				'fields' => array(
                        array(
                            'id' => 'section-related-wide-start',
                            'title' => esc_html__('Related Posts Section Setting - Full Width Post Layout', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),  
                        array(
    						'id'=>'bk-related-sw-wide',
    						'type' => 'switch',
    						'title' => esc_html__('Enable related posts - Wide', 'suga'),
    						'subtitle' => esc_html__('Enable related posts below single post', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                			'id'        => 'bk_related_post_layout_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Layout - Wide', 'suga'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'posts_block_c'      => get_template_directory_uri().'/images/admin_panel/related-module/block_c.png',
                                'posts_block_e'      => get_template_directory_uri().'/images/admin_panel/related-module/block_e.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_b.png',
                                'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
        				    ),
                			'default'   => 'listing_grid_no_sidebar',
                		),
                        array(
                			'id'        => 'bk_related_heading_style_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Heading Style - Wide', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_related_source_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Related Posts - Wide', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
                                            'category_tag' => esc_html__( 'Same Categories and Tags', 'suga' ),
                        					'tag'          => esc_html__( 'Same Tags', 'suga' ),
                                            'category'     => esc_html__( 'Same Categories', 'suga' ),
                                            'author'       => esc_html__( 'Same Author', 'suga' ),
                    				    ),
                			'default'    => 'category_tag',
                		),
                        array(
                			'id'        => 'bk_related_post_icon_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'type'      => 'button_set', 
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                            'id' => 'section-related-wide-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-same-cat-wide-start',
                            'title' => esc_html__('More From Category Section Setting - Full Width Post Layout', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-same-cat-sw-wide',
    						'type' => 'switch',
    						'title' => esc_html__('Enable More From Category Section - Wide', 'suga'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'suga'),
    						'off' => esc_html__('Disabled', 'suga'),
						),
                        array(
                			'id'        => 'bk_same_cat_post_layout_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Layout - Wide', 'suga'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'posts_block_c'      => get_template_directory_uri().'/images/admin_panel/related-module/block_c.png',
                                'posts_block_e'      => get_template_directory_uri().'/images/admin_panel/related-module/block_e.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_b.png',
                                'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_8.png',
                                'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/suga_archive_9.png',
                                
        				    ),
                			'default'   => 'posts_block_c',
                		),
                        array(
                			'id'        => 'bk_same_cat_heading_style_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Heading Style - Wide', 'suga'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_same_cat_post_icon_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                			'id'        => 'bk_same_cat_more_link_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('More Link', 'suga'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
                                0   => esc_html__( 'Disable', 'suga' ),
        				    ),
                			'default'   => 1,
                		),
                        array(
                            'id' => 'section-same-cat-wide-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                    )
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-inbox-box',
    				'title' => esc_html__('Category', 'suga'),
                    'heading'   => esc_html__('Category Pages', 'suga'),
                    'desc'   => esc_html__('Only use for category pages', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk_category_feature_area',
    						'type' => 'image_select', 
    						'title' => esc_html__('Feature Area Layout', 'suga'),
                            'options'  => array(
                                'disable'            => get_template_directory_uri().'/images/admin_panel/disable.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_c.png',
                                'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
        				    ),
                            'default' => 'mosaic_b',
						),
                        array(
                            'id'        => 'bk_category_feature_area__post_option',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Show Feature Area on only first page', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'featured'          => esc_html__( 'Show Featured Posts', 'suga' ),
	                            'latest'            => esc_html__( 'Show Latest Posts', 'suga' ),
                            ),
                            'default' => 'latest',
                        ),
                        array(
                            'id'        => 'bk_feature_area__show_hide',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Show Feature Area on only first page', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1    => esc_html__( 'Yes', 'suga' ),
    			                0    => esc_html__( 'No', 'suga' ),
                            ),
                            'default' => 0,
                        ),
                        array(
    						'id'=>'bk_category_header_style',
    						'type' => 'select', 
                            'required' => array(
                                'bk_category_feature_area', 'equals', array('mosaic_b', 'posts_block_c', 'posts_block_e')
                            ),
    						'title' => esc_html__('Page Heading', 'suga'),
                            'options'  => array(
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
                            'default' => 'large-center',
						),
                        array(
    						'id'=>'bk_category_heading__color',
    						'type' => 'color',
    						'title' => esc_html__('Heading Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the heading.', 'suga'),
    						'default' => '#e04e4f',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk_category_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'suga'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_category_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_category_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'suga'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'suga' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
    						'id'=>'bk_category_exclude_posts',
    						'type' => 'button_set', 
                            'required' => array('bk_category_feature_area','!=','disable'),
    						'title' => esc_html__('[Content Section] Exclude Posts', 'suga'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
                                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
						),
                        array(
                            'id'=>'section-category-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Category Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the category page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-archive-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-tags',
    				'title' => esc_html__('Archive', 'suga'),
                    'heading'   => esc_html__('Archive Pages', 'suga'),
                    'desc'   => esc_html__('Use for Tag / Archive Pages', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk_archive_header_style',
    						'type' => 'select', 
    						'title' => esc_html__('Page Heading', 'suga'),
                            'options'  => array(
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
                            'default' => 'large-center',
						),
                        array(
    						'id'=>'bk_archive_heading__color',
    						'type' => 'color',
    						'title' => esc_html__('Heading Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the heading.', 'suga'),
    						'default' => '#e04e4f',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk_archive_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'suga'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_archive_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_archive_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'suga'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'suga'),
                            'desc'      => esc_html__('This option is only valid on Tag Pages', 'suga'),
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'suga' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-archive-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Archive Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the archive page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-archive-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-group',
    				'title' => esc_html__('Author Page', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk_author_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'suga'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_author_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_author_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'suga'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'suga'),
                            'options'   => array(
                                            'default'           => esc_html__( 'Default Pagination', 'suga' ),
        					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                            'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-author-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Author Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the author page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-author-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-search',
    				'title' => esc_html__('Search Page', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk_search_header_style',
    						'type' => 'select', 
    						'title' => esc_html__('Page Heading', 'suga'),
                            'options'  => array(
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
                            'default' => 'large-center',
						),
                        array(
    						'id'=>'bk_search_heading__color',
    						'type' => 'color',
    						'title' => esc_html__('Heading Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the heading.', 'suga'),
    						'default' => '#e04e4f',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk_search_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'suga'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_search_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_search_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'suga'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'suga' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'suga' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                                        ),
                            'default' => 'default',
                        ),                      
                        array(
                            'id'=>'section-search-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Search Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the search page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-search-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-search',
    				'title' => esc_html__('Ajax Search Panel', 'suga'),
    				'fields' => array(                
                        array(
                            'id'=>'search-panel-recommend-post-section',
                            'title' => esc_html__('Recommend Posts', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                			'id'        => 'search_recommend_heading',
                            'title'     => esc_html__('Heading Text', 'suga'),
                            'type'      => 'text',
                            'default'   => esc_html__('Latest Posts', 'suga'),
                		),
                        array(
    						'id'=>'search_recommend_query_option',
    						'type' => 'select', 
    						'title' => esc_html__('Sort By', 'suga'),
                            'options' => array(
                                'date'              => esc_html__( 'Latest Posts', 'suga' ),
                                'comment_count'     => esc_html__( 'Popular Post by Comments', 'suga' ),
                                'view_count'        => esc_html__( 'Popular Post by Views', 'suga' ),
                                'top_review'        => esc_html__( 'Best Review', 'suga' ),
                                'modified'          => esc_html__( 'Modified', 'suga' ),
                                'alphabetical_asc'  => esc_html__( 'Alphabetical A->Z', 'suga' ),
                                'alphabetical_decs' => esc_html__( 'Alphabetical Z->A', 'suga' ),
        					),
                            'default' => 'date',
						),
                        array(
                            'id'=>'search-panel-recommend-post-section-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'search-panel-tag-section',
                            'title' => esc_html__('Tags Section', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                			'id'        => 'search_panel_tags_headline',
                            'title'     => esc_html__('Heading Text', 'suga'),
                            'type'      => 'text',
                            'default'   => esc_html__('Popular Tags', 'suga'),
                		),
                        array(
                            'id'    =>'section_search_panel_tag_option',
                            'type'  => 'select',
                            'title' => esc_html__('Tags Select', 'suga'),
                            'data'  => 'tags',
                            'multi' => 1,
                        ),
                        array(
                            'id'=>'search-panel-tag-section-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-search-panel-popular-section',
                            'title' => esc_html__('Popular Keywords Section', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                			'id'        => 'search_panel_search_term_headline',
                            'title'     => esc_html__('Heading Text', 'suga'),
                            'type'      => 'text',
                            'default'   => esc_html__('Popular Search', 'suga'),
                		),
                        array(
                            'id'=>'search_term_keyword',
                            'type' => 'multi_text',
                            'title' => esc_html__('Keywords', 'suga'),
                        ),
                        array(
                            'id'=>'search-panel-popular-section-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-pencil',
    				'title' => esc_html__('Blog Page', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk_blog_header_style',
    						'type' => 'select', 
    						'title' => esc_html__('Page Heading', 'suga'),
                            'options'  => array(
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
                            'default' => 'large-center',
						),
                        array(
    						'id'=>'bk_blog_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'suga'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_blog_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'suga' ),
                                'disable'   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_blog_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'suga'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'suga'),
                            'options'   => array(
                                'default'           => esc_html__( 'Default Pagination', 'suga' ),
                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'suga' ),
                            ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-blog-sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Blog Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the blog page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-blog-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-error-alt',
    				'title' => esc_html__('404 Page', 'suga'),
    				'fields' => array(
                        array(
                            'id'=>'section-404-logo-start',
                            'title' => esc_html__('404 Logo', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'404-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Logo', 'suga'),
    						'subtitle' => esc_html__('Upload the logo that should be displayed in 404 page', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
                            'id' => '404-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Site Logo Width (px)', 'suga'),
                            'default' => 200,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'=>'section-404-logo-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-404-image',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('404 Image', 'suga'),
    						'subtitle' => esc_html__('Leave this field empty if you would like to use the default option', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
                            'id'=>'section-404-text-start',
                            'title' => esc_html__('404 Text', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => '404--main-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Main Text', 'suga'),
                            'default'  => ''
                        ),   
                        array(
                            'id'       => '404--sub-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Sub Text', 'suga'),
                            'default'  => ''
                        ),
                        array(
                            'id'=>'section-404-text-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => '404-search',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Search Field', 'suga'),
                            'subtitle'  => esc_html__('Enable / Disable Search Field', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),                        
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-error-alt',
    				'title' => esc_html__('Coming Soon Page', 'suga'),
    				'fields' => array(
                        array(
                            'id'=>'section-coming-soon-background-start',
                            'title' => esc_html__('Coming Soon Background', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-coming-soon-bg-style',                            
    						'type' => 'select',
    						'title' => esc_html__('Background Style', 'suga'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'suga' ),                            
				                'image'      => esc_html__( 'Background Image', 'suga' ),
                                'gradient'   => esc_html__( 'Background Image + Gradient Overlay', 'suga' ),
                                'color'      => esc_html__( 'Background Color', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-image',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'image', 'gradient' )),
                            ),
    						'type' => 'background',
    						'output' => array('.page-coming-soon .background-img>.background-img'),
    						'title' => esc_html__('Background Image', 'suga'), 
    						'subtitle' => esc_html__('Choose background image for the site header', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'transparent' => false,
                            'background-color' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-gradient',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'suga'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-gradient-direction',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'suga'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-coming-soon-bg-color',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',                            
    						'title' => esc_html__('Background Color', 'suga'), 
    						'subtitle' => esc_html__('Choose background color', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-blur-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Background Blur', 'suga'),
    						'default'   => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
						),
                        array(
                            'id'=>'section-coming-soon-background-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),                      
                        array(
                            'id'=>'section-coming-soon-logo-start',
                            'title' => esc_html__('Coming Soon Logo', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'coming-soon-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Logo', 'suga'),
    						'subtitle' => esc_html__('Upload the logo that should be displayed in coming soon page', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
                            'id' => 'coming-soon-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Site Logo Width (px)', 'suga'),
                            'default' => 400,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'=>'section-coming-soon-logo-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-coming-soon-introduction-start',
                            'title' => esc_html__('Coming Soon Introduction', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'coming-soon-introduction--main-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Introduction Text', 'suga'),
                            'default'  => esc_html__('Be ready, we are launching soon.', 'suga'),
                        ),  
                        array(
                            'id'=>'section-coming-soon-introduction-text-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-coming-soon-social-start',
                            'title' => esc_html__('Coming Soon Social', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'       =>'bk-coming-soon--social',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Coming Soon Social Media', 'suga'),
    						'subtitle' => esc_html__('Set up social items for the page', 'suga'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'telegram'=>'', 'rss'=>'')
						),  
                        array(
                            'id'=>'section-coming-soon-social-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),     
                        array(
                            'id'=>'section-coming-soon-date-start',
                            'title' => esc_html__('Coming Soon Date', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'coming-soon--date',
                            'type'     => 'text',
                            'title'    => esc_html__('Date (yyyy-mm-dd)', 'suga'),
                            'default'  => ''
                        ),  
                        array(
                            'id'=>'section-coming-soon-date-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),    
                        array(
                            'id'=>'section-coming-soon-mailchimp-start',
                            'title' => esc_html__('Mailchimp Form', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-coming-soon-mailchimp-shortcode',
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'suga'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'suga'),
                            'default' => '',
						),    
                        array(
                            'id'=>'section-coming-soon-mailchimp-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),  
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-minus',
    				'title' => esc_html__('Default Page Template', 'suga'),
                    'heading'   => esc_html__('Default Page Template', 'suga'),
                    'desc'   => esc_html__('Default Page Template Configuration', 'suga'),
    				'fields' => array(
                        array(
                            'id'    => 'bk_page_header_style',
                            'title' => 'Page Heading',
                            'type'  => 'select',
                            'options'   => array(
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
                            'default'       => 'large-center',
                        ), 
                        array(
    						'id'=>'bk_default_page_heading__color',
    						'type' => 'color',
    						'title' => esc_html__('Heading Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the heading.', 'suga'),
    						'default' => '#e04e4f',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
                            'id'        => 'bk_page_feat_img',
                            'title'     => esc_html__( 'Feature Image Show/Hide', 'suga' ),
                            'type'      => 'switch', 
                			'options'   => array(          
                                            1 => esc_html__( 'Show', 'suga' ),
                                            0 => esc_html__( 'Hide', 'suga' ),
                    				    ),
                			'default'    => 1,
                        ),
                        array(
    						'id'=>'bk_page_layout',
    						'type' => 'select', 
    						'title' => esc_html__('Layout', 'suga'),
                            'options'  => array(
                                'has_sidebar' => esc_html__( 'Has Sidebar', 'suga' ),
                                'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'suga' ),
        				    ),
                            'default' => 'has_sidebar',
						),
                        array(
                            'id'=>'section-default-page--sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-default-page--sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-minus',
    				'title' => esc_html__('Authors List Page', 'suga'),
                    'heading'   => esc_html__('Authors List Page', 'suga'),
                    'desc'   => esc_html__('Authors List Page Configuration', 'suga'),
    				'fields' => array(
                        array(
                            'id'    => 'bk_authors_list_page_header_style',
                            'title' => esc_html__('Page Heading', 'suga'),
                            'type'  => 'select',
                            'options'   => array(
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
                            'default'       => 'large-center',
                        ), 
                        array(
    						'id'=>'bk_authors_list_heading__color',
    						'type' => 'color',
    						'title' => esc_html__('Heading Color', 'suga'), 
    						'subtitle' => esc_html__('Pick a primary color for the heading.', 'suga'),
    						'default' => '#e04e4f',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
                            'id'    => 'bk_authors_list_page_layout',
                            'title' => esc_html__('Authors List Page Layout', 'suga'),
                            'type'  => 'select',
                            'options'   => array(
                                            'listing-list'    => esc_html__( 'Listing List', 'suga' ),
                                            'listing-grid'    => esc_html__( 'Listing Grid', 'suga' ),
                                        ),
                            'default'       => 'listing-list',
                        ),
                        array(
                            'id'        => 'bk_authors_list_page_sidebar',
                            'title'     => esc_html__( 'Authors List Page Sidebar', 'suga' ),
                            'type'      => 'switch', 
                			'options'   => array(          
                                            1 => esc_html__( 'Enable', 'suga' ),
                                            0 => esc_html__( 'Disable', 'suga' ),
                    				    ),
                			'default'    => 1,
                        ),
                        array(
                            'id'=>'section-authors-list-page--start',
                            'title' => esc_html__('Authors List Sidebar Setting', 'suga'),
                            'required' => array('bk_authors_list_page_sidebar','=',1),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_authors_list_page_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Page Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Choose a sidebar for the page', 'suga'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_authors_list_page_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_authors_list_page_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
        		                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-authors-list-page--end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-minus',
    				'title' => esc_html__('Pagebuilder Template', 'suga'),
                    'heading'   => esc_html__('Pagebuilder Template', 'suga'),
                    'desc'   => esc_html__('Pagebuilder Template Configuration', 'suga'),
    				'fields' => array(
                        array(
                            'id'=>'section-pagebuilder--sidebar-start',
                            'title' => esc_html__('Sidebar', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_pagebuilder_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'suga'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'suga'),
                            'desc'      => '',
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'suga' ),
				                0   => esc_html__( 'Disable', 'suga' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-pagebuilder--sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-website',
    				'title' => esc_html__('Footer', 'suga'),
    				'fields' => array(
                        array(
    						'id'=>'bk-footer-template',
                            'class' => 'bk-footer-layout--global-option',
    						'title' => esc_html__('Footer Layout', 'suga'),
                            'type' => 'image_select', 
                            'options'  => array(
                                'footer-1' => get_template_directory_uri().'/images/admin_panel/footer/1.png',
                                'footer-6' => get_template_directory_uri().'/images/admin_panel/footer/6.png',
                                'footer-7' => get_template_directory_uri().'/images/admin_panel/footer/7.png',
                                'footer-8' => get_template_directory_uri().'/images/admin_panel/footer/8.png',
                            ),
                            'default' => 'footer-1',
						),
                        
                        array(
                            'id' => 'section-footer-bg-start',
                            'title' => esc_html__('Footer Background', 'suga'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-footer-bg-style',
    						'type' => 'select',
    						'title' => esc_html__('Footer Background Style', 'suga'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'suga' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'suga' ),
                                'color'      => esc_html__( 'Background Color', 'suga' ),
                            ),
						),
                        array(
    						'id'=>'bk-footer-bg-gradient',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'suga'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-footer-bg-gradient-direction',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'suga'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-footer-bg-color',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'suga'), 
    						'subtitle' => esc_html__('Choose background color for the Footer', 'suga'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#333',
                            ),
						),
                        array(
    						'id'=>'bk-footer-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Footer Text', 'suga'),
    						'default'   => 0,
                            'options'   => array(
				                0   => esc_html__( 'Black', 'suga' ),
                                1   => esc_html__( 'White', 'suga' ),
                            ),
						),
                        array(
                            'id' => 'section-footer-bg-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        
                        array(
                            'id'       => 'footer-col-scale',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column Width', 'suga'),
                            'options'   => array(
                                            1   => esc_html__( '1/3 1/3 1/3', 'suga' ),
            					            2   => esc_html__( '1/2 1/4 1/4', 'suga' ),
                             ),
                             'default'  => 1,
                        ),
                        array(
                            'id'       => 'footer-col-1',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 1', 'suga'),
                            'default'  => 'footer_sidebar_1',
                        ),
                        array(
                            'id'       => 'footer-col-2',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 2', 'suga'),
                            'default'  => 'footer_sidebar_2',
                        ),
                        array(
                            'id'       => 'footer-col-3',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 3', 'suga'),
                            'default'  => 'footer_sidebar_3',
                        ),
                        array(
                            'id' => 'section-footer-logo-start',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-6' )
                            ),
                            'title' => esc_html__('Footer Logo', 'suga'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-footer-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Footer Logo', 'suga'),
    						'subtitle' => esc_html__('Upload the logo image that will be displayed in footer', 'suga'),
                            'placeholder' => esc_html__('No media selected','suga')
						),
                        array(
                            'id' => 'footer-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Footer Logo Width (px)', 'suga'),
                            'default' => 200,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id' => 'section-footer-logo-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-footer-bottom-start',
                            'title' => esc_html__('Footer Bottom', 'suga'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'footer-social',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-4', 'footer-5', 'footer-6' )
                            ),
                            'type'     => 'select',
                            'multi'    => true,
                            'title'    => esc_html__('Footer Social', 'suga'),
                            'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'telegram'=>'Telegram', 'rss'=>'RSS'),
                        ),
                        array(
                            'id'       => 'footer-copyright-text',
                            'type'     => 'textarea',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6','footer-7', 'footer-8' )
                            ),
                            'rows'     => 3,
                            'title'    => esc_html__('Footer Copyright Text', 'suga'),
                            'default'  => 'By <a href="https://themeforest.net/user/bkninja/portfolio">BKNinja</a>'
                        ),
                        array(
                            'id' => 'section-footer-bottom-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ) 
    				)
    			);
			$theme_info = '<div class="redux-framework-section-desc">';
			$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'suga').'<a href="'.$this->theme->get('ThemeURI').'" target="_blank">'.$this->theme->get('ThemeURI').'</a></p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'suga').$this->theme->get('Author').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'suga').$this->theme->get('Version').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$this->theme->get('Description').'</p>';
			$tabs = $this->theme->get('Tags');
			if ( !empty( $tabs ) ) {
				$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'suga').implode(', ', $tabs ).'</p>';	
			}
			$theme_info .= '</div>';

			$this->sections[] = array(
				'type' => 'divide',
			);

		}	

		public function setHelpTabs() {

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'suga_option', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> esc_html__( 'Theme Options', 'suga' ),
	            'page'		 	 		=> esc_html__( 'Theme Options', 'suga' ),
	            'google_api_key'   	 	=> 'AIzaSyBdxbxgVuwQcnN5xCZhFDSpouweO-yJtxw', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support
                'google_update_weekly'  => true, //This will only function if you have a google_api_key provided. This argument tells the core to grab the Google fonts cache weekly, ensuring your font list is always up to date.

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            	=> true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // esc_html__( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			$this->args['share_icons'][] = array(
			    'url' => 'https://github.com/ReduxFramework/ReduxFramework',
			    'title' => 'Visit us on GitHub', 
			    'icon' => 'el-icon-github'
			    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
			);		
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
			    'title' => 'Like us on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/reduxframework',
			    'title' => 'Follow us on Twitter', 
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://www.linkedin.com/company/redux-framework',
			    'title' => 'Find us on LinkedIn', 
			    'icon' => 'el-icon-linkedin'
			);

			
	 
			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = '';
			} else {
				$this->args['intro_text'] = '';
			}

			// Add content after the form.
			$this->args['footer_text'] = '' ;

		}
	}
	new Redux_Framework_config();

}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
