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
    <div id="mapa-tiendas" style="height: 500px; width: 100%;"></div>
    <?php
    return ob_get_clean();
}