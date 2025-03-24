<?php
// Añadir menú de administración
add_action('admin_menu', 'agregar_menu_tiendas');
function agregar_menu_tiendas() {
    add_menu_page(
        'Tiendas Mapa',
        'Tiendas Mapa',
        'manage_options',
        'tiendas-mapa',
        'mostrar_pagina_admin',
        'dashicons-location-alt',
        6
    );
}

function mostrar_pagina_admin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_tienda'])) {
        $resultado = agregar_tienda(
            sanitize_text_field($_POST['nombre']),
            sanitize_text_field($_POST['direccion']),
            sanitize_text_field($_POST['departamento']),
            sanitize_text_field($_POST['provincia']),
            sanitize_text_field($_POST['telefonos']),
            floatval($_POST['latitud']),
            floatval($_POST['longitud'])
        );
    
        if ($resultado['success']) {
            echo '<div class="notice notice-success is-dismissible"><p>Tienda agregada correctamente.</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Error al agregar la tienda: ' . 
                 esc_html($resultado['error']) . '<br>Por favor, verifique los datos e intente nuevamente.</p></div>';
        }
    }

    if (isset($_GET['eliminar_tienda'])) {
        eliminar_tienda(intval($_GET['eliminar_tienda']));
        echo '<div class="notice notice-success is-dismissible"><p>Tienda eliminada correctamente.</p></div>';
    }

    $tiendas = obtener_tiendas();
    ?>
    <div class="wrap">
        <h1>Administrar Tiendas</h1>
        <form method="post" action="">
            <?php wp_nonce_field('agregar_tienda_nonce'); ?>
            <h2>Agregar Nueva Tienda</h2>
            <table class="form-table">
                <tr>
                    <th><label for="nombre">Nombre</label></th>
                    <td><input type="text" id="nombre" name="nombre" required></td>
                </tr>
                <tr>
                    <th><label for="direccion">Dirección</label></th>
                    <td><input type="text" id="direccion" name="direccion" required></td>
                </tr>
                <tr>
                    <th><label for="departamento">Departamento</label></th>
                    <td><input type="text" id="departamento" name="departamento" required></td>
                </tr>
                <tr>
                    <th><label for="provincia">Provincia</label></th>
                    <td><input type="text" id="provincia" name="provincia" required></td>
                </tr>
                <tr>
                    <th><label for="telefonos">Teléfonos</label></th>
                    <td><input type="text" id="telefonos" name="telefonos" placeholder="Ej: 949776870 / 950121929" required></td>
                </tr>
                <tr>
                    <th><label for="latitud">Latitud</label></th>
                    <td><input type="number" id="latitud" name="latitud" step="any" required></td>
                </tr>
                <tr>
                    <th><label for="longitud">Longitud</label></th>
                    <td><input type="number" id="longitud" name="longitud" step="any" required></td>
                </tr>
            </table>
            <input type="submit" name="agregar_tienda" class="button button-primary" value="Agregar Tienda">
        </form>

        <h2>Lista de Tiendas</h2>
        <?php if (empty($tiendas)): ?>
            <p>No hay tiendas registradas.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Departamento</th>
                        <th>Provincia</th>
                        <th>Teléfonos</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tiendas as $tienda): ?>
                        <tr>
                            <td><?php echo esc_html($tienda['nombre']); ?></td>
                            <td><?php echo esc_html($tienda['direccion']); ?></td>
                            <td><?php echo esc_html($tienda['departamento']); ?></td>
                            <td><?php echo esc_html($tienda['provincia']); ?></td>
                            <td><?php echo esc_html($tienda['telefonos']); ?></td>
                            <td><?php echo esc_html($tienda['latitud']); ?></td>
                            <td><?php echo esc_html($tienda['longitud']); ?></td>
                            <td>
                                <a href="?page=tiendas-mapa&eliminar_tienda=<?php echo $tienda['id']; ?>" 
                                   class="button button-secondary" 
                                   onclick="return confirm('¿Está seguro de eliminar esta tienda?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}