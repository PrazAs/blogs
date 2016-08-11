<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'Tabtorcloud16');

/** MySQL hostname */
define('DB_HOST', 'tabtorreportdb.comyaniqgjcv.us-east-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '>:%DfYp+y(hLvRyO5G5N(-SyW-zMX*X$E;EdJhV>Xgl^sh/ W,9BqDI@kdmBN#cg');
define('SECURE_AUTH_KEY',  '*yNT}7N<:)SA!CCXV8OrPkhXZII?=Q)=m7w8w0$g4Vp[SlG|,e*>ze,*A).8DA:k');
define('LOGGED_IN_KEY',    'XoK:dI k*+Z`|-x*&VvS,ob;RKK]?. O!N]F~(n[]uN eNn<d}9Mk*j&%[d.8fIT');
define('NONCE_KEY',        'DAT5.,oQqNVLZ]H0=u%fZ%2B4ebv]^m7S1T}TPLZ.Rzk=NL#`G_@G5Apg,;6$LAu');
define('AUTH_SALT',        'OcN/QU1bF&UGaM5rl`D3gYaj6*)OmPs-HL$so|K|{<l ])( S&C(R:,ReCjwR-~h');
define('SECURE_AUTH_SALT', 'AUGStLzC#g$`cgivBl-.};/m4|wR7|eFOCEJBpR.0Ha3yZ2zgyCcq!cflE%U6t$G');
define('LOGGED_IN_SALT',   'r@ [:fmpMnt[ZIJ%VD~z2r4P]d.9.[!WbJ$-RRp#g (UagY`Q!1k+oLW$A&7PT{^');
define('NONCE_SALT',       '*OWwo6/WA[5pW-o4HI>y]kL|7X.P`g6yt):Y1+KNqD;M}Ry+O,lX/2jxPNV(Gd|F');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
