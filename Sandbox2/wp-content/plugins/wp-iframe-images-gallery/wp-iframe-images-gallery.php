<?php

/*
Plugin Name: iFrame Images Gallery
Plugin URI: http://www.gopiplus.com/work/2011/07/24/wordpress-plugin-wp-iframe-images-gallery/
Description: iframe images gallery is a simple wordpress plugin to create horizontal image slideshow. Horizontal bar will be display below the images to scroll.
Author: Gopi.R
Version: 4.0
Author URI: http://www.gopiplus.com/work/2011/07/24/wordpress-plugin-wp-iframe-images-gallery/
Donate link: http://www.gopiplus.com/work/2011/07/24/wordpress-plugin-wp-iframe-images-gallery/
*/

/**
 *     iFrame Images Gallery
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

global $wpdb, $wp_version;
define("WP_iframe_TABLE", $wpdb->prefix . "iframe_plugin");

function iframe_Images_Gallery($string) 
{
	
	echo $string;
	$img = "";
	$iframe_random  = "";
	
	if(!is_numeric(@$iframe_width)) { @$iframe_width = 600 ;}
	if(!is_numeric(@$iframe_height)) { @$iframe_height = 300; }
	
	$sSql = "select iframe_path,iframe_link,iframe_target,iframe_title from ".WP_iframe_TABLE." where 1=1";
	if($iframe_type <> ""){ $sSql = $sSql . " and iframe_type='".$iframe_type."'"; }
	if(@$iframe_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY iframe_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	$iframe_count = 0;
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$img = $img. '<td>';
			if($data->iframe_link <> "") { $img = $img. '<a href="'.$data->iframe_link.'" target="'.$data->iframe_target.'">'; }
			$img = $img. '<img border="0" alt="'.$data->iframe_title.'" src="'.$data->iframe_path.'" />';
			if($data->iframe_link <> "") { $img = $img. '</a>'; }
			$img = $img. '</td>';
			//$img = $img. '<td></td>';
			$iframe_count++;
		}
	}	
	?>
    <div>
    <div style="height: <?php echo $iframe_height; ?>px;margin: 20px auto 8px;right: auto;vertical-align: middle;width: <?php echo $iframe_width; ?>px;">
    <div style="height: 100px;margin: 0 auto;padding: 0;">
    <div style="height: <?php echo $iframe_height; ?>px;overflow: auto;width: 100%;">
    <table cellspacing="0" cellpadding="0" border="0"><tbody><tr><?php echo $img; ?></tr></tbody></table>
    </div>
    </div>
    </div>
    </div>
<?php


}

function iframe_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_iframe_TABLE . "'") != WP_iframe_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_iframe_TABLE . "` (";
		$sSql = $sSql . "`iframe_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`iframe_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`iframe_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`iframe_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_title` VARCHAR( 500 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_order` INT NOT NULL ,";
		$sSql = $sSql . "`iframe_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_extra1` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`iframe_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `iframe_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_iframe_TABLE . "` (`iframe_path`, `iframe_link`, `iframe_target` , `iframe_title` , `iframe_order` , `iframe_status` , `iframe_type` , `iframe_date`)"; 
		for($i=1; $i<=4; $i++)
		{
			$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_$i.jpg', '#', '_blank', 'Enter alt text here', '$i', 'YES', 'Group1', '0000-00-00 00:00:00');";
			$wpdb->query($sSql);
		}
	}
}

function iframe_admin_options() 
{
	?>
<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=wp-iframe-images-gallery/wp-iframe-images-gallery.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['iframe_path']) <>"")
    {
			if(@$_POST['iframe_id'] == "" )
			{
					$sql = "insert into ".WP_iframe_TABLE.""
					. " set `iframe_path` = '" . mysql_real_escape_string(trim($_POST['iframe_path']))
					. "', `iframe_link` = '" . mysql_real_escape_string(trim($_POST['iframe_link']))
					. "', `iframe_target` = '" . mysql_real_escape_string(trim($_POST['iframe_target']))
					. "', `iframe_title` = '" . mysql_real_escape_string(trim($_POST['iframe_title']))
					. "', `iframe_order` = '" . mysql_real_escape_string(trim($_POST['iframe_order']))
					. "', `iframe_type` = '" . mysql_real_escape_string(trim($_POST['iframe_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_iframe_TABLE.""
					. " set `iframe_path` = '" . mysql_real_escape_string(trim($_POST['iframe_path']))
					. "', `iframe_link` = '" . mysql_real_escape_string(trim($_POST['iframe_link']))
					. "', `iframe_target` = '" . mysql_real_escape_string(trim($_POST['iframe_target']))
					. "', `iframe_title` = '" . mysql_real_escape_string(trim($_POST['iframe_title']))
					. "', `iframe_order` = '" . mysql_real_escape_string(trim($_POST['iframe_order']))
					. "', `iframe_type` = '" . mysql_real_escape_string(trim($_POST['iframe_type']))
					. "' where `iframe_id` = '" . $_POST['iframe_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_iframe_TABLE." where iframe_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_iframe_TABLE." where iframe_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $iframe_id_x = htmlspecialchars(stripslashes($data->iframe_id)); 
		if ( !empty($data) ) $iframe_path_x = htmlspecialchars(stripslashes($data->iframe_path)); 
        if ( !empty($data) ) $iframe_link_x = htmlspecialchars(stripslashes($data->iframe_link));
		if ( !empty($data) ) $iframe_target_x = htmlspecialchars(stripslashes($data->iframe_target));
        if ( !empty($data) ) $iframe_title_x = htmlspecialchars(stripslashes($data->iframe_title));
		if ( !empty($data) ) $iframe_order_x = htmlspecialchars(stripslashes($data->iframe_order));
		if ( !empty($data) ) $iframe_status_x = htmlspecialchars(stripslashes($data->iframe_status));
		if ( !empty($data) ) $iframe_type_x = htmlspecialchars(stripslashes($data->iframe_type));
        $submittext = "Update Message";
    }
    ?>
  <h2>iFrame Images Gallery</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-iframe-images-gallery/setting.js"></script>
  <form name="iframe_form" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return iframe_submit()"  >
    <table width="100%">
      <tr>
        <td align="left" valign="middle">Enter Image URL:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="iframe_path" type="text" id="iframe_path" value="<?php echo @$iframe_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Target Link:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="iframe_link" type="text" id="iframe_link" value="<?php echo @$iframe_link_x; ?>" size="125" />
          Use # if no link.</td>
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Image Alt Text:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="iframe_title" type="text" id="iframe_title" value="<?php echo @$iframe_title_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Target Option:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><select name="iframe_target" id="iframe_target">
            <option value='_self' <?php if(@$iframe_target_x=='_self') { echo 'selected' ; } ?>>_self</option>
            <option value='_blank' <?php if(@$iframe_target_x=='_blank') { echo 'selected' ; } ?>>_blank</option>
            <option value='_parent' <?php if(@$iframe_target_x=='_parent') { echo 'selected' ; } ?>>_parent</option>
          </select>
      </tr>
      <tr>
        <td align="left" valign="middle">Select Gallery Group:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><select name="iframe_type" id="iframe_type">
            <option value='Group1' <?php if(@$iframe_type_x=='Group1') { echo 'selected' ; } ?>>Group1</option>
            <option value='Group2' <?php if(@$iframe_type_x=='Group2') { echo 'selected' ; } ?>>Group2</option>
            <option value='Group3' <?php if(@$iframe_type_x=='Group3') { echo 'selected' ; } ?>>Group3</option>
            <option value='Group4' <?php if(@$iframe_type_x=='Group4') { echo 'selected' ; } ?>>Group4</option>
            <option value='Group5' <?php if(@$iframe_type_x=='Group5') { echo 'selected' ; } ?>>Group5</option>
            <option value='Group6' <?php if(@$iframe_type_x=='Group6') { echo 'selected' ; } ?>>Group6</option>
            <option value='Group7' <?php if(@$iframe_type_x=='Group7') { echo 'selected' ; } ?>>Group7</option>
            <option value='Group8' <?php if(@$iframe_type_x=='Group8') { echo 'selected' ; } ?>>Group8</option>
            <option value='Group9' <?php if(@$iframe_type_x=='Group9') { echo 'selected' ; } ?>>Group9</option>
            <option value='Group0' <?php if(@$iframe_type_x=='Group0') { echo 'selected' ; } ?>>Group0</option>
          </select>
          (This is to group the images) </td>
      </tr>
      <tr>
        <td align="left" valign="middle">Image Display Order:</td>
      </tr>
      <tr>
        <td width="78%" align="left" valign="middle"><input name="iframe_order" type="text" id="iframe_order" size="7" value="<?php echo @$iframe_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" align="left" valign="bottom"><table width="100%">
            <tr>
              <td align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="iframe_redirect()" value="Cancel" type="button" />
				<input name="Help" lang="publish" class="button-primary" onclick="iframe_help()" value="Help" type="button" />
				</td>
            </tr>
          </table></td>
      </tr>
      <input name="iframe_id" id="iframe_id" type="hidden" value="<?php echo @$iframe_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_iframe_TABLE." order by iframe_type,iframe_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_iframe_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Group
              </td>
            <th width="66%" align="left" scope="col">Alt Text
              </td>
            <th width="5%" align="left" scope="col">Target
              </td>
            <th width="5%" align="left" scope="col">Order
              </td>
            <th width="8%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->iframe_type)); ?></td>
            <td align="left" valign="middle"><a target="_blank" href="<?php echo(stripslashes($data->iframe_path)); ?>"><?php echo(stripslashes($data->iframe_path)); ?></a></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->iframe_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->iframe_order)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=wp-iframe-images-gallery/wp-iframe-images-gallery.php&DID=<?php echo($data->iframe_id); ?>">Edit</a> &nbsp; <a onClick="javascript:iframe_delete('<?php echo($data->iframe_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
      </table>
    </form>
  </div>
   <br /> Short code : [IFRAMEIMAGES:GROUP=Group1:W=600:H=220] <br />
  
<h2>Plugin configuration</h2>
<ul>
    <li><a href="http://www.gopiplus.com/work/2011/07/24/wordpress-plugin-wp-iframe-images-gallery/" target="_blank">Use the short code in the pages and posts.</a></li>
</ul>
</div>
<?php
}

add_filter('the_content','iframe_Show_Filter');

function iframe_Show_Filter($content)
{
	return 	preg_replace_callback('/\[IFRAMEIMAGES:(.*?)\]/sim','iframe_Show_Filter_Callback',$content);
}

function iframe_Show_Filter_Callback($matches) 
{
	global $wpdb;
	$iframe_random = "";
	$img = "";
	$dreamscape = "";
	$scode = $matches[1];
	//[IFRAMEIMAGES:CATEGORY=Group1:W=600:H=300]
	
	list($iframe_type_main, $iframe_width_main, $iframe_height_main) = split("[:.-]", $scode);

	list($iframe_type_cap, $iframe_type) = split('[=.-]', $iframe_type_main);
	list($iframe_width_cap, $iframe_width) = split('[=.-]', $iframe_width_main);
	list($iframe_height_cap, $iframe_height) = split('[=.-]', $iframe_height_main);

	if(!is_numeric(@$iframe_width)) { @$iframe_width = 600 ;}
	if(!is_numeric(@$iframe_height)) { @$iframe_height = 300; }
	
	$sSql = "select iframe_path,iframe_link,iframe_target,iframe_title from ".WP_iframe_TABLE." where 1=1";
	if($iframe_type <> ""){ $sSql = $sSql . " and iframe_type='".$iframe_type."'"; }
	if($iframe_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY iframe_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	$iframe_count = 0;
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$img = $img. '<td>';
			if($data->iframe_link <> "") { $img = $img. '<a href="'.$data->iframe_link.'" target="'.$data->iframe_target.'">'; }
			$img = $img. '<img border="0" alt="'.$data->iframe_title.'" src="'.$data->iframe_path.'" />';
			if($data->iframe_link <> "") { $img = $img. '</a>'; }
			$img = $img. '</td>';
			//$img = $img. '<td></td>';
			$iframe_count++;
		}
	}	
	
	$dreamscape = $dreamscape. '<div>';
	  $dreamscape = $dreamscape. '<div style="height: '.$iframe_height.'px;margin: 20px auto 8px;right: auto;vertical-align: middle;width: '.$iframe_width.'px;">';
		  $dreamscape = $dreamscape. '<div style="height: 100px;margin: 0 auto;padding: 0;">';
			$dreamscape = $dreamscape. '<div style="height: '.$iframe_height.'px;overflow: auto;width: 100%;">';
			 $dreamscape = $dreamscape. ' <table cellspacing="0" cellpadding="0" border="0">';
				$dreamscape = $dreamscape. '<tbody><tr>';
				  $dreamscape = $dreamscape. $img;
				$dreamscape = $dreamscape. '</tr>';
			  $dreamscape = $dreamscape. '</tbody></table>';
			$dreamscape = $dreamscape. '</div>';
		  $dreamscape = $dreamscape. '</div>';
	  $dreamscape = $dreamscape. '</div>';
	$dreamscape = $dreamscape. '</div>';
	
	return $dreamscape;
}

function iframe_add_to_menu() 
{
	add_options_page('iFrame Images Gallery', 'iFrame Images Gallery', 'manage_options', __FILE__, 'iframe_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'iframe_add_to_menu');
}

function iframe_deactivation()
{
	
}

register_activation_hook(__FILE__, 'iframe_install');
add_action('admin_menu', 'iframe_add_to_menu');
register_deactivation_hook(__FILE__, 'iframe_deactivation');
?>
