<?php
/*
Plugin Name: No JS detection plugin
Plugin URI:
Description: This plugins allows Wordpress to display a warning message if the visitor's browser hasn't javascript enabled.
Version: 0.1
Author: T&eacute;rence VIGAN
Author URI: 
License:Copyright 2011  Térence VIGAN  (email : terence.vigan@gmail.com)

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
Plugin functioning explanation:

a)Why?(why using this plugin instead of the one provided by daddydesign?)

The plugin, instead of using the noscript tag as the one provided by daddydesign, will use jquery.
Why? the noscript tag is buggy with opera, not allowing this browser to display a message when the 
javascript is disabled. Moreover, I wanted to separe some elements from the plugin php file, as the css, in 
order to let in future versions the possibility for the admin to customize it.

b)How?

The plugin will add the jquery framework. It will help hiding the warning message with its "hide" 
function if javascript is enabled of course. If the js is disabled, the message will be automatically 
displayed, the hide function being, of course, not working. For avoiding conflicts with other frameworks, 
the plugin will use the "no conflict" option of jquery.
 
c)For who?

For people who needs javascript to be enabled for displaying some informations or who heavily uses 
ajax. I will perhaps develop a plugin who blocks the visitor if js is disabled. Heh...Javascript is
an unvoidable element of the future of the web...

d)What else?
The plugin is inspired by the one made by daddydesign. You can have a look on this one by  visiting:
http://www.daddydesign.com/wordpress/javascript-detect-wordpress-plugin/.
*/

//function for handling the add of the no_js_detect script on the page; Making sure jQuery is loaded before and that we are not in admin section: 
function add_noJsDetect_script () {
	if ( !(is_admin()) ) {
		wp_register_script( 'no_js_detect', WP_PLUGIN_URL.'/no_js_enabled_detection_plugin/js/no_js_detect.js', array( 'jquery' ),'0.1' );
		wp_enqueue_script( 'no_js_detect' );
	}
}

//function handling the insertion of the message style, of course not needed in admin section:
function add_noJsDetect_style () {
	if ( !(is_admin()) ) {
		wp_register_style( 'no_js_detect_style', WP_PLUGIN_URL.'/no_js_enabled_detection_plugin/css/no_js_detect_style.css', '', '0.1', 'all' );
		wp_enqueue_style( 'no_js_detect_style' );
	}
}

//Time to add the js script and the css style to header informations:
add_action( 'wp_print_styles', 'add_noJsDetect_style' );
add_action( 'wp_print_scripts', 'add_noJsDetect_script' );

//Here we go! adding the function handling the display of the warning message:
function add_noJsDetectMessage_toPage () {
	
	$message = '	<div id="div_noJs">
						<p>
							<span>Warning:</span> It has been detected that your browser hasn\'t javascript enabled.
							Some pages of this site will not be displayed correctly or some features will not work 
							properly without it. It is is strongly recommended if not needed to enable javascript 
							for the best user\'s navigation experience. Thanks for your comprehension.
						</p>
					</div>';
				
	echo $message;
}

//Adding the function effect to the footer:
add_action( 'wp_footer', 'add_noJsDetectMessage_toPage' );

/*
Ideas for 0.2:
-Customisable Warning message.
-Customisable Warning image.

Ideas for 0.3:
-Multi-languages support.
*/
?>