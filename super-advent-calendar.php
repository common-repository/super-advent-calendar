<?php

/**
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 *
 * Plugin Name: Super Advent Calendar
 * Plugin URI: https://www.verdant.studio/plugins/super-advent-calendar
 * Description: Add a super flexible advent calendar to your website for festive giveaways or counting down the holidays.
 * Version: 1.11.0
 * Author: Verdant Studio
 * Author URI: https://www.verdant.studio
 * License: GPLv2 or later
 * Text Domain: super-advent-calendar
 * Domain Path: /languages
 * Requires at least: 6.6
 *
 */
/**
 * Exit when accessed directly.
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !function_exists( 'vs_sac_fs' ) ) {
    /**
     * Create a helper function for easy SDK access.
     */
    function vs_sac_fs() {
        global $vs_sac_fs;
        if ( !isset( $vs_sac_fs ) ) {
            // Include Freemius SDK.
            require_once __DIR__ . '/freemius/start.php';
            $vs_sac_fs = fs_dynamic_init( array(
                'id'             => '15471',
                'slug'           => 'super-advent-calendar',
                'type'           => 'plugin',
                'public_key'     => 'pk_a343c85e0ee3cbb216da2ba6a1d3f',
                'is_premium'     => false,
                'premium_suffix' => 'Premium',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'first-path' => 'plugins.php',
                    'contact'    => false,
                    'support'    => false,
                ),
                'is_live'        => true,
            ) );
        }
        return $vs_sac_fs;
    }

    // Init Freemius.
    vs_sac_fs();
    // Signal that SDK was initiated.
    do_action( 'vs_sac_fs_loaded' );
}
define( 'SUPER_ADVENT_CALENDAR_VERSION', '1.11.0' );
define( 'SUPER_ADVENT_CALENDAR_REQUIRED_WP_VERSION', '6.6' );
define( 'SUPER_ADVENT_CALENDAR_FILE', __FILE__ );
define( 'SUPER_ADVENT_CALENDAR_DIR_PATH', plugin_dir_path( SUPER_ADVENT_CALENDAR_FILE ) );
define( 'SUPER_ADVENT_CALENDAR_PLUGIN_URL', plugins_url( '/', SUPER_ADVENT_CALENDAR_FILE ) );
// Require Composer autoloader if it exists.
if ( file_exists( __DIR__ . '/vendor-prefixed/autoload.php' ) ) {
    require_once __DIR__ . '/vendor-prefixed/autoload.php';
}
require_once __DIR__ . '/src/autoload.php';
require_once __DIR__ . '/src/Bootstrap.php';
$init = new SuperAdventCalendar\Bootstrap();