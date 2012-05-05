<?php
/*
* GRAND FlAGallery Widget
*/

/**
 * flagSlideshowWidget - The slideshow widget control for GRAND FlAGallery ( require WP2.8 or higher)
 *
 * @package GRAND FlAGallery
 * @access public
 */
class flagSlideshowWidget extends WP_Widget {

	function flagSlideshowWidget() {
		$widget_ops = array('classname' => 'widget_grandpages', 'description' => __( 'Show links to GRAND Pages as random images from the galleries', 'flag') );
		$this->WP_Widget('flag-grandpages', __('FLAGallery GRANDPages', 'flag'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $wpdb, $flagdb;

		extract( $args );

        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);

        $pages = array_filter( array_map ( 'intval', explode( ',', $instance['pages'] ) ) );
		$args = array( 'post_type' => 'flagallery', 'post__in' => $pages, 'orderby' => 'post__in' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			$gp_ID = get_the_ID();
			$flag_custom = get_post_custom($gp_ID);
			$gal_array = array_filter( array_map ( 'intval', explode( ',', $flag_custom["mb_items_array"][0] ) ) );
			$gid = $gal_array[0];
			if($gid)
				$imageList[$gp_ID] = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 AND t.gid = {$gid} ORDER by rand() LIMIT 1");
			else if ($gid == 0) {
				$imageList[$gp_ID] = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER by rand() LIMIT 1");
			} else {
				return false;
			}
			$imageList[$gp_ID]['link'] = get_permalink( $gp_ID );
			$imageList[$gp_ID]['title'] = get_the_title( $gp_ID );
		endwhile;
		echo $before_widget . $before_title . $title . $after_title;
		echo "\n" . '<div class="flag-widget">'. "\n";

		if (is_array($imageList)){
			foreach($imageList as $key => $image) {
				// get the URL constructor
				$image = new flagImage($image[0]);

				// get the effect code
				$thumbcode = 'class="flag_grandpages"';

				// enable i18n support for alttext and description
				$alttext      =  $imageList[$key]['title'];
				$description  =  strip_tags( htmlspecialchars( stripslashes( flagGallery::i18n($image->description, 'pic_' . $image->pid . '_description') )) );

				//TODO:For mixed portrait/landscape it's better to use only the height setting, if widht is 0 or vice versa
				$out = '<a href="'.$imageList[$key]['link'].'" title="' . $image->title . '" ' . $thumbcode .'>';
				$out .= '<img src="'.$image->thumbURL.'" width="'.$instance['width'].'" height="'.$instance['height'].'" title="'.$alttext.'" alt="'.$description.'" />';
				echo $out . '</a>'."\n";

			}
		}

		echo '</div>'."\n";
		echo '<style type="text/css">.flag_grandpages img { border: 1px solid #A9A9A9; margin: 0 2px 2px 0; padding: 1px; }</style>'."\n";
		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']	= strip_tags($new_instance['title']);
		$instance['width']	= (int) $new_instance['width'];
		$instance['height']	= (int) $new_instance['height'];
		$instance['pages']	= $new_instance['pages'];

		return $instance;
	}

	function form( $instance ) {
		global $wpdb, $flagdb;

		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
            'title' => 'GRAND Galleries',
            'width' => '75',
            'height'=> '65',
            'pages' =>  '') );
		$title  = esc_attr( $instance['title'] );
		$width  = esc_attr( $instance['width'] );
        $height = esc_attr( $instance['height'] );
        $pages = esc_attr( $instance['pages'] );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :','flag'); ?>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" class="widefat" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<?php _e('Width x Height of thumbs:','flag'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /> (px)
		</p>

		<div>
			<div><?php _e('Select GRAND Pages:','flag'); ?></div>
			<div class="grandGalleries" style="width: 206px; height: auto; max-height: 160px; overflow: auto; margin-bottom: 10px;">
				<?php
					$args = array( 'post_type' => 'flagallery' );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
						$id = get_the_ID();
						$ch = in_array($id, explode(',',$pages))? ' checked="checked"' : '';
						echo '<div class="row"><input type="checkbox"'.$ch.' value="' . $id . '" /> <span>' . $id . ' - ' . get_the_title() . '</span></div>' . "\n";
					endwhile;
				?>
			</div>
			<div class="grand_items_array"><?php _e('galleries order:','flag'); ?><br /><input readonly="readonly" type="text" id="<?php echo $this->get_field_id('pages'); ?>" name="<?php echo $this->get_field_name('pages'); ?>" value="<?php echo $pages; ?>" style="width: 206px; font-size:10px;" /></div>
		</div>

	<?php

	}

}

