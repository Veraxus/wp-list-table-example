<?php
/**
 * Custom WP List Table Example plugin
 *
 * @package   WPListTableExample
 * @author    Matt van Andel
 * @copyright 2016 Matthew van Andel
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Custom WP List Table Example
 * Description: A highly-documented plugin that demonstrates how to create custom List Tables using official WP APIs.
 * Version:     1.5
 * Author:      Matt van Andel
 * Author URI:  http://www.mattvanandel.com
 * Text Domain: wp-list-table-example
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
    Copyright 2016  Matthew Van Andel  (email : matt@mattvanandel.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 * == NOTICE ===================================================================
 * Please do not alter this file. Instead: make a copy of the entire plugin,
 * rename it, and work inside the copy. If you modify this plugin directly and
 * an update is released, your changes will be lost!
 * ==========================================================================
 */

// Abort if this file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * LOADING THE BASE CLASS
 *
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary. In this tutorial, we are
 * going to use the WP_List_Table class directly from WordPress core.
 *
 * Please note that the WP_List_Table class technically isn't an official API,
 * and is subject to change in the future. Should breaking changes happen, I 
 * will update this plugin with the most current techniques for your reference
 * right away.
 *
 * If you are worried about future compatibility, you should make a copy of
 * the WP_List_Table class (file path is shown just below) to use and distribute
 * with your plugins. If you do that, just remember to change the name of the
 * class (or namespace it) to avoid conflicts with core.
 *
 * Since I will be keeping this tutorial up-to-date for the foreseeable future,
 * I am going to work with the copy of the class provided in WordPress core.
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * LOAD THE CHILD CLASS
 * 
 * Next, we need to create and load a child class that extends WP_List_Table.
 * Most of the work will be done there. Open the file now and take a look.
 */
require dirname( __FILE__ ) . '/includes/class-tt-example-list-table.php';

add_action( 'admin_menu', 'tt_add_menu_items' );
/**
 * REGISTER THE EXAMPLE ADMIN PAGE
 *
 * Now we just need to define an admin page. For this example, we'll add a top-level
 * menu item to the bottom of the admin menus.
 */
function tt_add_menu_items() {
	add_menu_page(
		__( 'Example Plugin List Table', 'wp-list-table-example' ), // Page title.
		__( 'List Table Example', 'wp-list-table-example' ),        // Menu title.
		'activate_plugins',                                         // Capability.
		'tt_list_test',                                             // Menu slug.
		'tt_render_list_page'                                       // Callback function.
	);
}

/**
 * CALLBACK TO RENDER THE EXAMPLE ADMIN PAGE
 *
 * This function renders the admin page and the example list table. Although it's
 * possible to call `prepare_items()` and `display()` from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function tt_render_list_page() {
	// Create an instance of our package class.
	$test_list_table = new TT_Example_List_Table();

	// Fetch, prepare, sort, and filter our data.
	$test_list_table->prepare_items();

	// Include the view markup.
	include dirname( __FILE__ ) . '/views/page.php';
}
