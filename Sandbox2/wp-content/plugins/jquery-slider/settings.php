<?php

// Adding options page
function js_menu() {
	add_options_page('jQuery Slider','jQuery Slider','manage_options','js_options','js_options');
}
add_action('admin_menu', 'js_menu');

function js_options(){
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<form action="options.php" method="post">
	  <div class="wrap">
		<?php wp_nonce_field('update-options') ?>
		  <h2>jQuery Slider Settings</h2>
		  <table border="0" cellspacing="6" cellpadding="6">
			<tr>
			  <td>Width</td>
			  <td><input name="js_width" type="text" id="js_width" value="<?php echo get_option('js_width'); ?>" size="5" />px</td>
			</tr>
			<tr>
			  <td>Height</td>
			  <td><input name="js_height" type="text" id="js_height" value="<?php echo get_option('js_height'); ?>" size="5" />px</td>
			</tr>
			<tr>
			  <td>Pause on hover</td>
			  <td>
			  <select name="js_pause" id="js_pause">
				<option value="true" <?php if(get_option('js_pause')) echo "selected" ?>>Yes</option>
				<option value="false" <?php if(!get_option('js_pause')) echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Show pagination</td>
			  <td>
			  <select name="js_paging" id="js_paging">
				<option value="true" <?php if(get_option('js_pause')) echo "selected" ?>>Yes</option>
				<option value="false" <?php if(!get_option('js_pause')) echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Show navigation</td>
			  <td>
			  <select name="js_nav" id="js_nav">
				<option value="true" <?php if(get_option('js_pause')) echo "selected" ?>>Yes</option>
				<option value="false" <?php if(!get_option('js_pause')) echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><span class="submit">
			  <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="js_width,js_height,js_pause,js_paging,js_nav" />
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			  </span></td>
			</tr>
		  </table>
		</div>
	</form>
	<?php
}