// register it
add_action('widgets_init', create_function('', 'return register_widget("flagSlideshowWidget");'));


class flagBannerWidget extends WP_Widget {

	function flagBannerWidget() {
		$widget_ops = array('classname' => 'widget_banner', 'description' => __( 'Show a GRAND FlAGallery Banner', 'flag') );
		$this->WP_Widget('flag-banner', __('FLAGallery Banner', 'flag'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Banner', 'flag') : $instance['title'], $instance, $this->id_base);

		$out = $this->render_slideshow($instance['xml'] , $instance['width'] , $instance['height'] , $instance['skin']);

		if ( !empty( $out ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="flag_banner widget">
			<?php echo $out; ?>
		</div>
		<?php
			echo $after_widget;
		}

	}

	function render_slideshow($xml, $w = '100%', $h = '200', $skin = '') {
        $out = do_shortcode('[grandbannerwidget xml='.$xml.' w='.$w.' h='.$h.' skin='.$skin.']');
		return $out;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['xml'] = $new_instance['xml'];
		$instance['height'] = (int) $new_instance['height'];
		$instance['width'] = $new_instance['width'];
		$instance['skin'] = $new_instance['skin'];

		return $instance;
	}

	function form( $instance ) {

		global $wpdb;

		require_once (dirname( dirname(__FILE__) ) . '/admin/get_skin.php');
		require_once (dirname( dirname(__FILE__) ) . '/admin/banner.functions.php');

		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Banner', 'xml' => '', 'width' => '100%', 'height' => '200', 'skin' => 'banner_widget_default') );
		$title  = esc_attr( $instance['title'] );
		$width  = esc_attr( $instance['width'] );
		$height = esc_attr( $instance['height'] );
		$skin  = esc_attr( $instance['skin'] );
		$all_playlists = get_b_playlists();
		$all_skins = get_skins(false,'w');
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('xml'); ?>"><?php _e('Select playlist:', 'flag'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('xml'); ?>" id="<?php echo $this->get_field_id('xml'); ?>" class="widefat">
<?php
	foreach((array)$all_playlists as $playlist_file => $playlist_data) {
		$playlist_name = basename($playlist_file, '.xml');
?>
					<option <?php selected($playlist_name , $instance['xml']); ?> value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
<?php
	}
?>
				</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'flag'); ?></label> <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $height; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'flag'); ?></label> <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $width; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('skin'); ?>"><?php _e('Select Skin:', 'flag'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('skin'); ?>" id="<?php echo $this->get_field_id('skin'); ?>" class="widefat">
<?php
				if($all_skins) {
					foreach ( (array)$all_skins as $skin_file => $skin_data) {
						echo '<option value="'.dirname($skin_file).'"';
						if (dirname($skin_file) == $instance['skin']) echo ' selected="selected"';
						echo '>'.$skin_data['Name'].'</option>'."\n";
					}
				}
?>
				</select>
		</p>
<?php
	}

}

// register it
add_action('widgets_init', create_function('', 'return register_widget("flagBannerWidget");'));

function flagBannerWidget($xml, $w = '100%', $h = '200', $skin = 'default') {

	echo flagBannerWidget::render_slideshow($xml, $w, $h, $skin);

}



/**
 * flagWidget - The widget control for GRAND FlAGallery
 *
 * @package GRAND FlAGallery
 * @access public
 */
class flagWidget extends WP_Widget {

   	function flagWidget() {
		$widget_ops = array('classname' => 'flag_images', 'description' => __( 'Add recent or random images from the galleries', 'flag') );
		$this->WP_Widget('flag-images', __('FLAGallery Widget', 'flag'), $widget_ops);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']	= strip_tags($new_instance['title']);
		$instance['type']	= $new_instance['type'];
		$instance['width']	= (int) $new_instance['width'];
		$instance['height']	= (int) $new_instance['height'];
		$instance['fwidth']	= (int) $new_instance['fwidth'];
		$instance['fheight']	= (int) $new_instance['fheight'];
		$instance['album']	= (int) $new_instance['album'];
		$instance['skin']	= $new_instance['skin'];

		return $instance;
	}

