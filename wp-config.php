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
define('DB_NAME', 'lieison_blunova');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'lq+%6jT)|9}{gWc==x6*_!C$gW^lUC-rI+8p% +>dYnm~CW`[.#+Q88|:HY/Bp@6');
define('SECURE_AUTH_KEY',  'w5=uG86mW:(Nz(S@!HD;) oP6r{>ue?|#g}x*fG]w y0#Xp@#=!dx} Y.T>pPa]l');
define('LOGGED_IN_KEY',    'oErY?NX6g/WXyIq;}w+(K<]#{o4sZt3yw,NR*,=Ofk4xX{k/},X+!Ov-9s&+>oC=');
define('NONCE_KEY',        '^9KdmlvLtgr_&sK|7|PUB-,/l]4Qi&i2hf@HD-$-@9g&|+W+Y+x#)Twf#qltn?Tg');
define('AUTH_SALT',        'IyxVhv] ]{sV&pN]@3Jd|@77>kFeya|/IUsu)qv@V>x/x&ZL@?RZ<%dg0h:]>P>%');
define('SECURE_AUTH_SALT', 'j)J5e?w1aVyy$nS!Il M3@{/tVX6ogG(Mr-w*j~g]EeE|v]y7@CiQB|4>$Hn^/s<');
define('LOGGED_IN_SALT',   'q-|MVhCu!@YX:h^-eH0:=9@M.Pu[RsXWK1UZQ|1@I1vx2@Wgx@|1|Zt-34$1@z,K');
define('NONCE_SALT',       'b Y!T!&j=1V#i-S(^X|}XPA2-GPk%J8:<GH`|u^T-!hGtvoY2Uk!&7GoMq6&W/,E');

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
