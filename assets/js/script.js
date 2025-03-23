function initMap() {
    const map = new google.maps.Map(document.getElementById('mapa-tiendas'), {
        center: { lat: -12.0464, lng: -77.0428 },
        zoom: 6
    });

    tiendasData.forEach(tienda => {
        new google.maps.Marker({
            position: { lat: parseFloat(tienda.latitud), lng: parseFloat(tienda.longitud) },
            map: map,
            title: tienda.nombre
        });
    });
}

window.initMap = initMap;