	function form( $instance ) {
		global $wpdb, $flagdb;

		require_once (dirname( dirname(__FILE__) ) . '/admin/get_skin.php');

		$all_skins = get_skins();

		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
            'title' => 'Galleries',
            'type'  => 'random',
            'width' => '75',
            'height'=> '65',
            'fwidth' => '640',
            'fheight'=> '480',
            'album' =>  '',
			'skin'	=> '' ) );
		$title  = esc_attr( $instance['title'] );
		$width  = esc_attr( $instance['width'] );
        $height = esc_attr( $instance['height'] );
		$fwidth  = esc_attr( $instance['fwidth'] );
        $fheight = esc_attr( $instance['fheight'] );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :','flag'); ?>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" class="widefat" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>_random">
			<input id="<?php echo $this->get_field_id('type'); ?>_random" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="random" <?php checked("random" , $instance['type']); ?> /> <?php _e('random','flag'); ?>
			</label>
            <label for="<?php echo $this->get_field_id('type'); ?>_first">
            <input id="<?php echo $this->get_field_id('type'); ?>_first" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="recent" <?php checked("recent" , $instance['type']); ?> /> <?php _e('first in album','flag'); ?>
			</label>
		</p>

		<p>
			<?php _e('Width x Height of thumbs:','flag'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /> (px)
		</p>

		<p>
			<?php _e('Width x Height of popup:','flag'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('fwidth'); ?>" name="<?php echo $this->get_field_name('fwidth'); ?>" type="text" value="<?php echo $fwidth; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('fheight'); ?>" name="<?php echo $this->get_field_name('fheight'); ?>" type="text" value="<?php echo $fheight; ?>" /> (px)
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('album'); ?>"><?php _e('Select Album:','flag'); ?>
			<select id="<?php echo $this->get_field_id('album'); ?>" name="<?php echo $this->get_field_name('album'); ?>" class="widefat">
				<option value="" ><?php _e('Choose album','flag'); ?></option>
			<?php
				$albumlist = $flagdb->find_all_albums();
				if(is_array($albumlist)) {
					foreach($albumlist as $album) { ?>
						<option <?php selected( $album->id , $instance['album']); ?> value="<?php echo $album->id; ?>"><?php echo $album->name; ?></option>
					<?php }
				}
			?>
			</select>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('skin'); ?>"><?php _e('Select Skin:', 'flag'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('skin'); ?>" id="<?php echo $this->get_field_id('skin'); ?>" class="widefat">
<?php
				if($all_skins) {
					foreach ( (array)$all_skins as $skin_file => $skin_data) {
						echo '<option value="'.dirname($skin_file).'"';
						if (dirname($skin_file) == $instance['skin']) echo ' selected="selected"';
						echo '>'.$skin_data['Name'].'</option>'."\n";
					}
				}
?>
				</select>
		</p>

	<?php

	}

	function widget( $args, $instance ) {
		global $wpdb, $flagdb;

		extract( $args );

        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);

		$album = $instance['album'];

       	$gallerylist = $flagdb->get_album($album);
        $ids = explode( ',', $gallerylist );
		$gids = str_replace(',','_',$gallerylist);
   		foreach ($ids as $id) {
			if ( $instance['type'] == 'random' )
				$imageList[$id] = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 AND t.gid = {$id} ORDER by rand() LIMIT 1");
			else
				$imageList[$id] = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 AND t.gid = {$id} ORDER by tt.sortorder ASC LIMIT 1");
   		}
		echo $before_widget . $before_title . $title . $after_title;
		echo "\n" . '<div class="flag-widget">'. "\n";

		if (is_array($imageList)){
			foreach($imageList as $key => $image) {
				// get the URL constructor
				$image = new flagImage($image[0]);

				// get the effect code
				$thumbcode = 'class="flag_fancybox"';

				// enable i18n support for alttext and description
				$alttext      =  strip_tags( htmlspecialchars( stripslashes( flagGallery::i18n($image->alttext, 'pic_' . $image->pid . '_alttext') )) );
				$description  =  strip_tags( htmlspecialchars( stripslashes( flagGallery::i18n($image->description, 'pic_' . $image->pid . '_description') )) );

				//TODO:For mixed portrait/landscape it's better to use only the height setting, if widht is 0 or vice versa
				$out = '<a href="'.home_url().'/wp-content/plugins/flash-album-gallery/facebook.php?i='.$image->galleryid.'&amp;f='.$instance['skin'].'&amp;h='.$instance['fheight'].'" title="' . $image->title . '" ' . $thumbcode .'>';
				$out .= '<img src="'.$image->thumbURL.'" width="'.$instance['width'].'" height="'.$instance['height'].'" title="'.$alttext.'" alt="'.$description.'" />';
				echo $out . '</a>'."\n";

			}
		}

		echo '</div>'."\n";
		echo '<style type="text/css">.flag_fancybox img { border: 1px solid #A9A9A9; margin: 0 2px 2px 0; padding: 1px; }</style>'."\n";
		echo '<script type="text/javascript">var fbVar = "'.FLAG_URLPATH.'"; var fbW = '.$instance['fwidth'].', fbH = '.$instance['fheight'].'; waitJQ(fbVar,fbW,fbH);</script>'."\n";
		echo $after_widget;

	}

}// end widget class

