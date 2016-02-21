<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'tiac_nis_wp_wp');

/** MySQL database username */
define('DB_USER', 'admin_tiac');

/** MySQL database password */
define('DB_PASSWORD', 'Tiac_2013**');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0jfBuW@INNuDZB3WI%1&$moE9Dm@vFLQ0hOS9NyX9bO91Y(xpjeHptZUIvu1It7f');
define('SECURE_AUTH_KEY',  'y6RyqK%Zl7rql2RN4kvjsfa(lM5SMnxDBmPEXlQWMFz(MI2OV%yc%(B@Nd1jD)yW');
define('LOGGED_IN_KEY',    '6RTLtDCvhA5!2Ln^vYD4ScCX*oEc@Z@6)7(8apJXO@s@(#yS&jD1P1g3hGJa@l5L');
define('NONCE_KEY',        '75to3MoDmFZ$p60xo965V7QkjJD*qNhtd9oFPTzdmz1t%fstt5^DF&&PV28lzDic');
define('AUTH_SALT',        'rDK)Ni9pjN%RSlXpD2C6NSd#hwH0Bv7S(zr&dh@kk1pEz##4GmhRZZ!W@UFi9lzI');
define('SECURE_AUTH_SALT', '66kJID$sz6vCgZay2BSVkXyaf)o*4TnwA)#FzIZ!f0@8Z^ILcWtXNLO)qQXq2WU*');
define('LOGGED_IN_SALT',   'zhRspGtRL%*zN^pQfgs!KDRxu20)Z@n0ukbI2WRU&#YyoGtUzwWoUH6QpuJ4%#Nd');
define('NONCE_SALT',       '2avNdQ3aj9oquEZlHO@E(9PgoK49iFOnl^Qa^wwUJXyx8&05VJUK#ZO6FZGe&Lc%');
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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );



?>
