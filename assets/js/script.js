let mapa;
let marcadorActual;

function initMap() {
    mapa = new google.maps.Map(document.getElementById("mapa"), { // Cambiado de mapa-tiendas a mapa
        center: { lat: -12.0464, lng: -77.0428 },
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [], // Opcional: para estilos personalizados
        gestureHandling: 'cooperative'
    });
}

function actualizarProvincias(departamento) {
    const select = document.getElementById('provincia-selector');
    select.innerHTML = '<option value="">Seleccione una provincia</option>';
    
    if (!departamento) return;

    const provincias = [...new Set(tiendasData.tiendas
        .filter(t => t.departamento === departamento)
        .map(t => t.provincia))]
        .sort();

    provincias.forEach(provincia => {
        const option = document.createElement('option');
        option.value = provincia;
        option.textContent = provincia;
        select.appendChild(option);
    });

    // Limpiar el selector de tiendas
    document.getElementById('tienda-selector').innerHTML = '<option value="">Seleccione una tienda</option>';
}

function actualizarTiendas() {
    const departamento = document.getElementById('departamento-selector').value;
    const provincia = document.getElementById('provincia-selector').value;
    const select = document.getElementById('tienda-selector');
    
    select.innerHTML = '<option value="">Seleccione una tienda</option>';
    
    if (!departamento || !provincia) return;

    const tiendas = tiendasData.tiendas
        .filter(t => t.departamento === departamento && t.provincia === provincia)
        .sort((a, b) => a.nombre.localeCompare(b.nombre));

    tiendas.forEach(tienda => {
        const option = document.createElement('option');
        option.value = tienda.nombre;
        option.textContent = tienda.nombre;
        select.appendChild(option);
    });
}

function mostrarTienda(nombreTienda) {
    const tienda = tiendasData.tiendas.find(t => t.nombre === nombreTienda);
    if (tienda) {
        document.getElementById('nombre-tienda').textContent = tienda.nombre;
        document.getElementById('direccion-tienda').textContent = tienda.direccion;
        document.getElementById('telefonos-tienda').textContent = tienda.telefonos;
        document.getElementById('horario-tienda').textContent = tienda.horario;

        if (marcadorActual) {
            marcadorActual.setMap(null);
        }

        const posicion = { 
            lat: parseFloat(tienda.latitud), 
            lng: parseFloat(tienda.longitud) 
        };

        marcadorActual = new google.maps.Marker({
            position: posicion,
            map: mapa,
            title: tienda.nombre
        });

        mapa.setCenter(posicion);
        mapa.setZoom(15);

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px">
                    <h3>${tienda.nombre}</h3>
                    <p><strong>Dirección:</strong> ${tienda.direccion}</p>
                    <p><strong>Teléfonos:</strong> ${tienda.telefonos}</p>
                    <p><strong>Horario:</strong> ${tienda.horario}</p>
                </div>
            `
        });

        marcadorActual.addListener('click', () => {
            infoWindow.open(mapa, marcadorActual);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buscar-tienda').addEventListener('click', function() {
        const tiendaSeleccionada = document.getElementById('tienda-selector').value;
        if (tiendaSeleccionada) {
            mostrarTienda(tiendaSeleccionada);
        } else {
            alert('Por favor seleccione una tienda primero');
        }
    });
});


window.initMap = initMap;
google.maps.event.addDomListener(window, 'load', function() {
    console.log('Google Maps API cargado');
    initMap();
});