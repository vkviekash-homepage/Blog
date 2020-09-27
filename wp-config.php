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
define( 'DB_NAME', 'Blog_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'V_s#e}nFV9,w]M6WZ=n>m69+-}o;jN+Uc3/y+oPBOB}=Sgj!qZ0 *jcv9A4jxmGM' );
define( 'SECURE_AUTH_KEY',  'MuLyRs.:OXl`?4!L*J+/Rh(Vf{BE2[B|^4N6Nuh5}!xQsV7OgP]a;6#@4,hM,FzP' );
define( 'LOGGED_IN_KEY',    '0O*p$g$qnN&9LT O>z.-Z_9vTd7)0ZLj(oF(4-:%b~#je9!:9pQQx!4$swy[H,Vk' );
define( 'NONCE_KEY',        '6AgEl1Q_|Ft4:uqCzWjb4,+6}i%Mb.5d~y=EB}MxN_*v|?1vQ#=CPlsJR_9q?Icr' );
define( 'AUTH_SALT',        'VOzd-Penv&V|S2p9O;:c*Gm=`4Z{N?=q-oJ g#IC5MR]1T~/rf}}B$w|VlL#V:1K' );
define( 'SECURE_AUTH_SALT', 'I:kAbk,Cp}+Kph3dC@.8/*#2m(:rQrx>-FOh^QhiUwB=5?Z[x ?Kwc|<7(V{fy#<' );
define( 'LOGGED_IN_SALT',   '*x%xKOgy|~!/rS3(n!9-6,6j:M_(R3KdR &o23!x@$&*tDQ;j-%vlO`M`{O,,?ul' );
define( 'NONCE_SALT',       'a,<2[Nr;UT6?q+EMS))sJLb-Q.%v6yc[9%U$tL[eDszU~By.;:LPK`}H)<s(+~__' );

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
