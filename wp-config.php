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
define('DB_NAME', 'avispate');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'l4gr4c14');

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
define('AUTH_KEY',         'An:+.? 07DLe/Km>gLoEc`2OL;2BWc<ip2iJ7em+L/>XG%Us[tp=3{wUSOq7-20h');
define('SECURE_AUTH_KEY',  '|KeIk>L:MV21Hj,=b}KVmx*jrEXKG9s!:*+bTuQnTRdbX%L}.#[;^q^VHwmu603!');
define('LOGGED_IN_KEY',    '~y(w>OjQt:vbZl9bn`@[?3swbn_kg{}uz~70tlqnb$1]y/zja&Bb1]X,Kes60pi@');
define('NONCE_KEY',        ')GJJ}!([0?*vXUIjUxL+z%M7xK$&9#[>EA1{?lf|Npz$/*k+{-Qpm+k1fn,:doT2');
define('AUTH_SALT',        '7b|RV/O-iHK&D+EFfO2@i+5:ZBBj9ZB*[Q%)VtscRPTIJj3tS(ev7jW@)/g47Z^P');
define('SECURE_AUTH_SALT', 't<yRA<Oa0J&9%F2E&d7,1G,Aq;]GWTj2Z74nDYgBjZbigbC5R,PT|gW6(|Fv#{bs');
define('LOGGED_IN_SALT',   'mf]nI;^y-Dh~U!~_NDZ0;w>-|O-+er(QN~2l t9^b^h;<[+{c-7XV=cXO7RmI:`5');
define('NONCE_SALT',       'icMVk4>|PYu<pps!<mm7:TcGPn~iEq)c HAv0(&3CXvzU5Vf94d`zJ=d6B^kID_+');

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
