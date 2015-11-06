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
define('DB_NAME', 'fnspeak_wpdb');

/** MySQL database username */
define('DB_USER', 'fnspeak_wpdb');

/** MySQL database password */
define('DB_PASSWORD', 'glQJQAkGvUox');

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
define('AUTH_KEY',         'z]Ub53zdR $h}NX jj5~.xQtI|YSK:UPPsB:qw=,cgA`D6A)e`S=JjN3fBfKIjSe');
define('SECURE_AUTH_KEY',  'Jy{Godlx4S^nc/ii?kSS>ABk{tnp*HNsGsK0fdhRE{M#Q,x2].D*z>S$D9H/l5~e');
define('LOGGED_IN_KEY',    '3=drfG-Yl1O@cNm_fnQyheAy (/QrO.Gx>,#|11^;8BPy0 :#ph?=)T<KI*VY&gI');
define('NONCE_KEY',        'zXH{&DdpzX<G&$R!a}irBka^w@`hBl(:qL}a^~>Po802uxHf];,Gni/]hlF4^&p8');
define('AUTH_SALT',        '6Wdhic<*T&`dJ;g$Y%z,Q5Y.!%V6g}tEZ~`D/[3rW{0CpaM;b0eikA9[[9g@%5!:');
define('SECURE_AUTH_SALT', './]COqY?&.R5O1&G1l&B,gs1<vsdb!1Du*7,e16F?Baf~ag#EXgV`A1>lq-}iDD*');
define('LOGGED_IN_SALT',   'G (Z8t U}+]*3ZP9f<27/(_)e]3~B/>d+f]aq0XmxAin&5v@w~hdxMsOs_ggj&o8');
define('NONCE_SALT',       'su`dO)#dao8ZQX4zd_,KW!4Y#JzPAw7?#$,RCZnOP$4tjSMpR/}UlF_ns#R}bj>s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'fs_';
 
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


/**
* Defineing the Admin and site URL values
*/

define('site_url', 'http://finaospeakers.com');
define('admin_email', 'krissh1240@gmail.com');
