<?php
/*
Plugin Name: Bambuser for Wordpress - Shortcode
Plugin URI: http://blog.mattiasnorell.com/2010/01/03/bambuser-for-wordpress/
Description: Allows the user to embed livestreams and videos from Bambuser.
Author: Mattias Norell
Contributors: Mattias Norell
Version: 1.5
Author URI: http://blog.mattiasnorell.com/
License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
*/


// SHORTCODE
class bambuser_code{
	function get_bambuser_code($atts, $content=null) {
		return get_videoplayer($atts);
    }
}


// WIDGET
class bambuser_widget extends WP_Widget {
	
	function bambuser_widget(){
		$widget_ops = array('classname' => 'bambuser-for-wordpress-widget', 'description' => 'Embed livestreams and videos from Bambuser.' );
		$this->WP_Widget('bambuser-for-wordpress-widget', __('Bambuser for Wordpress'), $widget_ops);
	}
	
	function bambuser_widget_markup($title,$atts) {
		
		if(isset($title)){
			echo '<h4>' . $title . '</h4>';	
		}
		
		?>
		<div class="bambuser-for-wordpress-widget" id="_bambuser_<?php echo $id ?>">
		<?php echo get_videoplayer($atts); ?>
        </div>
		<?php
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_alias', $instance['title']);
        $this->bambuser_widget_markup($title,$instance);
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['channel'] = strip_tags($new_instance['channel']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['debug'] = strip_tags($new_instance['debug']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '','width' => '','height' => '','debug' => 'off','controls' => 'on') );
		$title = strip_tags($instance['title']);
		$id = strip_tags($instance['id']);
		$channel = strip_tags($instance['channel']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$debug = esc_attr($instance['debug']);
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('id'); ?>">StreamID <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>
        
        <p><label for="<?php echo $this->get_field_id('channel'); ?>">ChannelID (username) <input class="widefat" id="<?php echo $this->get_field_id('channel'); ?>" name="<?php echo $this->get_field_name('channel'); ?>" type="text" value="<?php echo attribute_escape($channel); ?>" /></label></p>
            
        <p><label for="<?php echo $this->get_field_id('width'); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></label></p>
            
        <p><label for="<?php echo $this->get_field_id('height'); ?>">Height: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" /></label></p>
        
             
            <?php _e('Debug:'); ?>
			<p>
            Off: <input type="radio" name="<?php echo $this->get_field_name('debug'); ?>" value="off" <?php if($debug === 'off' || $debug === ''){ echo 'checked="checked"'; } ?>/>
            On: <input type="radio" name="<?php echo $this->get_field_name('debug'); ?>" value="on" <?php if($debug === 'on'){ echo 'checked="checked"'; } ?>/>
            Error: <input type="radio" name="<?php echo $this->get_field_name('debug'); ?>" value="error" <?php if($debug === 'error'){ echo 'checked="checked"'; } ?>/>
            Silent: <input type="radio" name="<?php echo $this->get_field_name('debug'); ?>" value="silent" <?php if($debug === 'silent'){ echo 'checked="checked"'; } ?>/>
            </p>
            
<?php
	}
	
}

function bambuser_widget_load() {
	register_widget( 'bambuser_widget' );
}

function get_videoplayer($atts){
	
	extract(shortcode_atts(array('id'  => '', 'channel' => '', 'playlist' => 'hide', 'width'   => '320', 'height'  => '276', 'debug'  => 'off'), $atts));

	$contentType;
	$contentId;
		
	if(is_numeric($id) && $channel == ''){
		$contentId = $id;
		$contentType = 'broadcast';
	}
	
	if(!is_numeric($id) && $channel != ''){
		$contentId = $channel;
		$contentType = 'channel';
	}
	
	if(is_numeric($id) && $channel != ''){
		return "<strong>Bambuser for Wordpress</strong><br/>You can't use both a stream- and channel id at the same time.";
	}
		
	if(!$contentId || $contentId == ''){
		$debugError = "Required parameter missing.";
	}
		
	$videoPlayer = '<iframe src="http://embed.bambuser.com/'.$contentType.'/'.$contentId.'" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>';
			
	if($debug == "on" || $debug == "silent" || $debug == "error"){	
		$debugOutput = "<strong>Bambuser for Wordpress</strong>";
		
		if(isset($debugError)){
			$debugOutput .= "<br/><br/>Error: ". $debugError;
		}
		
		$debugOutput .= "<br/><br/><u>Settings</u>";
		
		foreach ($atts as $keyName => $value) {
   			$debugOutput .= "<br/>" . $keyName . ": " . $value;
		}
			
		if($debug == "on"){
			echo "<span style=\"display:block;border:1px solid #000;padding:10px;\">" . $debugOutput . "</span>";
		}elseif($debug == "silent"){
			echo "<!-- ". strip_tags(str_replace("<br/>","\n",$debugOutput)) ." -->";
		}elseif($debug == "error"){
			if(isset($debugError)){
				echo "<span style=\"display:block;border:1px solid #000;padding:10px;\">" . $debugOutput . "</span>";
			}
		}
	}	
	
	return $videoPlayer;	
}

// EVENTS
add_action( 'widgets_init', 'bambuser_widget_load' );
add_shortcode('bambuser', array('bambuser_code', 'get_bambuser_code'));
?>
