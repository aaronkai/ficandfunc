<?php
/*
Plugin Name: Enhanced Admin Bar with Codex Search
Plugin URI: http://dsgnwrks.pro/enhanced-admin-bar-with-codex-search/
Description: This plugin adds convenient search fields to provide easy access to the codex, wpbeginner, and common wp-admin areas via the 3.1 Admin Bar.
Author URI: http://dsgnwrks.pro
Author: DsgnWrks
Donate link: http://j.ustin.co/rYL89n
Stable tag: 2.0.3
Version: 2.0.3
*/


add_action('admin_init', 'dsgnwrks_adminbar_init');
function dsgnwrks_adminbar_init() {

	// Register plugin options
    register_setting('enhanced-admin-bar', 'eab-codex-search-submenu');
    register_setting('enhanced-admin-bar', 'eab-admin-searches');
    register_setting('enhanced-admin-bar', 'eab-wp-forums');
    register_setting('enhanced-admin-bar', 'eab-wp-beginner');
    register_setting('enhanced-admin-bar', 'eab-custom-menu');
    if ( function_exists( 'genesis' ) ) register_setting('enhanced-admin-bar', 'eab-genesis-menu');
    register_setting('enhanced-admin-bar', 'eab-dash-widget');

	// Set default plugin options
    add_option( 'eab-codex-search-submenu', 'yes' );
	add_option( 'eab-admin-searches', 'yes' );
	if ( function_exists( 'genesis' ) ) add_option( 'eab-genesis-menu', 'yes' );

}
add_action('admin_menu', 'dsgnwrks_adminbar_settings');
function dsgnwrks_adminbar_settings() {
    add_options_page('Enhanced Admin Bar Settings', 'Enhanced Admin Bar Settings', 'manage_options', 'eab-importer-settings', 'eab_importer_settings');
}

function eab_importer_settings() { require_once('eab-settings.php'); }


// Enqueue Styles
add_action('wp_enqueue_scripts', 'dsgnwrks_adminbar_search_css');
add_action('admin_enqueue_scripts', 'dsgnwrks_adminbar_search_css');
function dsgnwrks_adminbar_search_css() { 
	wp_enqueue_style('adminbar_search_css', plugins_url('css/adminbar_search.css', __FILE__)); 
	// Adds styles that compensates for a Genesis issue with Admin Bar dropdowns.  As a result, fixes admin bar issues for those using Genesis	?>
	<style type="text/css"> 
		#wpadminbar .quicklinks li:hover ul ul {
		  left: auto;
		}
	</style> 
<?php }

// Add Custom Menu Option
add_action('init', 'dsgnwrks_adminbar_nav');
function dsgnwrks_adminbar_nav() {

    // Add custom menu option if selected
	if ( get_option( 'eab-custom-menu' ) ) {
		register_nav_menus( array(
			'admin_bar_nav' => __( 'Admin Bar Custom Navigation Menu' ),
		) );

	}

}

// Add Custom Menu to the Admin bar
add_action('admin_bar_init', 'dsgnwrks_adminbar_menu_init');
function dsgnwrks_adminbar_menu_init() {
	if (!is_super_admin() || !is_admin_bar_showing() )
		return;
 	add_action( 'admin_bar_menu', 'dsgnwrks_admin_bar_menu', 1000 );
}

