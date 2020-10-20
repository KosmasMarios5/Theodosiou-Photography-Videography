<?php


define('CONCATENATE_SCRIPTS', false);
define('DISALLOW_FILE_EDIT', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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
define( 'DB_NAME', 'theodosiou_wp' );

/** MySQL database username */
define( 'DB_USER', 'laoura' );

/** MySQL database password */
define( 'DB_PASSWORD', 'at624474' );

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
define( 'AUTH_KEY',         '6(/RlayieoG?)qwWjYbqA_[f6(@^uFTM$`#/!VcMP5u(Ss/mlUMj4[v^EeZaM*##' );
define( 'SECURE_AUTH_KEY',  'Hh#=uus5QU(0r_E>=hm;ou)s`Tox(EBz79V!+D^2Hcnn|]n%-0sek-hiMdk~A=1W' );
define( 'LOGGED_IN_KEY',    'bXUh+6CnqzPe@F*mW.w~Qx/K{+h5L0jGT60m2}l#w25dprt-?P>+HrYf;r+ms]~f' );
define( 'NONCE_KEY',        'U{((V:|dJ^{U&i>V5:l:15+E@7C4pJ8r.qWk{rgY>)]QBilrGmUN0ne5qk}j<c[b' );
define( 'AUTH_SALT',        '?`.K1D_|* 0J$vA[1x7KMxd-.>/iCdd>vgk5r[8 voh/Ce%2Nj_6z?$N)dH.2%/ ' );
define( 'SECURE_AUTH_SALT', '>?q=y;CE*+5p_tIjo>g`5RI1TFcBN<,TzGXAid?6aqJZ9(SeMslK-mOUtllQ,jQB' );
define( 'LOGGED_IN_SALT',   '&b7,Jw;Lydpw|Bk_vV@n%{f|]Ir;iN)-,nb1xx(jYE-A}RrVuw6] xU`d7,Kw[Z!' );
define( 'NONCE_SALT',       '~N _Z:AEc#Ygq1%{r_}Vikv(}#8yu%7/{Ytd0Y](${R>oyM>kDg%R[;E-}x3I=^1' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'jXg2To_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy publishing. */

//if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
//    $_SERVER['HTTPS']='on';

define( 'WP_HOME', 'https://new.theodosiou.gr' );
define( 'WP_SITEURL', 'https://new.theodosiou.gr' );

//define('FORCE_SSL_LOGIN', true);
//define('FORCE_SSL_ADMIN', true);

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

