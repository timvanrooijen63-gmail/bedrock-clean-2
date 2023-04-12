<?php
/**
 * Configuration overrides for WP_ENV === 'staging'
 */

use Roots\WPConfig\Config;

/**
 * Forest sets DB credentials for us, better use 'em
 */
Config::define('DB_NAME', env('DATABASE_WORDPRESS_NAME'));
Config::define('DB_USER', env('DATABASE_WORDPRESS_USER'));
Config::define('DB_PASSWORD', env('DATABASE_WORDPRESS_PASSWORD'));
Config::define('DB_HOST', env('DATABASE_WORDPRESS_HOST'));

/**
 * You should try to keep staging as close to production as possible. However,
 * should you need to, you can always override production configuration values
 * with `Config::define`.
 *
 * Example: `Config::define('WP_DEBUG', true);`
 * Example: `Config::define('DISALLOW_FILE_MODS', false);`
 */

Config::define('DISALLOW_INDEXING', true);
