<?php
/*
Plugin Name: Tech Registrations
Plugin URI: http://www.techeffex.com/plugins/courses/
Description: Registration Manager Plugin. 
Version: 1.0.0
Author: Mike Nelson
Author URI: http://www.techeffex.com
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/

add_action( 'init', 'tech_registration_scripts' );
function tech_registration_scripts(){
     if(is_admin()){
        wp_register_style('tech-registration-style',plugins_url('/style.css', __FILE__ ));
        wp_enqueue_style('tech-registration-style');
		
		wp_register_script('toggle-status-js', plugins_url('/toggleStatus.js', __FILE__ ));
		$translation_array = array( 'URL' => plugin_dir_url(__FILE__) );
		wp_localize_script( 'toggle-status-js', 'pluginPath', $translation_array );
        wp_enqueue_script('toggle-status-js');
    }   
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
    add_menu_page( 'Registrations', 'Registrations', 'manage_options', 'tech-registrations/manageRegistrations.php' ,'', 'dashicons-groups', 6 ); 
}


?>