// register it
add_action('widgets_init', create_function('', 'return register_widget("flagWidget");'));

/**
 * flagVideoWidget - The widget control for GRAND FlAGallery
 *
 * @package GRAND FlAGallery
 * @access public
 */
class flagVideoWidget extends WP_Widget {

   	function flagVideoWidget() {
		$widget_ops = array('classname' => 'flag_video', 'description' => __( 'Add recent or random video from the galleries', 'flag') );
		$this->WP_Widget('flag-video', __('FLAGallery Video Widget', 'flag'), $widget_ops);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']	= strip_tags($new_instance['title']);
		$instance['width']	= (int) $new_instance['width'];
		$instance['height']	= (int) $new_instance['height'];
		$instance['fwidth']	= (int) $new_instance['fwidth'];
		$instance['fheight']	= (int) $new_instance['fheight'];
		$instance['vxml']	= $new_instance['vxml'];

		return $instance;
	}

	function form( $instance ) {
		global $wpdb, $flagdb;

		require_once (dirname( dirname(__FILE__) ) . '/admin/video.functions.php');

		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
            'title' => 'Videos',
            'width' => '75',
            'height'=> '65',
            'fwidth' => '640',
            'fheight'=> '480',
            'vxml' =>  '' ) );
		$title  = esc_attr( $instance['title'] );
		$width  = esc_attr( $instance['width'] );
        $height = esc_attr( $instance['height'] );
		$fwidth  = esc_attr( $instance['fwidth'] );
        $fheight = esc_attr( $instance['fheight'] );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :','flag'); ?>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" class="widefat" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<?php _e('Width x Height of thumbs:','flag'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /> (px)
		</p>

		<p>
			<?php _e('Width x Height of popup:','flag'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('fwidth'); ?>" name="<?php echo $this->get_field_name('fwidth'); ?>" type="text" value="<?php echo $fwidth; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('fheight'); ?>" name="<?php echo $this->get_field_name('fheight'); ?>" type="text" value="<?php echo $fheight; ?>" /> (px)
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('vxml'); ?>"><?php _e('Select Playlist:','flag'); ?>
			<select id="<?php echo $this->get_field_id('vxml'); ?>" name="<?php echo $this->get_field_name('vxml'); ?>" class="widefat">
				<option value="" ><?php _e('Choose playlist','flag'); ?></option>
			<?php
				$all_playlists = get_v_playlists();
				if(is_array($all_playlists)) {
					foreach((array)$all_playlists as $playlist_file => $playlist_data) {
						$playlist_name = basename($playlist_file, '.xml');
				?>
					<option<?php if ($playlist_name == $instance['vxml']) echo ' selected="selected"'; ?> value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
				<?php
					}
				}
			?>
			</select>
			</label>
		</p>

	<?php

	}

	function widget( $args, $instance ) {
		global $wpdb, $flagdb;

		extract( $args );

		require_once (dirname( dirname(__FILE__) ) . '/admin/video.functions.php');
		$flag_options = get_option('flag_options');
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);

		echo $before_widget . $before_title . $title . $after_title;

		$playlistPath = $flag_options['galleryPath'].'playlists/video/'.$instance['vxml'].'.xml';
		if(file_exists($playlistPath)) {
			$playlist = get_v_playlist_data(ABSPATH.$playlistPath);
			$items_a = $playlist['items'];

			echo "\n" . '<div class="flag-widget">'. "\n";

			if (count($items_a)){
				foreach($items_a as $item) {
					$flv = get_post($item);
					if($flv->ID) {
				        $thumb = $flvthumb = get_post_meta($item, 'thumbnail', true);
				        if(empty($thumb)) {
				          $thumb = site_url().'/wp-includes/images/crystal/video.png';
				          $flvthumb = '';
				        }
						$url = wp_get_attachment_url($flv->ID);

						// get the effect code
						$thumbcode = 'class="flag_fancyvid"';

						// enable i18n support for alttext and description
						$alttext      =  strip_tags( htmlspecialchars( stripslashes( $flv->post_title )) );
						$description  =  strip_tags( htmlspecialchars( stripslashes( $flv->post_content )) );

						//TODO:For mixed portrait/landscape it's better to use only the height setting, if widht is 0 or vice versa
						$out = '<a href="'.home_url().'/wp-content/plugins/flash-album-gallery/facebook.php?mv='.$flv->ID.'&amp;w=1&amp;h='.$instance['fheight'].'" title="' . $alttext . '" ' . $thumbcode .'>';
						$out .= '<img src="'.$thumb.'" width="'.$instance['width'].'" height="'.$instance['height'].'" title="'.$alttext.'" alt="'.$description.'" />';
						echo $out . '</a>'."\n";
					}
				}
			}

		} else {
			echo '<p>'.__('Error! No playlist.','flag').'</p>';
		}

		echo '</div>'."\n";
		echo '<style type="text/css">.flag_fancyvid img { border: 1px solid #A9A9A9; margin: 0 2px 2px 0; padding: 1px; }</style>'."\n";
		echo '<script type="text/javascript">var fvVar = "'.FLAG_URLPATH.'"; var fvW = '.$instance['fwidth'].', fvH = '.$instance['fheight'].'; waitJQv(fvVar,fvW,fvH);</script>'."\n";
		echo $after_widget;
	}

}// end widget class

