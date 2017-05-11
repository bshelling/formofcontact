<?php
defined('ABSPATH') or die('No here to see');
/*
 * Plugin Name: Form of Contact
 * Plugin URI: http://noearlynohalf.com/contactme-plugin
 * Description: Form of contact sends form submissions to admin email and stores each submissions to a database
 * Version: 1.0
 * Author: Brandon Shelling
 * Author URI: http://noearlynohalf.com
 */

/*
 * On plugin activation create table "wp_contact_list"
 */
register_activation_hook(__FILE__,'create_userDb');
function create_userDb(){
    global $wpdb;

    $tableName = $wpdb->prefix ."contact_list";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tableName (
        id int NOT NULL AUTO_INCREMENT,
 	name varchar(255) NOT NULL,
	email varchar(75) NOT NULL,
	message text NULL,
	PRIMARY KEY  (id) 
    ) $charset_collate;";

    require_once(ABSPATH .'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}

/*
 * On plugin deactivation drop table
 */
register_deactivation_hook(__FILE__,'drop_userDb');
function drop_userDb(){
    global $wpdb;
    $tableName = $wpdb->prefix ."contact_list";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "DROP TABLE $tableName;"; 
    require_once(ABSPATH .'wp-admin/includes/upgrade.php');
    $wpdb->query($sql);
}

/*
 * Render Form
 */
function renderForm(){
   
    return getTemplate('form','');
}
add_shortcode('formofcontact','renderForm');


/*
 * Template
 */
function getTemplate($template,$attributes = null){

    ob_start();
    require('templates/'.$template.'.php'); 
    $template = ob_get_contents();
    ob_clean();
    return $template;

}

/*
 * Get form styles
 */
function formStyles(){
  wp_enqueue_style('formStyle',plugins_url().'/formofcontact/plugin_components/css/app.css');
 
}
add_action('wp_enqueue_scripts','formStyles');
