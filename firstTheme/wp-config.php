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
define('DB_NAME', 'firstTheme2');

/** MySQL database username */
define('DB_USER', 'aaronkai');

/** MySQL database password */
define('DB_PASSWORD', 'm1ght!=r1ght');

/** MySQL hostname */
define('DB_HOST', 'school.db');

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
define('AUTH_KEY',         'EMw&(!xx$w9wxsMQuC#``~PpB_+E:/uJ>5AM+SxIH/I4 gOCoS_GC-&D0L`.+gtp');
define('SECURE_AUTH_KEY',  'AWCGTy7PFj9&W22YP`MNJFq[v|!f}e#68?w-q$Z<4+dSGM+~-Wn]lk|f p5$7lng');
define('LOGGED_IN_KEY',    '8bxM}{zm@28K+fd[Yc3dFa8|jNI [wS-sFxn|%,Z+A+~|[5rP+soX`53ji3%!t)T');
define('NONCE_KEY',        '9A{5L2 JUf^V% /w(+|?2AoT).1o,[b_-&E9%He^`f9X|.kfl2IaNYi{V,LtV-Et');
define('AUTH_SALT',        'vG)WeWdDBEN /2Ip~WZjg|IM(mK):>hctrz pi2ex8QQI!qYN;IEE?Ser9K8Ls!S');
define('SECURE_AUTH_SALT', 'k(-tz/b&r$sSlYr(SF~p TupR^ahbQZD 8P6NL=+mQ6 :S=zt^g`>E#L=kt%wwIH');
define('LOGGED_IN_SALT',   'EESh7}q+K;F3Zqsehh)oxrz&^^-UniK[fjte=<hEd2Zgdp$1cllZX9|$jMu#(PLp');
define('NONCE_SALT',       'J+RkclnL0QCvMw J-9O+i36@P j5T<E~y<G@xRU?B< LJv&k&<mI-FMeA.X[t#3-');

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
