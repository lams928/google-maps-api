let mapa;
let marcadorActual;

function initMap() {
    mapa = new google.maps.Map(document.getElementById("mapa-tiendas"), {
        center: { lat: -12.0464, lng: -77.0428 },
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    cargarDepartamentos();
}

function cargarDepartamentos() {
    const departamentos = [...new Set(tiendasData.map(t => t.departamento))].sort();
    const select = document.getElementById('departamento-selector');
    select.innerHTML = '<option value="">Seleccione un departamento</option>';
    departamentos.forEach(dep => {
        select.innerHTML += `<option value="${dep}">${dep}</option>`;
    });
}

function cargarProvincias(departamento) {
    const provincias = [...new Set(tiendasData.filter(t => t.departamento === departamento).map(t => t.provincia))].sort();
    const select = document.getElementById('provincia-selector');
    select.innerHTML = '<option value="">Seleccione una provincia</option>';
    provincias.forEach(prov => {
        select.innerHTML += `<option value="${prov}">${prov}</option>`;
    });
}

function cargarTiendas(departamento, provincia) {
    const tiendas = tiendasData.filter(t => t.departamento === departamento && t.provincia === provincia);
    const select = document.getElementById('tienda-selector');
    select.innerHTML = '<option value="">Seleccione una tienda</option>';
    tiendas.forEach(tienda => {
        select.innerHTML += `<option value="${tienda.nombre}">${tienda.nombre}</option>`;
    });
}

function mostrarTienda(nombreTienda) {
    const tienda = tiendasData.find(t => t.nombre === nombreTienda);
    if (tienda) {
        document.getElementById('nombre-tienda').textContent = tienda.nombre;
        document.getElementById('direccion-tienda').textContent = tienda.direccion;
        document.getElementById('horario-tienda').textContent = tienda.horario;

        if (marcadorActual) {
            marcadorActual.setMap(null);
        }

        const posicion = { lat: parseFloat(tienda.latitud), lng: parseFloat(tienda.longitud) };
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
                    <p>${tienda.direccion}</p>
                    <p>${tienda.horario}</p>
                </div>
            `
        });

        marcadorActual.addListener('click', () => {
            infoWindow.open(mapa, marcadorActual);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('departamento-selector').addEventListener('change', function() {
        const departamento = this.value;
        if (departamento) {
            cargarProvincias(departamento);
            document.getElementById('provincia-selector').value = '';
            document.getElementById('tienda-selector').innerHTML = '<option value="">Seleccione una tienda</option>';
        }
    });

    document.getElementById('provincia-selector').addEventListener('change', function() {
        const provincia = this.value;
        const departamento = document.getElementById('departamento-selector').value;
        if (provincia && departamento) {
            cargarTiendas(departamento, provincia);
        }
    });

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