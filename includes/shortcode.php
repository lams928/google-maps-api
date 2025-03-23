<?php
add_shortcode('mostrar_mapa_tiendas', 'mostrar_mapa_tiendas');
function mostrar_mapa_tiendas() {
    wp_enqueue_style('tiendas-mapa-style', TIENDAS_MAPA_PLUGIN_URL . 'assets/css/style.css');
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBarojo_u4HJyx4xRuYdVrWiYvnCxOvK-4&callback=initMap', array(), null, true);
    wp_enqueue_script('tiendas-mapa-script', TIENDAS_MAPA_PLUGIN_URL . 'assets/js/script.js', array('google-maps'), null, true);

    $tiendas = obtener_tiendas();
    wp_localize_script('tiendas-mapa-script', 'tiendasData', $tiendas);

    ob_start();
    ?>
    <div class="contenedor-principal">
        <div class="formulario-container">
            <select id="departamento-selector">
                <option value="">Seleccione un departamento</option>
            </select>
            <select id="provincia-selector">
                <option value="">Seleccione una provincia</option>
            </select>
            <select id="tienda-selector">
                <option value="">Seleccione una tienda</option>
            </select>
            <button id="buscar-tienda">Buscar en el mapa</button>
            <div class="info-tienda">
                <h5 id="nombre-tienda"></h5>
                <p id="direccion-tienda"></p>
                <p id="horario-tienda"></p>
            </div>
        </div>
        <div class="mapa-container">
            <div id="mapa-tiendas"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}