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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_wp_latest' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'qaz' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hag][rYLH(r6g{n)AYQre7j9_dL^1$^k35dY/yFksNzu=E+|fi[%-h142[B/L`Xl' );
define( 'SECURE_AUTH_KEY',  'QsF=<k`-J2}JRk9q_H##2CVubIpys v#B |Nzi8/ZA~>Ot)qqIu!-B?LCzB`g$?9' );
define( 'LOGGED_IN_KEY',    'Ahyx2Uo6GJe6X[]!v?62k,ycs#-2j[puj!9GnKFU`.?x9Wx!,!9<-)&bFG-C3ING' );
define( 'NONCE_KEY',        'z[MH[oJrn*fFL%CA--2;d)^~m5TFs7HlM-6V4L!^i1)9D$akv:y~E=F76*p@zhFc' );
define( 'AUTH_SALT',        'UJxYQXSWs5KlTrQ{2<O w%)AYH<_no+!J}NDVLTG#k/N<mMd9sy2`j7wQbCpbSB`' );
define( 'SECURE_AUTH_SALT', '~8MVmK3.U(|U6? `K]gRjP-}(_x;q5r<.w0N(8;]9U6~_+qdW|~DOWw_FcYwPva4' );
define( 'LOGGED_IN_SALT',   'XKBvQk4L#T$C3:+_r)6O`!:U+I|ewH!d9 Nws[ZDRDFYMGB9oYy8GU`Kz-rP0|oE' );
define( 'NONCE_SALT',       ']csiM~qS.R0^FT6tQ!QP#@&w)-8?R4v6$2JW=pW$7%^:cf29LTnu!4TpOjKY 5l@' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

