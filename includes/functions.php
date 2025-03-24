<?php
function obtener_tiendas() {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_mapa';
    return $wpdb->get_results("SELECT * FROM $tabla_tiendas", ARRAY_A);
}

function agregar_tienda($nombre, $direccion, $departamento, $provincia, $telefonos, $latitud, $longitud) {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_mapa';
    $wpdb->insert($tabla_tiendas, array(
        'nombre' => $nombre,
        'direccion' => $direccion,
        'departamento' => $departamento,
        'provincia' => $provincia,
        'telefonos' => $telefonos,
        'latitud' => $latitud,
        'longitud' => $longitud
    ));
}

function eliminar_tienda($id) {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_mapa';
    $wpdb->delete($tabla_tiendas, array('id' => $id));
}