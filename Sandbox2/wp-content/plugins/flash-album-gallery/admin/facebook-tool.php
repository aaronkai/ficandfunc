<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 	die('You are not allowed to call this page directly.'); }

// check for correct capability
if ( !is_user_logged_in() )
	die('-1');

// check for correct FlAG capability
if ( !current_user_can('FlAG Facebook page') ) 
	die('-1');	

if(isset($_POST['copy_file'])) {
	if(copy(FLAG_ABSPATH.'facebook.php',ABSPATH.'facebook.php')) {
		flagGallery::show_message(__('Success','flag'));
	} else {
		flagGallery::show_error(__('Failure','flag'));
	}
}
global $flagdb;
require_once (dirname(__FILE__) . '/get_skin.php');
require_once (dirname(__FILE__) . '/playlist.functions.php');
require_once (dirname(__FILE__) . '/video.functions.php');
require_once (dirname(__FILE__) . '/banner.functions.php');
$i_skins = get_skins();
$all_m_playlists = get_playlists();
$all_v_playlists = get_v_playlists();
$all_b_playlists = get_b_playlists();
$fb_url = FLAG_URLPATH.'facebook.php';
if(file_exists(ABSPATH.'facebook.php')) {
	$fb_url = home_url().'/facebook.php';
}
?>
<script type="text/javascript">/*<![CDATA[*/
var url = '<?php echo $fb_url; ?>';
jQuery(document).ready(function() {
	jQuery('#galleries input[value="all"]').attr('checked','checked').parent().siblings('.row').find('input').removeAttr('checked');
	jQuery('#items_array').val('all');
	var galleries = '?i='+jQuery('#items_array').val().split(',').join('_');
	var skin = jQuery('#skinname option:selected').val();
	if(skin) skin = '&f='+skin; else skin = '';
	var h = parseInt(jQuery('#galleryheight').val());
	if(h) h = '&h='+h; else h = '';
	var l = parseInt(jQuery('#postid').val());
	if(l) l = '&l='+l; else l = '';
	fb_url(galleries,skin,h,l);
	jQuery('#galleries :checkbox').click(function(){
		if(jQuery(this).is(':checked')){
			var cur = jQuery(this).val();
			if(cur == 'all') {
				jQuery(this).parent().siblings('.row').find('input').removeAttr('checked');
				jQuery('#items_array').val(cur);
			} else {
				jQuery('#galleries input[value="all"]').removeAttr('checked');
				var arr = jQuery('#items_array').val();
				if(arr && arr != 'all') { var del = ','; } else { arr = ''; var del = ''; }
				jQuery('#items_array').val(arr+del+cur);
			}
		} else {
			var cur = jQuery(this).val();
			var arr = jQuery('#items_array').val().split(',');
			arr = jQuery.grep(arr, function(a){ return a != cur; }).join(',');
			if(arr) {
				jQuery('#items_array').val(arr);
			} else {
				jQuery('#galleries input[value="all"]').attr('checked','checked');
				jQuery('#items_array').val('all');
			}
		}
		galleries = '?i='+jQuery('#items_array').val().split(',').join('_');
		skin = jQuery('#skinname option:selected').val(); if(skin) skin = '&f='+skin; else skin = '';
		h = parseInt(jQuery('#galleryheight').val()); if(h) h = '&h='+h; else h = '';
		l = parseInt(jQuery('#postid').val()); if(l) l = '&l='+l; else l = '';
		fb_url(galleries,skin,h,l);
	});
	jQuery('#skinname').change(function(){
		var skin = jQuery(this).val();
		if(skin) {
			skin = '&f='+skin;
		} else {
			skin = '';
		}
		galleries = '?i='+jQuery('#items_array').val().split(',').join('_');
		h = parseInt(jQuery('#galleryheight').val()); if(h) h = '&h='+h; else h = '';
		l = parseInt(jQuery('#postid').val()); if(l) l = '&l='+l; else l = '';
		fb_url(galleries,skin,h,l);
	});
	jQuery('#galleryheight').bind('keyup',function(){
		var h = parseInt(jQuery(this).val());
		if(h) {
			h = '&h='+h;
		} else {
			h = '';
		}
		galleries = '?i='+jQuery('#items_array').val().split(',').join('_');
		skin = jQuery('#skinname option:selected').val(); if(skin) skin = '&f='+skin; else skin = '';
		l = parseInt(jQuery('#postid').val()); if(l) l = '&l='+l; else l = '';
		fb_url(galleries,skin,h,l);
	});
	jQuery('#postid').bind('keyup',function(){
		var l = parseInt(jQuery(this).val());
		if(l) {
			l = '&l='+l;
		} else {
			l = '';
		}
		galleries = '?i='+jQuery('#items_array').val().split(',').join('_');
		skin = jQuery('#skinname option:selected').val(); if(skin) skin = '&f='+skin; else skin = '';
		h = parseInt(jQuery('#galleryheight').val()); if(h) h = '&h='+h; else h = '';
		fb_url(galleries,skin,h,l);
	});
	jQuery('#m_playlist').change(function(){
		var playlist = jQuery(this).val();
		if(playlist) {
			playlist = '?m='+playlist;
		} else {
			playlist = '?m=';
		}
		jQuery('#fb2_url0').val(url+playlist);
	});
	jQuery('#v_playlist').change(function(){
		var playlist = jQuery(this).val();
		if(playlist) {
			playlist = '?v='+playlist;
		} else {
			playlist = '?v=';
		}
		jQuery('#fb3_url0').val(url+playlist);
	});
	jQuery('#b_playlist').change(function(){
		var playlist = jQuery(this).val();
		if(playlist) {
			playlist = '?b='+playlist;
		} else {
			playlist = '?b=';
		}
		jQuery('#fb4_url0').val(url+playlist);
	});
});
function fb_url(galleries,skin,h,l) {
	jQuery('#fb1_url0').val(url+galleries+skin+h+l);
}
/*]]>*/</script>
<div class="wrap">
<h2><?php _e('Facebook Integration', 'flag'); ?></h2>
<p>1. Log in to your <a target="_blank" href="http://www.facebook.com">Facebook</a> account.</p>
<p>2. Search for the <a href="http://apps.facebook.com/117531781690494/?ref=ts">Page Tabs: Static HTML + iFrame</a> tabs application and select it.</p>
<p>3. Click on <strong>Add Static HTML to a page</strong> button and you'll be prompted for the page where you want the app to be added.</p>
<p>4. Once added you'll see on the left side menu of your page a new tab with a star icon called Welcome. Click on it to edit it.</p>
<p>5. Add the <strong>Facebook Page Url</strong> in the text field.</p>
<p>6. Click <strong>preview</strong> to see how it looks or <strong>save changes</strong>. The product is now added to the Welcome tab of your page.</p>
<p>7. <strong>Optional:</strong> To change the tab's name, called by default <strong>Welcome</strong>, edit your page, go to the <strong>Apps</strong> tab and click <strong>Edit Settings</strong> option next to the <strong>Page Tabs: Static HTML + iFrame</strong> application to enter the name you want.</p>
<p>8. <strong>Optional:</strong> To make the tab your default landing tab (first thing your visitors see on your page) edit your page and go to the <strong>Manage Permissions</strong> tab and change the <strong>Default Landing Tab</strong>.</p>
<br /><br />
<form id="facebook_copy" name="facebook_copy" method="POST" class="alignright">
	<p>Optional: &nbsp; <input type="submit" name="copy_file" class="button-primary" value="<?php _e('Copy facebook.php file to root directory', 'flag'); ?>" /><br />
	(makes Facebook page url shorter)</p>