// register it
add_action('widgets_init', create_function('', 'return register_widget("flagVideoWidget");'));


/**
 * flagMusicWidget - The widget control for GRAND FlAGallery
 *
 * @package GRAND FlAGallery
 * @access public
 */
class flagMusicWidget extends WP_Widget {

	function flagMusicWidget() {
		$widget_ops = array('classname' => 'widget_music', 'description' => __( 'Show a GRAND FlAGallery Music Player', 'flag') );
		$this->WP_Widget('flag-music', __('FLAGallery Music', 'flag'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Music', 'flag') : $instance['title'], $instance, $this->id_base);

		$out = $this->render_music($instance['xml'], $instance['width'], $instance['height'], $instance['skin']);

		if ( !empty( $out ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="flag_banner widget">
			<?php echo $out; ?>
		</div>
		<?php
			echo $after_widget;
		}

	}

	function render_music($xml, $w = '100%', $h = '200', $skin = '') {
        $out = do_shortcode('[grandmusic playlist='.$xml.' w='.$w.' h='.$h.' skin='.$skin.' is_widget=1]');
		return $out;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['xml'] = $new_instance['xml'];
		$instance['height'] = (int) $new_instance['height'];
		$instance['width'] = $new_instance['width'];
		$instance['skin'] = $new_instance['skin'];

		return $instance;
	}

	function form( $instance ) {

		global $wpdb;

		require_once (dirname( dirname(__FILE__) ) . '/admin/get_skin.php');
		require_once (dirname( dirname(__FILE__) ) . '/admin/playlist.functions.php');

		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Music', 'xml' => '', 'width' => '100%', 'height' => '200', 'skin' => 'music_default') );
		$title  = esc_attr( $instance['title'] );
		$width  = esc_attr( $instance['width'] );
		$height = esc_attr( $instance['height'] );
		$skin  = esc_attr( $instance['skin'] );
		$all_playlists = get_playlists();
		$all_skins = get_skins(false,'m');
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('xml'); ?>"><?php _e('Select playlist:', 'flag'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('xml'); ?>" id="<?php echo $this->get_field_id('xml'); ?>" class="widefat">
<?php
	foreach((array)$all_playlists as $playlist_file => $playlist_data) {
		$playlist_name = basename($playlist_file, '.xml');
?>
					<option <?php selected($playlist_name , $instance['xml']); ?> value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
<?php
	}
?>
				</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'flag'); ?></label> <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $height; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'flag'); ?></label> <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $width; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('skin'); ?>"><?php _e('Select Skin:', 'flag'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('skin'); ?>" id="<?php echo $this->get_field_id('skin'); ?>" class="widefat">
<?php
				if($all_skins) {
					foreach ( (array)$all_skins as $skin_file => $skin_data) {
						echo '<option value="'.dirname($skin_file).'"';
						if (dirname($skin_file) == $instance['skin']) echo ' selected="selected"';
						echo '>'.$skin_data['Name'].'</option>'."\n";
					}
				}
?>
				</select>
		</p>
<?php
	}

}

// register it
add_action('widgets_init', create_function('', 'return register_widget("flagMusicWidget");'));

function flagMusicWidget($xml, $w = '100%', $h = '200', $skin = 'default') {

	echo flagMusicWidget::render_music($xml, $w, $h, $skin);

}


?>