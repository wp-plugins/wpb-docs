<?php
/*
Plugin Name: WPB Docs
Plugin URI: http://www.divinedeveloper.com/projects/wpb-docs/
Description: Easy to use plugin that make Twitter's Bootstrap like documentation
Version: 1.0
Author: Mladjo
Author URI: http://www.divinedeveloper.com/
License: GPLv3
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once dirname( __FILE__ ) . '/class.plugin.php' ;
WPB_Docs::get_instance();
require_once dirname( __FILE__ ) . '/inc/class.posttypes.php';
require_once dirname( __FILE__ ) . '/inc/shortcodes.php';
