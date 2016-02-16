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
define('DB_NAME', 'salamy');

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
define('AUTH_KEY',         'q)_[i&Dp;lO(-+txlxf6Cj`X?hyUGrw!-jb`3W?t$84_~g!Tu?5_=} E.#;e)n+m');
define('SECURE_AUTH_KEY',  'fpE|7fj 7&J]9g2RTKX{?#glI?4gqB[?[djt%&O&UxKZ#?#{aHKRFRv/5Rsr$%lp');
define('LOGGED_IN_KEY',    'Dg_z#E>m|os|_lWAhqgxRf xg ;EKYN-%=q~?=g6WL1B_5 GSCrW+DEu%XDuXZ)j');
define('NONCE_KEY',        '!<_e tvzw5M&Rlgc`Z0^&Raee^@|PnS%f>u,fQ3Cr@Q>vEyQmE-al4Fc9J.oFQ~5');
define('AUTH_SALT',        '7cRy&&/&0PTfz~RN3+V|:@+fnvx&9*[+)JOAIO~rB1>gVGHL>Mpbeg8v#Z01K`w,');
define('SECURE_AUTH_SALT', '-bUCEk+; N~&py/5S:h f#rtY>;}SHgYLf/av67.N%o;Z`bsDcxYZAn.&Y#_=UuW');
define('LOGGED_IN_SALT',   ',GLDZ$}V@b?xt2sP8!Jw`NxAXC#8L3(`<Ts.dpWphC0pBxa3DAeJWEmAtsEH[mDj');
define('NONCE_SALT',       'K138jv3K>$4HdP--P`HtVvxl3WrEz9k]tfv$u(|v6mx.M7P>T^B|49NjL}%2:R2t');

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
