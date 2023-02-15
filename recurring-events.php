<?php
/**
 * Plugin Name:     Recurring Events
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     recurring-events
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Recurring_Events
 */

// Your code starts here.
require 'post-types/event.php';

if ( function_exists( 'get_field' ) ) {
	require 'inc/date-cron.php';
}

