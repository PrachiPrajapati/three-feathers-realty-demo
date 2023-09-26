<?php
/*
Plugin Name: WP Replicate Post
Plugin URI: https://wordpress.org/plugins/wp-replicate-post
description: Create a clone of all post type...
Version: 3.1
Author: Yudiz Solutions Pvt. Ltd.
Author URI: http://www.yudiz.com
License: 
*/
?>
<?php
define( 'REP_POST_PLUGIN', __FILE__ );
define( 'REP_POST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'REP_POST_URL', plugin_dir_url( REP_POST_PLUGIN_DIR ) . basename( dirname( __FILE__ ) ) . '/' );
define( 'REP_POST_PLUGIN_BASENAME', plugin_basename( REP_POST_PLUGIN ) );
require_once(REP_POST_PLUGIN_DIR.'init/functions.php');

/*
 *Activation hook
*/
register_activation_hook(REP_POST_PLUGIN, 'checkbox_enable');