</form>
<form id="generator1"><fieldset style="clear:both; margin:0 0 20px 0; padding: 20px; border: 1px solid #888888;"><legend style="font-size: 18px; padding: 0 5px;"><?php _e("Photo Gallery Facebook Page Generator", 'flag'); ?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
        <tr>
           <td nowrap="nowrap" valign="top"><div><?php _e("Select galleries", 'flag'); ?>:<span style="color:red;"> *</span><br /><small><?php _e("(album categories)", 'flag'); ?></small></div></td>
           <td valign="top"><div id="galleries" style="width: 214px; height: 160px; overflow: auto;">
                   <div class="row"><input type="checkbox" value="all" checked="checked" /> <strong>* - <?php _e("all galleries", 'flag'); ?></strong></div>
			<?php
				$gallerylist = $flagdb->find_all_galleries('gid', 'ASC');
				if(is_array($gallerylist)) {
					foreach($gallerylist as $gallery) {
						$name = ( empty($gallery->title) ) ? $gallery->name : $gallery->title;
						echo '<div class="row"><input type="checkbox" value="' . $gallery->gid . '" /> <span>' . $gallery->gid . ' - ' . $name . '</span></div>' . "\n";
					}
				}
			?>
           </div></td>
        </tr>
        <tr>
           <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><?php _e("Galleries order", 'flag'); ?>: &nbsp; </p></td>
           <td valign="top"><p><input readonly="readonly" type="text" id="items_array" value="all" style="width: 214px;" /></p></td>
        </tr>
        <tr>
            <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><label for="skinname"><?php _e("Choose skin", 'flag'); ?>:</label></p></td>
            <td valign="top"><p><select id="skinname" name="skinname" style="width: 214px;">
                    <option value="" selected="selected"><?php _e("skin active by default", 'flag'); ?></option>
<?php
	foreach ( (array)$i_skins as $skin_file => $skin_data) {
		echo '<option value="'.dirname($skin_file).'">'.$skin_data['Name'].'</option>'."\n";
	}