function dsgnwrks_admin_bar_menu() {
	global $wp_admin_bar;

	// Add a custom menu option
	if ( $eab_custom_menu = get_option( 'eab-custom-menu' ) ) {
		$menu_name = 'admin_bar_nav';
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

		    $menu_items = wp_get_nav_menu_items( $menu->term_id );
		    if ($menu_items) {
			    $wp_admin_bar->add_menu( array(
			        'id' => 'dsgnwrks-admin-menu-0',
			        'title' => 'Enhanced Admin Bar Custom Menu',
					'href' => '#' ) );
			    foreach ( $menu_items as $menu_item ) {
			        $wp_admin_bar->add_menu( array(
			            'id' => 'dsgnwrks-admin-menu-' . $menu_item->ID,
			            'parent' => 'dsgnwrks-admin-menu-' . $menu_item->menu_item_parent,
			            'title' => $menu_item->title,
			            'href' => $menu_item->url,
			            'meta' => array(
			                'title' => $menu_item->attr_title,
			                'target' => $menu_item->target,
			                'class' => implode( ' ', $menu_item->classes ),
			            ),
			        ) );
			    }
		    }
		}
	}

	$go_button = '<input type="submit" value="Go" class="button dw_search_go"  /></form>';
	$admin_url = get_admin_url();

	$codex_search_submenu = get_option( 'eab-codex-search-submenu' );
	$eab_admin_searches = get_option( 'eab-admin-searches' );
	$eab_wp_forums = get_option( 'eab-wp-forums' );
	$eab_wp_beginner = get_option( 'eab-wp-beginner' );

	if ( is_admin() ) {
		if ( $eab_admin_searches ) {
			dsgnwrks_menu_init( $eab_wp_forums, $eab_wp_beginner, $go_button );
		}
	} else {
		if ( $codex_search_submenu ) {
			dsgnwrks_menu_init( $eab_wp_forums, $eab_wp_beginner, $go_button );
		}
	}

	if ( !is_admin() ) {

		if ( $codex_search_submenu ) {

			$wp_admin_bar->add_menu( array(
			'id' => 'plugins_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( 'Plugins'),
			'href' => admin_url('plugins.php') ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'plugins_stuff',
			'title' => __( '
			<strong style="display:none;">Search Plugins</strong>
			<form method="get" action="'.admin_url('plugin-install.php?tab=search').'"  class="alignleft dw_search" >
			<input type="hidden" name="tab" value="search"/>
			<input type="hidden" name="type" value="term"/>
			<input type="text" placeholder="Search Plugins" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="s" value="' . esc_attr('Search Plugins') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'plugins_stuff',
			'title' => __( 'Upload Plugin' ),
			'href' => admin_url('plugin-install.php?tab=upload') ) );

			$wp_admin_bar->add_menu( array(
			'id' => 'themes_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( 'Themes'),
			'href' => admin_url('themes.php') ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'themes_stuff',
			'title' => __( '
			<strong style="display:none;">Search Themes</strong>
			<form method="get" action="'.admin_url('theme-install.php?tab=search').'"  class="alignleft dw_search" >
			<input type="hidden" name="tab" value="search"/>
			<input type="hidden" name="type" value="term"/>
			<input type="text" placeholder="Search Themes" onblur="this.value=(this.value==\'\') ? \'Search Themes\' : this.value;" onfocus="this.value=(this.value==\'Search Themes\') ? \'\' : this.value;" value="Search Themes" name="s" value="' . esc_attr('Search Themes') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'themes_stuff',
			'title' => __( 'Upload Theme' ),
			'href' => admin_url('theme-install.php?tab=upload') ) );

			$wp_admin_bar->add_menu( array(
			'id' => 'media_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( 'Media'),
			'href' => admin_url('upload.php') ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'media_stuff',
			'title' => __( '
			<strong style="display:none;">Search Media</strong>
			<form method="get" action="'.admin_url('upload.php?tab=search').'"  class="alignleft dw_search" >
			<input type="text" placeholder="Search Media" onblur="this.value=(this.value==\'\') ? \'Search Media\' : this.value;" onfocus="this.value=(this.value==\'Search Media\') ? \'\' : this.value;" value="Search Media" name="s" value="' . esc_attr('Search Media') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'media_stuff',
			'title' => __( 'Upload Media' ),
			'href' => admin_url('media-new.php') ) );

			$wp_admin_bar->add_menu( array(
			'id' => 'user_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( 'Users'),
			'href' => admin_url('users.php') ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'user_stuff',
			'title' => __( '
			<strong style="display:none;">Search Users</strong>
			<form method="get" action="'.admin_url('users.php?tab=search').'"  class="alignleft dw_search" >
			<input type="text" placeholder="Search Users" onblur="this.value=(this.value==\'\') ? \'Search Users\' : this.value;" onfocus="this.value=(this.value==\'Search Users\') ? \'\' : this.value;" value="Search Users" name="s" value="' . esc_attr('Search Users') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'user_stuff',
			'title' => __( 'Add New User' ),
			'href' => admin_url('user-new.php') ) );
		}

	} else {

		if ( $eab_admin_searches ) {

			$wp_admin_bar->add_menu( array(
			'id' => 'plugins_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( '
			<strong style="display:none;">Search Plugins</strong>
			<form method="get" action="'.admin_url('plugin-install.php?tab=search').'"  class="alignleft dw_search" >
			<input type="hidden" name="tab" value="search"/>
			<input type="hidden" name="type" value="term"/>
			<input type="text" placeholder="Search Plugins" onblur="this.value=(this.value==\'\') ? \'Search Plugins\' : this.value;" onfocus="this.value=(this.value==\'Search Plugins\') ? \'\' : this.value;" value="Search Plugins" name="s" value="' . esc_attr('Search Plugins') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'plugins_stuff',
			'title' => __( 'Upload Plugin' ),
			'href' => admin_url('plugin-install.php?tab=upload') ) );

			$wp_admin_bar->add_menu( array(
			'id' => 'themes_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( '
			<strong style="display:none;">Search Themes</strong>
			<form method="get" action="'.admin_url('theme-install.php?tab=search').'"  class="alignleft dw_search" >
			<input type="hidden" name="tab" value="search"/>
			<input type="hidden" name="type" value="term"/>
			<input type="text" placeholder="Search Themes" onblur="this.value=(this.value==\'\') ? \'Search Themes\' : this.value;" onfocus="this.value=(this.value==\'Search Themes\') ? \'\' : this.value;" value="Search Themes" name="s" value="' . esc_attr('Search Themes') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'themes_stuff',
			'title' => __( 'Upload Theme' ),
			'href' => admin_url('theme-install.php?tab=upload') ) );

			$wp_admin_bar->add_menu( array(
			'id' => 'media_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( '
			<strong style="display:none;">Search Media</strong>
			<form method="get" action="'.admin_url('upload.php?tab=search').'"  class="alignleft dw_search" >
			<input type="text" placeholder="Search Media" onblur="this.value=(this.value==\'\') ? \'Search Media\' : this.value;" onfocus="this.value=(this.value==\'Search Media\') ? \'\' : this.value;" value="Search Media" name="s" value="' . esc_attr('Search Media') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'media_stuff',
			'title' => __( 'Upload Media' ),
			'href' => admin_url('media-new.php') ) );		

			$wp_admin_bar->add_menu( array(
			'id' => 'user_stuff',
			'parent' => 'dsgnwrks_help_menu',
			'title' => __( '
			<strong style="display:none;">Search Users</strong>
			<form method="get" action="'.admin_url('users.php?tab=search').'"  class="alignleft dw_search" >
			<input type="text" placeholder="Search Users" onblur="this.value=(this.value==\'\') ? \'Search Users\' : this.value;" onfocus="this.value=(this.value==\'Search Users\') ? \'\' : this.value;" value="Search Users" name="s" value="' . esc_attr('Search Users') . '" class="text dw_search_input" />
			'.$go_button),
			'href' => '#' ) );

			$wp_admin_bar->add_menu( array(
			'parent' => 'user_stuff',
			'title' => __( 'Add New User' ),
			'href' => admin_url('user-new.php') ) );
		}
	}

	$actions = array();
	foreach ( (array) get_post_types( array( 'show_ui' => true ), 'objects' ) as $ptype_obj ) {
		if ( true !== $ptype_obj->show_in_menu || ! current_user_can( $ptype_obj->cap->edit_posts ) )
			continue;

		$actions[ 'post-new.php?post_type=' . $ptype_obj->name ] = array( $ptype_obj->labels->name, $ptype_obj->cap->edit_posts, 'eab-new-' . $ptype_obj->name, $ptype_obj->labels->singular_name, $ptype_obj->name, 'edit.php?post_type=' . $ptype_obj->name );
	}

	if ( empty( $actions ) )
		return;

	foreach ( $actions as $link => $action ) {

		if ( is_admin() ) {
			if ( $eab_admin_searches ) {

				$wp_admin_bar->add_menu( array( 'parent' => 'dsgnwrks_help_menu', 
				'title' => __( '
				<strong style="display:none;">Search '.$action[0].'</strong>
				<form method="get" action="'.admin_url('edit.php').'"  class="alignleft dw_search" >
				<input type="hidden" name="post_status" value="all"/>
				<input type="hidden" name="post_type" value="'.$action[4].'"/>
				<input type="text" placeholder="Search '.$action[0].'" onblur="this.value=(this.value==\'\') ? \'Search '.$action[0].'\' : this.value;" onfocus="this.value=(this.value==\'Search '.$action[0].'\') ? \'\' : this.value;" value="Search '.$action[0].'" name="s" value="' . esc_attr('Search '.$action[0]) . '" class="text dw_search_input" />'.$go_button),
				'href' => '#' ) );
			}
		} else {
			if ( $codex_search_submenu ) {

				$wp_admin_bar->add_menu( array( 
				'parent' => 'dsgnwrks_help_menu', 
				'id' => $action[2], 
				'title' => $action[0], 
				'href' => admin_url($action[5]) ) );


				$wp_admin_bar->add_menu( array( 'parent' => $action[2], 
				'title' => __( '
				<strong style="display:none;">Search '.$action[0].'</strong>
				<form method="get" action="'.admin_url('edit.php').'"  class="alignleft dw_search" >
				<input type="hidden" name="post_status" value="all"/>
				<input type="hidden" name="post_type" value="'.$action[4].'"/>
				<input type="text" placeholder="Search '.$action[0].'" onblur="this.value=(this.value==\'\') ? \'Search '.$action[0].'\' : this.value;" onfocus="this.value=(this.value==\'Search '.$action[0].'\') ? \'\' : this.value;" value="Search '.$action[0].'" name="s" value="' . esc_attr('Search '.$action[0]) . '" class="text dw_search_input" />'.$go_button),
				'href' => '#' ) );

				$wp_admin_bar->add_menu( array( 
				'parent' => $action[2], 
				'title' => 'Add New '.$action[3], 
				'href' => admin_url($link) ) );
			}
		}
	}

	// Only add remaining menu items if we're not in wp-admin.
	if ( is_admin() )
	return;		

	if ( $codex_search_submenu ) {

		$wp_admin_bar->add_menu( array(
		'id' => 'settings_stuff',
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( 'Settings'),
		'href' => admin_url('options-general.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Writing'),
		'href' => admin_url('options-writing.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Reading'),
		'href' => admin_url('options-reading.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Discussion'),
		'href' => admin_url('options-discussion.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Media'),
		'href' => admin_url('options-media.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Privacy'),
		'href' => admin_url('options-privacy.php') ) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'settings_stuff',
		'title' => __( 'Permalinks'),
		'href' => admin_url('options-permalink.php') ) );

	}
}

function dsgnwrks_menu_init( $eab_wp_forums='', $eab_wp_beginner='', $go_button ) {
	global $wp_admin_bar;

	// Add codex and plugin search menu items
	$wp_admin_bar->add_menu( array(
	'id' => 'dsgnwrks_help_menu',
	'title' => __( '
	<strong style="display:none;">Search the Codex</strong>
	<form target="_blank" method="get" action="http://wordpress.org/search/do-search.php" class="alignleft dw_search" >
		<input type="text" onblur="this.value=(this.value==\'\') ? \'Search the Codex\' : this.value;" onfocus="this.value=(this.value==\'Search the Codex\') ? \'\' : this.value;" value="Search the Codex" name="search" class="text dw_search_input" > 
	'.$go_button),
	'href' => '#' ) );

	if ( $eab_wp_forums ) {
		$wp_admin_bar->add_menu( array(
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( '
		<strong style="display:none;">Search WordPress Support Forums</strong>
		<form target="_blank" method="get" action="http://wordpress.org/search/" class="alignleft dw_search" >
			<input type="text" onblur="this.value=(this.value==\'\') ? \'Search WP Forums\' : this.value;" onfocus="this.value=(this.value==\'Search WP Forums\') ? \'\' : this.value;" value="Search WP Forums" name="s" class="text dw_search_input" > 
		'.$go_button),
		'href' => '#' ) );
	}

	if ( $eab_wp_beginner ) {
		$wp_admin_bar->add_menu( array(
		'parent' => 'dsgnwrks_help_menu',
		'title' => __( '
		<strong style="display:none;">Search wpbeginner.com</strong>
		<form target="_blank" method="get" action="http://www.wpbeginner.com/" class="alignleft dw_search" >
			<input type="text" onblur="this.value=(this.value==\'\') ? \'Search wpbeginner.com\' : this.value;" onfocus="this.value=(this.value==\'Search wpbeginner.com\') ? \'\' : this.value;" value="Search wpbeginner.com" name="s" class="text dw_search_input" > 
		'.$go_button),
		'href' => '#' ) );
	}

	if ( !is_admin() && function_exists( 'genesis' ) && get_option( 'eab-genesis-menu' ) ) {
		// Add genesis admin pages menu
		$wp_admin_bar->add_menu( array(
		'id' => 'dsgnwrks_genesis_menu',
		'title' => __( 'Genesis' ),
		'href' => admin_url('admin.php?page=genesis') 
		) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'dsgnwrks_genesis_menu',
		'title' => __( 'Theme Settings' ),
		'href' => admin_url('admin.php?page=genesis') 
		) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'dsgnwrks_genesis_menu',
		'title' => __( 'SEO Settings' ),
		'href' => admin_url('admin.php?page=seo-settings') 
		) );

		$wp_admin_bar->add_menu( array(
		'parent' => 'dsgnwrks_genesis_menu',
		'title' => __( 'Import/Export' ),
		'href' => admin_url('admin.php?page=genesis-import-export') 
		) );


	}



}

// add theme info dashboard widget
add_action('wp_dashboard_setup', 'dsgnwrks_themeinfo_dash_widget');
function dsgnwrks_themeinfo_dash_widget() {

	if ( $eab_dash_widget = get_option( 'eab-dash-widget' ) ) {

		global $wp_meta_boxes;
		$dw_theme_name = get_current_theme();
		$dw_theme_data = get_theme($dw_theme_name);
		wp_add_dashboard_widget("dw_themeinfo_widget", "<div class='theme_info'>{$dw_theme_data["Name"]} by {$dw_theme_data["Author"]}</div>", "dsgnwrks_themeinfo_widget");

	}
}

function dsgnwrks_themeinfo_widget() {
$theme_name = get_current_theme();
	global $wp_meta_boxes;
	$dw_theme_name = get_current_theme();
	$dw_theme_data = get_theme($dw_theme_name);
	?>
	<div class='theme_info'>
	<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/screenshot.png" alt="<?php _e('Current theme preview'); ?>" />
	<?php
	echo "<p>{$dw_theme_data["Description"]}</p>";
	if ($dw_theme_data["Version"]){ 
		echo "<p>Version: {$dw_theme_data["Version"]}</p>";
	}
	if ($dw_theme_data["Tags"]){ 
		echo "<p>Tags: " . join(', ', $dw_theme_data['Tags'])."</p>";
	}
	
	echo "<p>For support, please contact {$dw_theme_data["Author"]}.</p></div>";
}
?>