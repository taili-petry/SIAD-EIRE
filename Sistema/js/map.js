let map;
let drawingManager;
let polygons = [];

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -30.0, lng: -56.0 },
        zoom: 9,
        mapTypeId: "terrain",
    });

    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: null,
        drawingControl: true,
        drawingControlOptions: {
            drawingModes: ["polygon"]
        },
        polygonOptions: {
            editable: true,
            fillColor: "#00a86b",
            fillOpacity: 0.4,
            strokeWeight: 2
        }
    });

    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, "polygoncomplete", savePolygon);

    loadPropriedades();
}

window.onload = initMap;


// --------------------------------------------
// SALVAR POLÍGONO
// --------------------------------------------
function savePolygon(poly) {
    const data = poly.getPath().getArray().map(p => ({ lat: p.lat(), lng: p.lng() }));

    const nome = prompt("Nome da área:");
    if (!nome) return;

    fetch("api/geometrias.php", {
        method: "POST",
        body: JSON.stringify({
            nome,
            coordenadas: data
        })
    });
}


// --------------------------------------------
// CARREGAR PROPRIEDADES (via PHP)
// --------------------------------------------
function loadPropriedades() {
    fetch("api/propriedades.php")
        .then(r => r.json())
        .then(lista => {
            const select = document.getElementById("selectPropriedade");
            const tbody = document.getElementById("listaProps");

            select.innerHTML = "";
            tbody.innerHTML = "";

            lista.forEach(p => {
                select.innerHTML += `<option value="${p.id}">${p.nome}</option>`;

                tbody.innerHTML += `
                    <tr>
                        <td>${p.nome}</td>
                        <td>${p.car}</td>
                    </tr>
                `;
            });

            document.getElementById("totalProps").innerText = lista.length;
        });
}
