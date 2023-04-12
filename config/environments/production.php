<?php
/**
 * Configuration overrides for WP_ENV === 'staging'
 */

use function Env\env;
use Roots\WPConfig\Config;

/**
 * Forest sets DB credentials for us, better use 'em
 */
Config::define('DB_NAME', env('DATABASE_WORDPRESS_NAME'));
Config::define('DB_USER', env('DATABASE_WORDPRESS_USER'));
Config::define('DB_PASSWORD', env('DATABASE_WORDPRESS_PASSWORD'));
Config::define('DB_HOST', env('DATABASE_WORDPRESS_HOST'));

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);
