<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'firstTheme');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '{FQAbv2<)`dF2F%X24VN>>A=JMY1wRY!lpU<NK]p;Ah&y&t1F#T l<3OTyLr[x-;');
define('SECURE_AUTH_KEY',  'psq]cOnJvA:j,6lDDlP!Tw~!`gB5J0!RMuB.Wef%!-0{;[:!$F>A] {.z=vkxO$H');
define('LOGGED_IN_KEY',    'So&w-0-HTn7umg.<O7$QZvmmpTLQaL8,+5Cv=w^TR& wB%(jZS)EJyk+CcD*]-]Q');
define('NONCE_KEY',        '_-dE>nA$^9HdAA4LP_M?8DXe1HLy+bHvDG*Y`JF<RWf8J[9`]4 ?^8g |x7drPFc');
define('AUTH_SALT',        '>T-:t}aG2to+:LR97rnc%CN1qDEqKj{N[z^%HH|F|-$5FoRpbox~Sw~m`BCbgc7z');
define('SECURE_AUTH_SALT', 'RQh4ib0nuH$9j_%I3;%Dz7i%cW*$u7H?:VXo6n$5PNLF+rctk9b?2Ha&y y%qy`-');
define('LOGGED_IN_SALT',   '}P]?3]`q#Fo%mcU%*,0V%b_KEXzk55KNg8_v[k%)n=v+C5_Wy)f.>; W8JnS/tCr');
define('NONCE_SALT',       'tCjmZ5S@{1[Aefe$cV5?bB%=GXI>DHid7-HOOEp8sRf;-K!wrSA[b$/(}]:wb_Wr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