?>
            </select></p></td>
        </tr>
		<tr>
			<td valign="top"><p style="padding-top:3px;"><?php _e("Skin size", 'flag'); ?>:<br /><span style="font-size:9px">(<?php _e("blank for default", 'flag'); ?>)</span></p></td>
            <td valign="top"><p><?php _e("width", 'flag'); ?>: <input id="gallerywidth" type="text" disabled="disabled" style="width: 50px" value="100%" /> &nbsp; <?php _e("height", 'flag'); ?>: <input id="galleryheight" type="text" style="width: 50px" /></p></td>
		</tr>
        <tr>
            <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><?php _e("Post ID", 'flag'); ?>:<br /><span style="font-size:9px">(<?php _e("optional", 'flag'); ?>)</span></p></td>
            <td valign="top"><p><input id="postid" type="text" /></p></td>
        </tr>
		<tr>
			<td valign="top"><div style="padding-top:3px;"><strong><?php _e("Facebook Page Url", 'flag'); ?>: &nbsp; </strong></div></td>
            <td valign="top"><input id="fb1_url0" type="text" style="width: 780px; font-size: 10px;" value="<?php echo $fb_url.'?i=all'; ?>" /></td>
		</tr>
    </table>
</fieldset></form>
<form id="generator2"><fieldset style="padding: 20px; margin:0 0 20px 0; border: 1px solid #888888;"><legend style="font-size: 18px; padding: 0 5px;"><?php _e("mp3 Gallery Facebook Page Generator", 'flag'); ?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><label><?php _e("Choose playlist", 'flag'); ?>:</label></p></td>
            <td valign="top"><p><select id="m_playlist" style="width: 214px;">
					<option value="" selected="selected"><?php _e('Choose playlist', 'flag'); ?></option>
				<?php 
					foreach((array)$all_m_playlists as $playlist_file => $playlist_data) {
						$playlist_name = basename($playlist_file, '.xml');
				?>
					<option value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
				<?php 
					}
				?>
            </select></p></td>
        </tr>
		<tr>
			<td valign="top"><div style="padding-top:3px;"><strong><?php _e("Facebook Page Url", 'flag'); ?>: &nbsp; </strong></div></td>
            <td valign="top"><input id="fb2_url0" type="text" style="width: 600px; font-size: 10px;" value="<?php echo $fb_url.'?m='; ?>" /></td>
		</tr>
    </table>
</fieldset></form>
<form id="generator3"><fieldset style="padding: 20px; margin:0 0 20px 0; border: 1px solid #888888;"><legend style="font-size: 18px; padding: 0 5px;"><?php _e("Video Blog Gallery Facebook Page Generator", 'flag'); ?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><label><?php _e("Choose playlist", 'flag'); ?>:</label></p></td>
            <td valign="top"><p><select id="v_playlist" style="width: 214px;">
					<option value="" selected="selected"><?php _e('Choose playlist', 'flag'); ?></option>
				<?php 
					foreach((array)$all_v_playlists as $playlist_file => $playlist_data) {
						$playlist_name = basename($playlist_file, '.xml');
				?>
					<option value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
				<?php 
					}
				?>
            </select></p></td>
        </tr>
		<tr>
			<td valign="top"><div style="padding-top:3px;"><strong><?php _e("Facebook Page Url", 'flag'); ?>: &nbsp; </strong></div></td>
            <td valign="top"><input id="fb3_url0" type="text" style="width: 600px; font-size: 10px;" value="<?php echo $fb_url.'?v='; ?>" /></td>
		</tr>
    </table>
</fieldset></form>
<form id="generator4"><fieldset style="padding: 20px; margin:0 0 20px 0; border: 1px solid #888888;"><legend style="font-size: 18px; padding: 0 5px;"><?php _e("Banner Box Facebook Page Generator", 'flag'); ?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td nowrap="nowrap" valign="top"><p style="padding-top:3px;"><label><?php _e("Choose xml", 'flag'); ?>:</label></p></td>
            <td valign="top"><p><select id="b_playlist" style="width: 214px;">
					<option value="" selected="selected"><?php _e('Choose XML', 'flag'); ?></option>
				<?php 
					foreach((array)$all_b_playlists as $playlist_file => $playlist_data) {
						$playlist_name = basename($playlist_file, '.xml');
				?>
					<option value="<?php echo $playlist_name; ?>"><?php echo $playlist_data['title']; ?></option>
				<?php 
					}
				?>
            </select></p></td>
        </tr>
		<tr>
			<td valign="top"><div style="padding-top:3px;"><strong><?php _e("Facebook Page Url", 'flag'); ?>: &nbsp; </strong></div></td>
            <td valign="top"><input id="fb4_url0" type="text" style="width: 600px; font-size: 10px;" value="<?php echo $fb_url.'?b='; ?>" /></td>
		</tr>
    </table>
</fieldset></form>
</div>
<?php

?>