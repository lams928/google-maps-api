<?php
/*
Plugin Name: Tiendas Mapa
Description: Plugin para agregar y mostrar tiendas en un mapa interactivo.
Version: 1.0
Author: Fibraser
*/

if (!defined('ABSPATH')) {
    exit; 
}

define('TIENDAS_MAPA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TIENDAS_MAPA_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once TIENDAS_MAPA_PLUGIN_DIR . 'includes/functions.php';
require_once TIENDAS_MAPA_PLUGIN_DIR . 'includes/admin-page.php';
require_once TIENDAS_MAPA_PLUGIN_DIR . 'includes/shortcode.php';

function actualizar_tabla_tiendas() {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_mapa';
    
    $wpdb->query("ALTER TABLE $tabla_tiendas 
        MODIFY latitud decimal(10,7) NOT NULL,
        MODIFY longitud decimal(10,7) NOT NULL,
        MODIFY horario varchar(100) DEFAULT NULL");
}

register_activation_hook(__FILE__, 'crear_tabla_tiendas');
function crear_tabla_tiendas() {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_mapa';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabla_tiendas (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(255) NOT NULL,
        direccion varchar(255) NOT NULL,
        departamento varchar(100) NOT NULL,
        provincia varchar(100) NOT NULL,
        horario varchar(100) DEFAULT NULL,
        latitud decimal(10, 7) NOT NULL,
        longitud decimal(10, 7) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('admin_init', 'ejecutar_actualizacion');
function ejecutar_actualizacion() {
    if (!get_option('tiendas_mapa_actualizado_v2')) {
        actualizar_tabla_tiendas();
        update_option('tiendas_mapa_actualizado_v2', true);
    }
}