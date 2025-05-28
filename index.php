<?php
/*
Plugin Name: RENIEC 
Description: [reniec_auth_button]
Version: 1.0.0
Author: Anyhelo
License: 
*/


define('RENIEC_AUTH_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RENIEC_AUTH_PLUGIN_URL', plugin_dir_url(__FILE__));

function reniec_auth_start_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
add_action('init', 'reniec_auth_start_session');

// Incluye archivos necesarios
require_once RENIEC_AUTH_PLUGIN_DIR . 'vendor/autoload.php';
require_once RENIEC_AUTH_PLUGIN_DIR . 'inc/api-helper.php';
require_once RENIEC_AUTH_PLUGIN_DIR . 'inc/auth-reniec.php';
require_once RENIEC_AUTH_PLUGIN_DIR . 'inc/cpt-setup.php';
require_once RENIEC_AUTH_PLUGIN_DIR . 'templates/shortcode-view.php';


// Estilos
function reniec_auth_enqueue_styles()
{
    wp_enqueue_style('reniec-style', RENIEC_AUTH_PLUGIN_URL . 'assets/style.css', [], '');
}
add_action('wp_enqueue_scripts', 'reniec_auth_enqueue_styles');
