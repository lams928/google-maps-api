<?php
function obtener_tiendas() {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_ubicaciones';
    return $wpdb->get_results("SELECT * FROM $tabla_tiendas", ARRAY_A);
}

function agregar_tienda($nombre, $direccion, $departamento, $provincia, $telefonos, $latitud, $longitud) {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_ubicaciones';
    
    $resultado = $wpdb->insert(
        $tabla_tiendas, 
        array(
            'nombre' => $nombre,
            'direccion' => $direccion,
            'departamento' => $departamento,
            'provincia' => $provincia,
            'telefonos' => $telefonos,
            'latitud' => $latitud,
            'longitud' => $longitud
        ),
        array('%s', '%s', '%s', '%s', '%s', '%f', '%f')
    );

    if ($resultado === false) {
        return array(
            'success' => false,
            'error' => $wpdb->last_error
        );
    }
    return array(
        'success' => true,
        'id' => $wpdb->insert_id
    );
}

function eliminar_tienda($id) {
    global $wpdb;
    $tabla_tiendas = $wpdb->prefix . 'tiendas_ubicaciones';
    $wpdb->delete($tabla_tiendas, array('id' => $id));
}