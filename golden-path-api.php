<?php
/**
 * 
 * Plugin Name: Golden Path API
 * Plugin URI: http://www.goldenpathsolutions.com
 * Description: This plugin contains a number of useful tools and functions for
 *              developers.  See inline documentation for details.
 * Author: Patrick Jackson <pjackson@goldenpathsolutions.com>
 * Version: 1.0.0
 * Author URI: http://www.goldenpathsolutions.com
 * Text Domain: gps-api
 * 
 * 
 * This plugin contains a number of useful tools and functions for developers.
 * These include the following.
 * 
 * - Enqueue Manager - Makes it easier to only include scripts and styles on the
 *      pages you want by wrapping the enqueues with some page-aware logic.
 *      @see Enqueue_Manager
 *      @see Enqueue_Script_Item
 *      @see Enqueue_Style_Item
 * 
 * @category golden-path-api
 * @author: Patrick Jackson <pjackson@goldenpathsolutions.com>
 * @version: 1.0.0
 * @copyright 2014 Golden Path Solutions, Inc.
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, v2.0
 * 
 * @todo need to finish documenting everything
 * 
 */

//Load the Enqueue Manager.  This class will load dependent classes.
include_once 'enqueue-manager/class-enqueue-manager';