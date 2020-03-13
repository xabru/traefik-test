<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'suga_register_instagram_widget');
function suga_register_instagram_widget(){
	register_widget('suga_instagram');
}
class suga_instagram extends WP_Widget {
    
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'suga-widget widget--instagram', 'description' => esc_html__('Displays Instagram Gallery.', 'the-next-mag') );

		/* Create the widget. */
		parent::__construct( 'suga_instagram', esc_html__('[SUGA]: Instagram', 'the-next-mag'), $widget_ops);
	}
    function widget( $args, $instance ) {
		extract($args);
        $title = $instance['title'];
        $headingStyle = $instance['heading_style'];
        $access_token = apply_filters('instagram_token', $instance['instagram_token']);
    	$amount = apply_filters('image_amount', $instance['image_amount']);
        
        if($headingStyle) {
            $headingClass = suga_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = '';
        }
        
        $json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
        $json_link .="access_token={$access_token}&count={$amount}";
        $json = file_get_contents($json_link);
        $obj = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $json), true);
        
        $userInfo_jsonLink = "https://api.instagram.com/v1/users/self/?access_token={$access_token}";
        $userInfo_json = file_get_contents($userInfo_jsonLink);
        $userInfo = json_decode($userInfo_json);
        
        echo $before_widget; 
        
		?>
        <div class="widget-instagram__inner">
            <?php if ( $title ) { echo suga_widget::bk_get_widget_heading($title, $headingClass); }?>
    		<div class="widget__content">
                <div class="author-content">
                    <div class="entry-meta">
                        <div class="entry-author entry-author--with-ava m-r-xs">
                            <img alt="<?php echo esc_attr($userInfo->data->username);?>" src="<?php echo esc_url($userInfo->data->profile_picture);?>" class="avatar  photo entry-author__avatar">
                        </div>
                        <div class="entry-tags">
                            <a class="entry-author__name" href="<?php echo esc_url('https://www.instagram.com/'.$userInfo->data->username);?>"><?php echo esc_html($userInfo->data->username);?></a>
                            <div class="entry-tag">
                                <span class="entry-tags-title"><?php echo esc_html($userInfo->data->counts->followed_by);?> followers</span>
                            </div>
                        </div>
    
                    </div>
                </div>
                <ul class="list-unstyled clearfix">
                    <?php
                        foreach ($obj['data'] as $post){
                            $pic_link = $post['link'];
                            $pic_src=str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
                            echo '<li class="instagram-item">';
                                echo "<a href='{$pic_link}' target='_blank'>";
                                  echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='instagram_img'>";
                                echo "</a>";
                            echo "</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        								
        <?php echo $after_widget; ?>
        			 
        <?php }	

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
      /* Set up some default widget settings. */
      $defaults = array( 'title' => '', 'heading_style' => 'default', 'instagram_token' => '', 'image_amount' => '');
      $instance = wp_parse_args( (array) $instance, $defaults );	

      $title = esc_attr($instance['title']);
			$instagram_token = esc_attr($instance['instagram_token']);
			$amount = esc_attr($instance['image_amount']);	
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
    <p><label for="<?php echo $this->get_field_id('instagram_token'); ?>"><?php esc_html_e( 'Instagram Token:', 'the-next-mag'); ?> <input class="widefat" id="<?php echo $this->get_field_id('instagram_token'); ?>" name="<?php echo $this->get_field_name('instagram_token'); ?>" type="text" value="<?php echo $instagram_token; ?>" /></label></p>
    <span><?php esc_html_e('Please get the Instagram Token here: ', 'devias');?><a target="_blank" href="https://instagram.pixelunion.net/"><?php esc_html_e('Get Instagram Token', 'devias');?></a></span>
    <p><label for="<?php echo $this->get_field_id('image_amount'); ?>"><?php esc_html_e( 'Images count:', 'the-next-mag'); ?> <input class="widefat" id="<?php echo $this->get_field_id('image_amount'); ?>" name="<?php echo $this->get_field_name('image_amount'); ?>" type="text" value="<?php echo $amount; ?>" /></label></p>	

<?php }

}
?>