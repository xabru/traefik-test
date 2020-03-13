<?php
/**
 * Plugin Name: [SUGA] Widget Posts List
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the most recent posts with thumbnails in the tabs.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_widget_posts_list' );

function bk_register_widget_posts_list() {
	register_widget( 'bk_widget_posts_list' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_widget_posts_list extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'atbssuga-widget', 'description' => esc_html__('Displays Posts List.', 'the-next-mag') );

		/* Create the widget. */
		parent::__construct( 'bk_widget_posts_list', esc_html__('[SUGA] Widget Posts List', 'the-next-mag'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        
        $widget_opts = array();
        $title = $instance['title'];
        $headingStyle = $instance['heading_style'];
        $widgetModule = $instance['widget_module'];
        $widgetClass = suga_widget::bk_get_widget_module_class($widgetModule);
        
        if($headingStyle) {
            $headingClass = suga_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = '';
        }
        
        $widget_opts['offset']      = !empty( $instance['offset'] )     ? $instance['offset'] : 0;
        $widget_opts['category_id'] = !empty( $instance['category_id'] )? $instance['category_id'] : 0;
        $widget_opts['category_ids'] = !empty( $instance['category_ids'] )? $instance['category_ids'] : '';
        $widget_opts['tags']        = !empty( $instance['tags'] )       ? $instance['tags'] : '';
        $widget_opts['entries']     = !empty( $instance['entries'] )    ? $instance['entries'] : 4;	
        $widget_opts['orderby']     = !empty( $instance['orderby'] )    ? $instance['orderby'] : 'date';	
        
        $widget_style              = !empty( $instance['widget_style'] )    ? $instance['widget_style'] : 'normal';	
        if($widget_style == 'boxed') {
            $widgetClass .= ' atbssuga-widget--box';
        }
        
        $the_query =  suga_widget::bk_widget_query($widget_opts);
        
        $widgetMeta = array();
        $widgetMeta = suga_widget::bk_widget_meta($widget_opts['orderby']);
        
        echo ($before_widget);
        
        echo '<div class="'.$widgetClass.'">';
        
		if ( $title ) { echo suga_widget::bk_get_widget_heading($title, $headingClass); }
        
		if ( $the_query -> have_posts() ) :
            if($widget_style == 'boxed') echo '<div class="widget__inner">';
            switch ( $widgetModule ) {
                case 'indexed-posts-a' :
                    echo '<ol class="posts-list list-space-sm list-unstyled">';
                    echo suga_widget::bk_listing_posts_a_render($the_query, $widgetMeta);
                    echo '</ol>';
                    break;
                
                case 'indexed-posts-b' :
                    echo '<ol class="posts-list list-space-xl list-unstyled">';
                    echo suga_widget::bk_listing_posts_b_render($the_query, $widgetMeta);
                    echo '</ol>';
                    break;
                    
                case 'indexed-posts-c' :
                    switch($widget_opts['orderby']) {
                        case 'view_count':
                            $widgetMeta = array('view');
                            break;
                        case 'comment_count':
                            $widgetMeta = array('comment');
                            break;
                        default:
                            $widgetMeta = array();
                            break;
                    }
                    echo suga_widget::bk_indexed_posts_c_render($the_query, $widgetMeta);
                    break;
                    
                case 'posts-listing-a' :
                    echo '<div class="widget-content">';
                    echo '<ul class="list-unstyled list-space-sm">';
                    echo suga_widget::bk_listing_posts_a_render($the_query, $widgetMeta);
                    echo '</ul>';
                    echo '</div>';
                    break;
                
                case 'posts-listing-b' :
                    echo '<ol class="posts-list list-space-xl list-unstyled">';
                    echo suga_widget::bk_listing_posts_b_render($the_query, $widgetMeta);
                    echo '</ol>';
                    break;
                
                case 'posts-listing-c' :
                    echo '<div class="widget-content posts-listing-c">';
                    echo '<ul class="list-unstyled list-space-sm">';
                    echo suga_widget::bk_listing_posts_c_render($the_query, $widgetMeta);
                    echo '</ul>';
                    echo '</div>';
                    break;
                
                case 'posts-listing-d' :
                    echo '<ul class="posts-list list-space-md list-seperated list-unstyled">';
                    echo suga_widget::bk_listing_posts_d_render($the_query, $widgetMeta);
                    echo '</ul>';
                    break;
                
                case 'posts-listing-e' :
                    echo '<ol class="posts-list list-space-sm list-unstyled">';
                    echo suga_widget::bk_listing_posts_e_render($the_query, $widgetMeta);
                    echo '</ol>';
                    break;
                    
                default :
                    echo '<div class="widget-content">';
                    echo '<ul class="list-unstyled list-space-sm">';
                    echo suga_widget::bk_listing_posts_a_render($the_query, $widgetMeta);
                    echo '</ul>';
                    echo '</div>';
                    break;
            }
            if($widget_style == 'boxed') echo '</div>';
		endif;
        ?>
    <?php
        echo '</div><!-- End Widget Module-->';
        /* After widget (defined by themes). */
		echo ($after_widget);
        wp_reset_postdata();
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title']      = $new_instance['title'];
        $instance['heading_style'] = strip_tags($new_instance['heading_style']);
        $instance['widget_module'] = strip_tags($new_instance['widget_module']);
        $instance['widget_style'] = strip_tags($new_instance['widget_style']);
		$instance['entries']    = intval(strip_tags($new_instance['entries']));
        $instance['offset']     = intval(strip_tags($new_instance['offset']));
        $instance['category_id']= strip_tags($new_instance['category_id']);
        $instance['category_ids']= strip_tags($new_instance['category_ids']);
        $instance['tags']       = strip_tags($new_instance['tags']);
        $instance['orderby']    = strip_tags($new_instance['orderby']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Posts List', 'heading_style' => 'default', 'widget_module' => 'indexed-posts-a', 'widget_style' => 'normal', 'entries' => 5, 'offset' => 0, 'category_id' => 'all', 'category_ids' => '', 'tags' => '', 'orderby' => 'date');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('[Optional] Title:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php if( !empty($instance['title']) ) echo esc_attr($instance['title']); ?>" />
		</p>
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'heading_style' )); ?>"><?php esc_attr_e('Heading Style:', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'heading_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'heading_style' )); ?>" >
			    <option value="default" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'default' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Default - From Theme Option', 'the-next-mag'); ?></option>
                <option value="line" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Line', 'the-next-mag'); ?></option>
			    <option value="no-line" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'no-line' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading No Line', 'the-next-mag'); ?></option>
			    <option value="line-under" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line-under' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Line Under', 'the-next-mag'); ?></option>
			    <option value="center" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'center' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Center', 'the-next-mag'); ?></option>
			    <option value="line-around" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line-around' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Line Around', 'the-next-mag'); ?></option>
			</select>
	    </p>
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'widget_module' )); ?>"><?php esc_attr_e('Widget Module:', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'widget_module' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'widget_module' )); ?>" >
			    <option value="indexed-posts-a" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'indexed-posts-a' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Indexed Posts A', 'the-next-mag'); ?></option>
			    <option value="indexed-posts-b" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'indexed-posts-b' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Indexed Posts B', 'the-next-mag'); ?></option>
			    <option value="indexed-posts-c" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'indexed-posts-c' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Indexed Posts C', 'the-next-mag'); ?></option>
			    <option value="posts-listing-a" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'posts-listing-a' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Posts Listing A', 'the-next-mag'); ?></option>
			    <option value="posts-listing-b" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'posts-listing-b' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Posts Listing B', 'the-next-mag'); ?></option>
			    <option value="posts-listing-c" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'posts-listing-c' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Posts Listing C', 'the-next-mag'); ?></option>
			    <option value="posts-listing-d" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'posts-listing-d' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Posts Listing D', 'the-next-mag'); ?></option>
			    <option value="posts-listing-e" <?php if( !empty($instance['widget_module']) && $instance['widget_module'] == 'posts-listing-e' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Posts Listing E', 'the-next-mag'); ?></option>
            </select>
	    </p>
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'widget_style' )); ?>"><?php esc_attr_e('Style:', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'widget_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'widget_style' )); ?>" >
			    <option value="normal" <?php if( !empty($instance['widget_style']) && $instance['widget_style'] == 'normal' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Normal', 'the-next-mag'); ?></option>
			    <option value="boxed" <?php if( !empty($instance['widget_style']) && $instance['widget_style'] == 'boxed' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Boxed', 'the-next-mag'); ?></option>
            </select>
	    </p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'entries' )); ?>"><strong><?php esc_html_e('[Optional] Number of entries to display: ', 'the-next-mag'); ?></strong></label>
		<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('entries')); ?>" name="<?php echo esc_attr($this->get_field_name('entries')); ?>" value="<?php echo esc_attr($instance['entries']); ?>"/></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'offset' )); ?>"><strong><?php esc_html_e('[Optional] Offet Posts number: ', 'the-next-mag'); ?></strong></label>
		<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('offset')); ?>" name="<?php echo esc_attr($this->get_field_name('offset')); ?>" value="<?php echo esc_attr($instance['offset']); ?>" /></p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('category_id')); ?>"><strong><?php esc_html_e('Filter by Category: ','the-next-mag');?></strong></label> 
			<select id="<?php echo esc_attr($this->get_field_id('category_id')); ?>" name="<?php echo esc_attr($this->get_field_name('category_id')); ?>" class="widefat categories">
				<option value='all' <?php if ('all' == $instance['category_id']) echo 'selected="selected"'; ?>><?php esc_html_e( 'All Categories', 'the-next-mag' ); ?></option>
				<?php $categories = get_categories('hide_empty=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['category_id']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p> 
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>"><?php esc_attr_e('[Optional] Multiple Category: (Separate category ids by the comma. e.g. 1,2):','the-next-mag') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category_ids' )); ?>" value="<?php if( !empty($instance['category_ids']) ) echo esc_attr($instance['category_ids']); ?>" />
	    </p>
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>"><?php esc_attr_e('[Optional] Tags(Separate tags by the comma. e.g. tag1,tag2):','the-next-mag') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tags' )); ?>" value="<?php if( !empty($instance['tags']) ) echo esc_attr($instance['tags']); ?>" />
	    </p>
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_attr_e('Order By:', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" >
			    <option value="date" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'date' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Latest Posts', 'the-next-mag'); ?></option>
			    <option value="comment_count" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'comment_count' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Popular Post by Comments', 'the-next-mag'); ?></option>
			    <option value="view_count" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'view_count' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Popular Post by Views', 'the-next-mag'); ?></option>
                <option value="top_review" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'top_review' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Best Review', 'the-next-mag'); ?></option>
			    <option value="modified" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'modified' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Modified', 'the-next-mag'); ?></option>
			    <option value="rand" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'rand' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Random Post', 'the-next-mag'); ?></option>
			    <option value="alphabetical_asc" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'alphabetical_asc' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Alphabetical A->Z', 'the-next-mag'); ?></option>
			    <option value="alphabetical_decs" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'alphabetical_decs' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Alphabetical Z->A', 'the-next-mag'); ?></option>
		    </select>
	    </p>       
<?php
	}
}
?>
