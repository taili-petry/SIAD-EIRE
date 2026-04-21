<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>SIAD – Propriedades Rurais</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <style>
        body {
            overflow: hidden;
            background: #f7f8f3;
        }

        /* SIDEBAR */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 95px;
            height: 100vh;
            background: #e5ebe3;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 3px 0 6px rgba(0,0,0,0.15);
            z-index: 30;
        }

        .menu-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #dfe6dd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            cursor: pointer;
            transition: .3s;
        }
        .menu-icon:hover {
            background: #cfd8c9;
        }

        /* PAINEL DINÂMICO */
        #painel {
            position: fixed;
            top: 0;
            left: 95px;
            width: 350px;
            height: 100vh;
            background: #eef1ea;
            padding: 25px;
            overflow-y: auto;
            box-shadow: 3px 0 6px rgba(0,0,0,0.15);
            z-index: 20;
        }

        .titulo-secao {
            background: #d8ded6;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #4a5644;
        }

        .subtitulo-secao {
            font-weight: 550;
            padding: 10px;
            color: #4a5644;
        }

        .dado-secao {
            background: #ffffffff;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            color: #3d3d3dff;
        }

        .metric-box {
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: -05px;
        }

        #map {
            position: absolute;
            left: 445px;
            top: 0;
            right: 0;
            height: 100vh;
            z-index: 1;
        }

        .table td,
        .table th,
        .table tr {
            color: #3d3d3d !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;

        }

        .table tbody td {
            border-right: 1px solid #ddd !important;
        }




        .btn-mini {
            font-size: 12px;
            padding: 4px 8px;
        }

        .btn-mini i {
            font-size: 14px;
        }

        .form-check-input:checked {
            background-color: #4a5644 !important;
            border-color: #4a5644 !important;
        }

        .modal-dashboard {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0,0,0,0.6);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 20px;
        }

        .dashboard-graficos {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card-dashboard {
            background: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .dashboard-resumo {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-card {
            background: #f8f9fa;
            border-left: 4px solid #4e6344;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .info-card .label {
            font-size: 12px;
            color: #777;
            display: block;
        }

        .info-card strong {
            font-size: 16px;
            color: #333;
        }


        .modal-body {
            max-height: 70vh;   /* ocupa até 70% da altura da tela */
            overflow-y: auto;  /* scroll vertical */
        }

        .resumo-bloco {
            background: #ffffff;
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.06);
            margin-bottom: 18px;
        }

        .resumo-titulo {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .resumo-bloco .info-card {
            margin-bottom: 10px;
        }

        .resumo-bloco .info-card:last-child {
            margin-bottom: 0;
        }

        .modal-conteudo {
            background: #fff;
            width: 45%;
            max-width: auto;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }

        .fechar {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            cursor: pointer;
        }

        .info-btn {
            border: none;
            background: transparent;
            padding: 0;
            margin-left: 6px;
            color: #0f6bbb;
            cursor: pointer;
        }

        .info-btn:hover {
            color: #084298;
        }



    </style>

</head>
<body>

    <!-- SIDEBAR -->
    <div id="sidebar">
        <div class="menu-icon" onclick="abrirPainel('propriedades')">
            <i class="bi bi-house-door fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('irrigacao')">
            <i class="bi bi-droplet fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('cultivo')">
            <i class="bi bi-feather2 fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('energia')">
            <i class="bi bi-lightning fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('compilado')">
            <i class="bi bi-graph-up fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('anotacoes')">
            <i class="bi bi-journal-text fs-3"></i>
        </div>
        <div class="menu-icon" onclick="abrirPainel('siad')">
            <i class="bi bi-speedometer2 fs-3"></i>
        </div>

    </div>

    <!-- PAINEL -->
    <div id="painel">
        <div id="painel-dinamico">
            <!-- carregado dinamicamente -->
        </div>
    </div>

    <!-- MAPA -->
    <div id="map"></div>

    <!-- GOOGLE MAPS -->
    <script>
        let map;
        let poligonoAtivo = null;

        /* ============================
        FUNÇÃO PRINCIPAL DO MAPA
        ============================ */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -30.348, lng: -55.52 },
                zoom: 11
            });
        }

        /* ===============================
        CARREGAR POLÍGONO POR CAR (API)
        =============================== */
        function carregarPoligonoPorCAR(car) {

            fetch("get_poligono.php?car=" + car)
                .then(r => r.json())
                .then(poligonos => {

                    // Remove o polígono anterior
                    if (poligonoAtivo) {
                        poligonoAtivo.setMap(null);
                        poligonoAtivo = null;
                    }

                    if (!poligonos || poligonos.length === 0) {
                        alert("Nenhum polígono cadastrado para esta propriedade.");
                        return;
                    }

                    // Pega o primeiro polígono (se tiver mais, adicionamos depois)
                    const poly = poligonos[0];

                    const coords = poly.coordinates[0].map(c => ({
                        lng: c[0],
                        lat: c[1]
                    }));

                    poligonoAtivo = new google.maps.Polygon({
                        paths: coords,
                        strokeColor: "#0d5a37",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#0d5a37",
                        fillOpacity: 0.35,
                    });

                    poligonoAtivo.setMap(map);

                    // Centralizar na área
                    const bounds = new google.maps.LatLngBounds();
                    coords.forEach(c => bounds.extend(c));
                    map.fitBounds(bounds);
                });
        }

        /* =================================
        CHAMA O POLÍGONO QUANDO SELECIONA
        ================================= */
        function carregarPropriedadeSelecionada() {
            const car = document.getElementById("selectPropriedade").value;

            const btn = document.getElementById("btnLimparSelecao");
            if (btn) btn.classList.remove("d-none");
            carregarPoligonoPorCAR(car);
        }

        /* Resetar visão */
        function limparView() {
            map.setCenter({ lat: -30.348, lng: -55.52 });
            map.setZoom(11);

            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }
        }
    </script>

    <!-- IRRIGAÇÃO -->
    <script>
        function carregarIrrigacao(car) {

            // Mostrar botão limpar
            document.getElementById("btnLimparIrrigacao").classList.remove("d-none");

            // Limpa polígono anterior
            if (window.polygonIrrigacao) {
                window.polygonIrrigacao.setMap(null);
                window.polygonIrrigacao = null;
            }

            // Limpa marcador anterior
            if (window.markerIrrigacao) {
                window.markerIrrigacao.setMap(null);
                window.markerIrrigacao = null;
            }

            fetch("carregar_irrigacao.php?car=" + car)
            .then(r => r.json())
            .then(data => {

                if (data.erro || data.quantidade === 0) {
                    alert("Nenhum dado encontrado para este CAR.");
                    return;
                }

                // Sempre usar o primeiro registro
                let info = data.registros[0];

                // Montar tabela mês / vazão / área / volume
                let linhas = "";

                data.registros.forEach(r => {
                    linhas += `
                        <tr>
                            <td>${r.mes}</td>
                            <td>${r.vazao_m3_h} m³/h</td>
                            <td>${r.area_irrigada_m2} m²</td>
                            <td>${r.volume_total_m3} m³</td>
                        </tr>
                    `;
                });


                let box = document.getElementById("dadosIrrigacao");
                box.classList.remove("d-none");

                box.innerHTML = `
                    <hr>
                    <p class='subtitulo-secao'>DADOS GERAIS CADASTRADOS</p>

                    <div class='dado-secao'>Volume Total de Água: <strong>${info.volume_total_m3}</strong> m³</div>
                    <div class='dado-secao'>Área Irrigada: <strong>${info.area_irrigada_m2}</strong> m²</div>

                    <hr>

                    <p class='subtitulo-secao'>HISTÓRICO DE MEDIÇÕES</p>

                    <div style="margin-bottom: 10px;">
                        <label><input type="checkbox" class="filtro-metodo form-check-input" value="pivo" checked> Pivô</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-metodo form-check-input" value="inundacao" checked> Inundação</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-metodo form-check-input" value="outros" checked> Outros</label>
                    </div>

                    <div class="metric-box" style="max-width: 100%; max-height: 200px; overflow-y: auto; overflow-x: auto;">
                        <table class="table table-sm mt-2 mb-0" style="white-space: nowrap;">
                            <thead class="table-light">
                                <tr>
                                    <th class='subtitulo-secao'>Mês</th>
                                    <th class='subtitulo-secao'>Vazão</th>
                                    <th class='subtitulo-secao'>Área</th>
                                    <th class='subtitulo-secao'>Volume</th>
                                    <th class='subtitulo-secao'>Método</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyIrrigacao">
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <p class='subtitulo-secao'>ESTATÍSTICAS MÉTODO x ÁREA</p>
                    <div style="width: 260px;">
                        <canvas id="graficoMetodoArea"></canvas>
                    </div>



                    <hr>
                    <img src="img/siad_eire.png" style="width:160px; display:block; margin:auto;">
                `;

            let registrosIrrigacao = data.registros;
            
        
            // Função para renderizar tabela
            function renderTabela() {
                let selecionados = [...document.querySelectorAll(".filtro-metodo:checked")].map(c => c.value);

                let html = "";

                registrosIrrigacao.forEach(r => {
                    let categoria = categoriaMetodo(r.metodo);

                    if (!selecionados.includes(categoria)) return;

                    html += `
                        <tr>
                            <td>${r.mes}</td>
                            <td>${r.vazao_m3_h} m³/h</td>
                            <td>${r.area_irrigada_m2} m²</td>
                            <td>${r.volume_total_m3} m³</td>
                            <td>${r.metodo}</td>
                        </tr>
                    `;
                });

                document.getElementById("tbodyIrrigacao").innerHTML = html;
            }

            // Primeira renderização
            renderTabela();

            // ===========================
            // GRÁFICO DE PIZZA 
            // ===========================

            let ctx = document.getElementById("graficoMetodoArea").getContext("2d");
            let graficoMetodo;

            function criarGraficoMetodo() {

                // Soma das áreas agrupadas por método
                let soma = { pivo: 0, inundacao: 0, outros: 0 };

                registrosIrrigacao.forEach(r => {
                    let categoria = categoriaMetodo(r.metodo);
                    soma[categoria] += Number(r.area_irrigada_m2);
                });

                // Destroi gráfico anterior
                if (graficoMetodo) graficoMetodo.destroy();

                graficoMetodo = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: ["Pivô", "Inundação", "Outros"],
                        datasets: [{
                            data: [soma.pivo, soma.inundacao, soma.outros],

                            // Somente tons de azul
                            backgroundColor: [
                                "#0f6bbbff",  // Azul médio
                                "#42A5F5",  // Azul claro
                                "#bcd9f0ff"   // Azul muito claro
                            ],

                            borderColor: "#ffffff",
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: "right",   // ← Legenda ao lado
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: "circle",
                                    boxWidth: 12,
                                    boxHeight: 12
                                }
                            }
                        }
                    }
                });
            }

            criarGraficoMetodo();



            // Eventos dos checkboxes
            document.querySelectorAll(".filtro-metodo").forEach(cb => {
                cb.addEventListener("change", renderTabela);
                });

                // Carregar polígono da propriedade
                carregarPoligonoPorCAR(car);
            });

        }  

        function categoriaMetodo(m) {
            let texto = m.toLowerCase();

            if (texto.includes("pivô") || texto.includes("pivo")) {
                return "pivo";
            }
            if (texto.includes("inund") || texto.includes("alag")) {
                return "inundacao";
            }
            return "outros";
        }

    </script>

    <!-- CULTIVO -->
    <script>
        function carregarCultivo(car) {

            document.getElementById("btnLimparCultivo").classList.remove("d-none");

            // Limpar polígono e marcador anteriores
            if (window.polygonCultivo) { window.polygonCultivo.setMap(null); window.polygonCultivo = null; }
            if (window.markerCultivo) { window.markerCultivo.setMap(null); window.markerCultivo = null; }

            fetch("carregar_cultivo.php?car=" + car)
            .then(r => r.json())
            .then(data => {

                if (!data.registros || data.registros.length === 0) {
                    alert("Nenhum dado de cultivo encontrado para este CAR.");
                    return;
                }

                let registrosCultivo = data.registros;
                let info = registrosCultivo[0];

                let box = document.getElementById("dadosCultivo");
                box.classList.remove("d-none");

                // Construir tabela
                let linhas = "";
                registrosCultivo.forEach(r => {
                    linhas += `
                        <tr>
                            <td>${r.mes_ini}</td>
                            <td>${r.area_cultivada_m2} m²</td>
                            <td>${r.produtividade_kg} kg</td>
                            <td>${r.tipo_cultura}</td>
                            <td>${r.observacoes ?? "-"}</td>
                        </tr>
                    `;
                });

                // ===============================
                // INSERIR HTML COM CHECKBOXES
                // ===============================
                box.innerHTML = `
                    <hr>
                    <p class='subtitulo-secao'>INFORMAÇÕES DE CULTIVO</p>

                    <div class='dado-secao'>Produtividade: <strong>${info.produtividade_kg}</strong> Kg</div>
                    <div class='dado-secao'>Área Cultivada: <strong>${info.area_cultivada_m2}</strong> m²</div>

                    <hr>

                    <p class='subtitulo-secao'>HISTÓRICO DE CULTIVOS</p>

                    <div style="margin-bottom: 10px; text-align: center;">
                        <label><input type="checkbox" class="filtro-cultura form-check-input" value="soja" checked> Soja</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-cultura form-check-input" value="arroz" checked> Arroz</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-cultura form-check-input" value="azevem" checked> Azevém</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-cultura form-check-input" value="pastagens" checked> Pastagens</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-cultura form-check-input" value="outros" checked> Outros</label>
                    </div>

                    <div class="metric-box" style="max-width:100%; max-height:200px; overflow-y:auto;">
                        <table class="table table-sm mt-2 mb-0" style="white-space:nowrap;">
                            <thead class="table-light">
                                <tr>
                                    <th>Mês</th>
                                    <th>Área</th>
                                    <th>Produtividade</th>
                                    <th>Cultura</th>
                                    <th>Obs</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCultivo">
                                ${linhas}
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <p class='subtitulo-secao'>ESTATÍSTICAS CULTIVO X ÁREA</p>
                    <div style="width:260px;">
                        <canvas id="graficoCultivoArea"></canvas>
                    </div>

                    <hr>
                    <img src="img/siad_eire.png" style="width:160px; display:block; margin:auto;">
                `;

                // ===============================
                // FILTRAR TABELA PELOS CHECKBOXES
                // ===============================
                function categoriaCultura(nome) {
                    nome = nome.toLowerCase();

                    if (nome.includes("soja")) return "soja";
                    if (nome.includes("arroz")) return "arroz";
                    if (nome.includes("azev")) return "azevem";
                    if (nome.includes("pasta") || nome.includes("pastagem")) return "pastagens";
                    return "outros";
                }

                function renderTabelaCultivo() {
                    let selecionados = [...document.querySelectorAll(".filtro-cultura:checked")].map(c => c.value);

                    let html = "";

                    registrosCultivo.forEach(r => {
                        let cat = categoriaCultura(r.tipo_cultura);
                        if (!selecionados.includes(cat)) return;

                        html += `
                            <tr>
                                <td>${r.mes_ini}</td>
                                <td>${r.area_cultivada_m2} m²</td>
                                <td>${r.produtividade_kg ? r.produtividade_kg : 0} kg</td>
                                <td>${r.tipo_cultura}</td>
                                <td>${r.observacoes ?? "-"}</td>
                            </tr>
                        `;
                    });

                    document.getElementById("tbodyCultivo").innerHTML = html;
                }

                renderTabelaCultivo();

                document.querySelectorAll(".filtro-cultura").forEach(cb =>
                    cb.addEventListener("change", renderTabelaCultivo)
                );

                // ===============================
                // GRÁFICO DE CULTIVO
                // ===============================
                let ctx = document.getElementById("graficoCultivoArea").getContext("2d");
                let graficoCultivo;

                function criarGraficoCultivo() {
                    let soma = { soja: 0, arroz: 0, azevem: 0, pastagens: 0, outros: 0 };

                    registrosCultivo.forEach(r => {
                        let categoria = categoriaCultura(r.tipo_cultura);
                        soma[categoria] += Number(r.area_cultivada_m2);
                    });

                    if (graficoCultivo) graficoCultivo.destroy();

                    graficoCultivo = new Chart(ctx, {
                        type: "pie",
                        data: {
                            labels: ["Soja", "Arroz", "Azevém", "Pastagens", "Outros"],
                            datasets: [{
                                data: [
                                    soma.soja,
                                    soma.arroz,
                                    soma.azevem,
                                    soma.pastagens,
                                    soma.outros
                                ],
                                backgroundColor: [
                                    "#e67009ff",
                                    "#ff9203ff",
                                    "#eb9147ff",
                                    "#d06813ff",
                                    "#f7a579ff"
                                ],
                                borderColor: "#fff",
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: "right",
                                    labels: { usePointStyle: true, pointStyle: "circle" }
                                }
                            }
                        }
                    });
                }

                criarGraficoCultivo();

                carregarPoligonoPorCAR(car);
            });
        }

    </script>  

    <!-- ENERGIA -->
    <script>
        function carregarEnergia(car) {

        document.getElementById("btnLimparEnergia").classList.remove("d-none");

        // limpar marcador/polígono anterior
        if (window.polygonEnergia) { window.polygonEnergia.setMap(null); window.polygonEnergia = null; }
        if (window.markerEnergia) { window.markerEnergia.setMap(null); window.markerEnergia = null; }

        fetch("carregar_energia.php?car=" + car)
            .then(r => r.json())
            .then(data => {

                if (!data.registros || data.registros.length === 0) {
                    alert("Nenhum dado de energia encontrado para este CAR.");
                    return;
                }

                let registros = data.registros;
                window.registrosEnergia = registros;
                let info = registros[0];

                let box = document.getElementById("dadosEnergia");
                box.classList.remove("d-none");

                // linhas da tabela
                let linhas = "";
                registros.forEach(r => {
                    linhas += `
                        <tr>
                            <td>${r.mes}</td>
                            <td style="white-space: nowrap;">${r.consumo_kwh} kWh</td>
                            <td>${Number(r.custo_total).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}</td>
                            <td>${r.atividade}</td>
                        </tr>
                    `;
                });

                // inserir conteúdo
                box.innerHTML = `
                    <hr>
                    <p class='subtitulo-secao'>INFORMAÇÕES DE ENERGIA</p>

                    <div class='dado-secao'>
                        Custo Total: 
                        <strong>
                            ${Number(info.custo_total).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}
                        </strong>
                    </div>

                    <div class='dado-secao'>Consumo Total: <strong>${info.consumo_kwh ?? 0} kWh</strong></div>

                    <hr>

                    <p class='subtitulo-secao'>HISTÓRICO DE CONSUMO</p>

                    <div style="margin-bottom: 10px; text-align: center;">
                        <label><input type="checkbox" class="filtro-energia form-check-input" value="cultivo" checked> Cultivo</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-energia form-check-input" value="irrigacao" checked> Irrigação</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-energia form-check-input" value="iluminacao" checked> Iluminação</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-energia form-check-input" value="maquinario" checked> Maquinário</label>
                        <label style="margin-left: 15px;"><input type="checkbox" class="filtro-energia form-check-input" value="outros" checked> Outros</label>
                    </div>

                    <div class="metric-box" style="max-width:100%; max-height:200px; overflow-y:auto;">
                        <table class="table table-sm mt-2 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mês</th>
                                    <th>Consumo</th>
                                    <th>Custo</th>
                                    <th>Atividade</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyEnergia">${linhas}</tbody>
                        </table>
                    </div>

                    <hr>

                    <p class='subtitulo-secao'>ESTATÍSTICAS CONSUMO x ATIVIDADE</p>
                    <canvas id="graficoEnergiaPizza"></canvas>

                    <hr>
                    <img src="img/siad_eire.png" style="width:160px; display:block; margin:auto;">
                `;

                // função de categorizar atividades
                function categoriaEnergia(nome) {
                    nome = nome.toLowerCase();
                    if (nome.includes("cult")) return "cultivo";
                    if (nome.includes("irrig")) return "irrigacao";
                    if (nome.includes("ilumi")) return "iluminacao";
                    if (nome.includes("maq")) return "maquinario";
                    return "outros";
                }

                // FILTRAR TABELA
                function renderTabelaEnergia() {
                    let selecionados = [...document.querySelectorAll(".filtro-energia:checked")].map(c => c.value);

                    let html = "";
                    registros.forEach(r => {
                        let cat = categoriaEnergia(r.atividade);
                        if (!selecionados.includes(cat)) return;

                        html += `
                            <tr>
                                <td>${r.mes}</td>
                                <td style="white-space: nowrap;">${r.consumo_kwh} kWh</td>
                                <td>${Number(r.custo_total).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}</td>
                                <td>${r.atividade}</td>
                            </tr>
                        `;
                    });

                    document.getElementById("tbodyEnergia").innerHTML = html;
                }

                renderTabelaEnergia();
                

                document.querySelectorAll(".filtro-energia").forEach(cb =>
                    cb.addEventListener("change", renderTabelaEnergia)
                );

                // GRÁFICO DE CONSUMO x ATIVIDADE
                let ctx = document.getElementById("graficoEnergiaPizza").getContext("2d");
                let graficoEnergiaPizza;

                function criarGraficoEnergiaPizza() {

                    let soma = { cultivo: 0, irrigacao: 0, iluminacao: 0, maquinario: 0, outros: 0 };

                    registros.forEach(r => {
                        let cat = categoriaEnergia(r.atividade);
                        soma[cat] += Number(r.consumo_kwh ?? 0);
                    });

                    if (graficoEnergiaPizza) graficoEnergiaPizza.destroy();

                    graficoEnergiaPizza = new Chart(ctx, {
                        type: "pie",
                        data: {
                            labels: ["Cultivo", "Irrigação", "iluminação", "Maquinário", "Outros"],
                            datasets: [{
                                data: [
                                    soma.cultivo,
                                    soma.irrigacao,
                                    soma.iluminacao,
                                    soma.maquinario,
                                    soma.outros
                                ],
                                backgroundColor: [
                                    "#ffc800ff",
                                    "#c79d10ff",
                                    "#8a6f0bff",
                                    "#e6c960ff",
                                    "#ede2b9ff"
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: "right",
                                    labels: { usePointStyle: true, pointStyle: "circle" }
                                }
                            }
                        }
                    });
                }

                criarGraficoEnergiaPizza();
                


                carregarPoligonoPorCAR(car);
            });
        }
    </script>

    <!-- COMPILADO -->   
    <script>
        function carregarCompilado(car) {

            console.log("carregarCompilado() → CAR selecionado:", car);

            // Mostrar botão de limpar
            document.getElementById("btnLimparCompilado").classList.remove("d-none");

            // Limpa bloco anterior
            let box = document.getElementById("dadosCompilado");
            box.innerHTML = "";
            box.classList.remove("d-none");

            fetch("carregar_compilado.php?car=" + car)
                .then(r => r.json())
                .then(data => {

                    console.log("Retorno compilado:", data);

                    if (data.erro || !data.compilado) {
                        box.innerHTML = "<p style='color:red;'>Nenhum dado compilado encontrado.</p>";
                        return;
                    }

                    let c = data.compilado;

                    // Monta HTML
                    box.innerHTML = `
                        <hr>
                        <p class='subtitulo-secao'>DADOS COMPILADOS</p>

                        <div id="blocoDadosPDF">
                            <span id="nomePropriedadeCompilado">${c.nome_propriedade}</span>

                            <div class='dado-secao'>
                                CAR: <strong id="carPropriedadeCompilado">${c.car}</strong>
                            </div>

                            <div class='dado-secao'>Ano: <strong>${c.ano}</strong></div>

                            <div class='dado-secao'>
                                Área Total: <strong>${Number(c.area_total_ha).toLocaleString("pt-BR")} ha</strong>
                            </div>

                            <div class='dado-secao'>
                                Área Irrigada Total:
                                <strong>${Number(c.area_irrigada_total_m2).toLocaleString("pt-BR")} m²</strong>
                            </div>

                            <div class='dado-secao'>
                                Volume de Água Total:
                                <strong>${Number(c.volume_agua_total_m3).toLocaleString("pt-BR")} m³</strong>
                            </div>

                            <div class='dado-secao'>
                                Energia Consumida Total:
                                <strong>${Number(c.energia_consumida_kwh).toLocaleString("pt-BR")} kWh</strong>
                            </div>

                            <div class='dado-secao'>
                                Produtividade Total:
                                <strong>${Number(c.produtividade_total_kg).toLocaleString("pt-BR")} kg</strong>
                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <button class="btn btn-success btn-mini mb-3" onclick="baixarPDFCompilado()">
                                <i class="bi bi-file-earmark-arrow-down"></i> Baixar PDF
                            </button>
                        </div>


                        <hr>
                        <img src="img/siad_eire.png" style="width:160px; display:block; margin:auto;">
                    `;

                })
                .catch(err => {
                    console.error("ERRO carregarCompilado():", err);
                    box.innerHTML = "<p style='color:red;'>Erro ao carregar os dados.</p>";
                });
                
            carregarPoligonoPorCAR(car);
        }
    </script>

    <!-- PDF -->
    <script>
        async function baixarPDFCompilado() {

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();

            const logo = "img/siad_eire.png";

            // Carregar logo como base64
            const getBase64 = url => fetch(url)
                .then(r => r.blob())
                .then(blob => new Promise(res => {
                    const reader = new FileReader();
                    reader.onloadend = () => res(reader.result);
                    reader.readAsDataURL(blob);
                }));

            const logoBase64 = await getBase64(logo);

            // Título
            pdf.setFontSize(18);
            pdf.text("DADOS COMPILADOS", 105, 20, { align: "center" });

            // Logo
            pdf.addImage(logoBase64, "PNG", 75, 25, 60, 25);

            pdf.setFontSize(12);

            // PEGANDO Nome e CAR da tela
            const nomeFazenda = document.getElementById("nomePropriedadeCompilado")?.innerText || "";
            const carFazenda  = document.getElementById("carPropriedadeCompilado")?.innerText || "";

            let y = 60;

            // Adiciona no PDF
            if (nomeFazenda) {
                pdf.text("Propriedade: " + nomeFazenda, 20, y);
                y += 8;
            }

            if (carFazenda) {
                pdf.text("CAR: " + carFazenda, 20, y);
                y += 12;
            }

            // DADOS COMPILADOS
            let dados = document.querySelector("#blocoDadosPDF").innerText.split("\n");


            dados.forEach(linha => {
                if (linha.trim() !== "") {
                    pdf.text(linha.trim(), 20, y);
                    y += 8;
                }
            });

            pdf.save("dados_compilados.pdf");
        }
    </script>

    <!-- ANOTAÇÕES -->
    <script>
        function CarregarNotas() {
            fetch("anotacoes_carregar.php")
                .then(r => r.json())
                .then(data => {

                    let box = document.getElementById("listaAnotacoes");
                    box.innerHTML = "";

                    if (!data || data.length === 0) {
                        box.innerHTML = "<p>Nenhuma anotação encontrada.</p>";
                        return;
                    }

                    data.forEach(nota => {

                        let extra = nota.car 
                            ? `<div><strong>Propriedade:</strong> ${nota.car}</div>`
                            : `<div><em>Anotação geral</em></div>`;

                        box.innerHTML += `
                            <div class="card-anotacao">
                                ${extra}
                                <div>${nota.anotacao}</div>
                                <small style="color:#666;">${nota.data_criacao}</small>
                            </div>
                        `;
                    });
                });
        }



        function salvarNota() {

            let texto = document.getElementById("campoNota").value.trim();
            let car = document.getElementById("selectPropriedadeNota").value;

            if (texto === "") {
                alert("Digite algo antes de salvar!");
                return;
            }

            fetch("anotacoes_salvar.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ anotacao: texto, car: car })
            })
            .then(r => r.json())
            .then(data => {

                if (!data.erro) {

                    document.getElementById("campoNota").value = "";
                    document.getElementById("selectPropriedadeNota").value = "";

                    CarregarNotas();

                } else {
                    alert("Erro ao salvar.");
                }
            });
        }

    </script>

    <!-- SIAD -->
    <script>
        function carregarSIAD(car) {

            const box = document.getElementById("dadosSIAD");
            box.innerHTML = "Carregando dados do SIAD...";
            box.classList.remove("d-none");

            // Mostrar botão de limpar
            document.getElementById("btnLimparSIAD").classList.remove("d-none");


            fetch(`carregar_siad.php?car=${car}`)
                .then(r => r.json())
                .then(data => {

                    if (data.erro) {
                        box.innerHTML = "<p>Erro ao carregar dados do SIAD</p>";
                        return;
                    }

                    const registros = data.registros_siad;

                    // --- IRRIGAÇÃO ---
                    const totalVolume = registros.irrigacao.reduce((t,r)=> t + Number(r.volume_total_m3), 0);
                    const totalArea   = registros.irrigacao.reduce((t,r)=> t + Number(r.area_irrigada_m2), 0);

                    const areaPorMetodo = {};
                    registros.irrigacao.forEach(r=>{
                        areaPorMetodo[r.metodo] =
                            (areaPorMetodo[r.metodo] || 0) + Number(r.area_irrigada_m2);
                    });

                    // --- CULTIVO ---
                    const produtividadePorCultura = {};
                    registros.cultivo.forEach(r=>{
                        produtividadePorCultura[r.tipo_cultura] =
                            (produtividadePorCultura[r.tipo_cultura] || 0) + Number(r.produtividade_kg);
                    });

                    const cultivoPrincipal = Object.entries(produtividadePorCultura)
                        .sort((a,b)=> b[1] - a[1])[0];

                    const produtividadeTotal = Object.values(produtividadePorCultura)
                        .reduce((a,b)=> a + b, 0);

                    // --- ENERGIA ---
                    const custoTotal = registros.energia.reduce((t,r)=> t + Number(r.custo_total), 0);

                    const tiposRede = {};
                    registros.energia.forEach(r=>{
                        tiposRede[r.fonte] = (tiposRede[r.fonte] || 0) + 1;
                    });

                    const tipoRedePredominante =
                        Object.entries(tiposRede).sort((a,b)=> b[1] - a[1])[0][0];

                    // --- INDICADORES ---
                    const prodPorM3  = totalVolume ? (produtividadeTotal / totalVolume).toFixed(2) : 0;
                    const custoPorM3 = totalVolume ? (custoTotal / totalVolume).toFixed(2) : 0;
                    const custoPorKg = produtividadeTotal ? (custoTotal / produtividadeTotal).toFixed(2) : 0;
                    const indicadorIntegrado = custoTotal ? (produtividadeTotal / custoTotal).toFixed(2): 0;


                    // --- HTML ---
                    box.innerHTML = `
                        <hr>

                        <h6 class="subtitulo-secao">
                            <i class="bi bi-droplet"></i> IRRIGAÇÃO
                            <button class="btn btn-sm btn-link ms-2" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-title="Irrigação"
                                data-bs-content="Avalia o uso da água na propriedade e sua eficiência produtiva.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </h6>

                        <div class="dado-secao">
                            Volume total: <strong>${totalVolume.toLocaleString()} m³</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Quantidade total de água efetivamente utilizada no período analisado.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <div class="dado-secao">
                            Área irrigada: <strong>${(totalArea/10000).toLocaleString()} ha</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Dimensão real da área atendida pelos sistemas de irrigação.">
                            <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <div class="dado-secao" style="background:${corAlerta(prodPorM3,[0.8,0.5])}">
                            Eficiência hídrica: <strong>${prodPorM3} kg/m³</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Indica se a água aplicada está gerando retorno produtivo adequado. Valores baixos sugerem desperdício ou manejo ineficiente.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <hr>

                        <!--CULTIVO -->
                        <h6 class="subtitulo-secao">
                            <i class="bi bi-feather2 fs-3"></i> CULTIVO
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Indicadores relacionados à produção agrícola da propriedade.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </h6>

                        <div class="dado-secao">
                            Cultura principal: <strong>${cultivoPrincipal[0]}</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Cultura com maior impacto produtivo no período analisado.">
                            <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <div class="dado-secao">
                            Produtividade total: <strong>${cultivoPrincipal[1].toLocaleString()} kg</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Quantidade total produzida da cultura principal.">
                            <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <hr>

                        <!--ENERGIA -->
                        <h6 class="subtitulo-secao">
                            <i class="bi bi-lightning"></i> ENERGIA
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Indicadores econômicos e energéticos associados à produção.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </h6>

                        <div class="dado-secao" style="background:${corAlertaCusto(custoPorM3,[5,10])}">
                            Custo por m³ irrigado: <strong>R$ ${custoPorM3}</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Quanto custa energeticamente cada metro cúbico de água aplicado.">
                            <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        

                        <div class="dado-secao" style="background:${corAlertaCusto(custoPorKg,[2,5])}">
                            Custo por kg produzido: <strong>R$ ${custoPorKg}</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Indicador econômico direto da eficiência produtiva.">
                            <i class="bi bi-info-circle"></i>
                            </button>
                        </div>


                        <hr>

                        <!-- INTEGRADO -->
                        <h6>
                            <i class="bi bi-pin-map"></i> INDICADOR INTEGRADO
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Integra água, energia e produção para apoio direto à tomada de decisão.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </h6>

                        <div class="dado-secao" style="background:${corAlertaCusto(indicadorIntegrado,[3,1])}">
                            Eficiência global: <strong>${indicadorIntegrado} kg/R$</strong>
                            <button class="btn btn-sm btn-link" style="color: #4e6344 "
                                data-bs-toggle="popover"
                                data-bs-content="Relação direta entre água, energia e produção — principal métrica integrada de decisão.">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </div>

                        <hr>

                        <div class="text-end mt-3">
                            <button class="btn btn-sm btn-outline-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalCriteriosAlerta">
                                <i class="bi bi-exclamation-triangle"></i> Critérios de alerta
                            </button>
                        </div>

                    `;

                    // ATIVA OS POPOVERS (IMPORTANTE)
                    ativarPopovers();
                    carregarPoligonoPorCAR(car);

                });
        }


        function corAlerta(valor, thresholds) {
            // thresholds = [verde, amarelo] → vermelho se passar do amarelo
            if(valor >= thresholds[0]) return "#d4edda"; // verde claro
            if(valor >= thresholds[1]) return "#fff3cd"; // amarelo claro
            return "#f8d7da"; // vermelho claro
        }

        function corAlertaCusto(valor, thresholds) {
            // thresholds = [verde, amarelo] → vermelho se passar do amarelo
            if(valor <= thresholds[0]) return "#d4edda"; // verde
            if(valor <= thresholds[1]) return "#fff3cd"; // amarelo
            return "#f8d7da"; // vermelho
        }


        


     
    </script>


    <!-- CARREGAR API DO GOOGLE MAPS -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzpbw3PP6eCuB37ZwY1jyth9h-2Pkbt7M&callback=initMap">
    </script>

    <!-- JS DO MENU DINÂMICO -->
    <script> 
        function abrirPainel(area) {
            // ------- PARTE 1: monta o layout base -------
            let painel = document.getElementById("painel-dinamico");

            painel.innerHTML = "<p>Carregando...</p>";

            fetch("carregar_dados.php?area=" + area)
            .then(r => r.json())
            .then(data => {
                if (area === "propriedades") {
                    let html = `
                        <div class='titulo-secao'>PROPRIEDADES RURAIS</div>

                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class='subtitulo-secao'>SELECIONAR PROPRIEDADE</label> 
                        <button id="btnLimparSelecao" 
                                class="btn btn-secondary btn-mini mb-3 d-none"
                                onclick="limparSelecaoPropriedade()">
                            <i class="bi bi-eraser"></i>
                        </button>



                        <select class="form-select mb-3" id="selectPropriedade" onchange="carregarPropriedadeSelecionada()">
                            <option disabled selected>Selecione...</option>
                    `;

                    data.propriedades.forEach(p => {
                        html += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                    });

                    html += `</select>

                        <hr>

                        <p class='subtitulo-secao'>ESPECIFICAÇÕES</p>

                        <div class="metric-box" style="max-width: 100%; max-height: 200px; overflow-y: auto; overflow-x: auto;">
                            <table class="table table-sm mt-2 mb-0" style="white-space: nowrap; ">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class='subtitulo-secao'>Propriedade</th>
                                        <th scope="col" class='subtitulo-secao'>CAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    data.propriedades.forEach(p => {
                        html += `<tr scope="col"><td>${p.nome_propriedade}</td><td>${p.car}</td></tr>`;
                    });

                    html += `
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <p class='subtitulo-secao'>DADOS GERAIS CADASTRADOS</p>

                        <div class='dado-secao'>Total de Propriedades: <strong>${data.total_propriedades}</strong></div>
                        <div class='dado-secao'>Área Cadastrada: <strong>${data.total_area_m2.toLocaleString()}</strong> m²</div>
                        <div class='dado-secao'>Hectares Cadastrados: <strong>${data.total_area_ha}</strong></div>

                        <hr>
                        <div style="text-align: center;">
                            <img src="img/siad_eire.png" alt="SIAD" style="width:200px; height:auto;">
                        </div>
                    `;

                    painel.innerHTML = html;
                }

                // --- IRRIGAÇÃO --- //
                if (area === "irrigacao") {

                    let html = `
                        <div class='titulo-secao'>IRRIGAÇÃO</div>

                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class="subtitulo-secao">SELECIONAR PROPRIEDADE</label>

                        <!-- BOTÃO LIMPAR (inicialmente oculto) -->
                        <button id="btnLimparIrrigacao"
                                class="btn btn-secondary btn-mini mb-2 d-none"
                                onclick="limparIrrigacao()">
                            <i class="bi bi-eraser"></i>
                        </button>

                        <select class="form-select mb-3" id="selectIrrigacao" onchange="carregarIrrigacao(this.value)">
                            <option selected disabled>Selecione...</option>
                        </select>

                        <!-- Aqui os dados serão exibidos somente após selecionar -->
                        <div id="dadosIrrigacao" class="d-none"></div>
                    `;

                    painel.innerHTML = html; 

                    // Preencher propriedades no select
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let s = document.getElementById("selectIrrigacao");
                            prop.propriedades.forEach(p => {
                                s.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });
                }

                // --- CULTIVO --- //
                if (area === "cultivo") {

                    let html = `
                        <div class='titulo-secao'>CULTIVO</div>

                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class="subtitulo-secao">SELECIONAR PROPRIEDADE</label>

                        <!-- BOTÃO LIMPAR (inicialmente oculto) -->
                        <button id="btnLimparCultivo"
                                class="btn btn-secondary btn-mini mb-2 d-none"
                                onclick="limparCultivo()">
                            <i class="bi bi-eraser"></i>
                        </button>

                        <select class="form-select mb-3" id="selectCultivo" onchange="carregarCultivo(this.value)">
                            <option selected disabled>Selecione...</option>
                        </select>

                        <!-- Aqui os dados serão exibidos somente após selecionar -->
                        <div id="dadosCultivo" class="d-none"></div>
                    `;

                    painel.innerHTML = html; 

                    // Preencher propriedades no select
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let s = document.getElementById("selectCultivo");
                            prop.propriedades.forEach(p => {
                                s.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });
                }

                // --- ENERGIA --- //
                if (area === "energia") {

                    let html = `
                        <div class='titulo-secao'>ENERGIA</div>

                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class="subtitulo-secao">SELECIONAR PROPRIEDADE</label>

                        <!-- BOTÃO LIMPAR (inicialmente oculto) -->
                        <button id="btnLimparEnergia"
                                class="btn btn-secondary btn-mini mb-2 d-none"
                                onclick="limparEnergia()">
                            <i class="bi bi-eraser"></i>
                        </button>

                        <select class="form-select mb-3" id="selectEnergia" onchange="carregarEnergia(this.value)">
                            <option selected disabled>Selecione...</option>
                        </select>

                        <!-- Aqui os dados serão exibidos somente após selecionar -->
                        <div id="dadosEnergia" class="d-none"></div>
                    `;

                    painel.innerHTML = html;

                    // Preencher propriedades no select
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let s = document.getElementById("selectEnergia");
                            prop.propriedades.forEach(p => {
                                s.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });
                }

                // --- COMPILADO --- //
                if (area === "compilado") {

                    let html = `
                        <div class='titulo-secao'>DADOS COMPILADOS</div>

                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class="subtitulo-secao">SELECIONAR PROPRIEDADE</label>

                        <button id="btnLimparCompilado"
                                class="btn btn-secondary btn-mini mb-2 d-none"
                                onclick="limparCompilado()">
                            <i class="bi bi-eraser"></i>
                        </button>

                        <select class="form-select mb-3" id="selectCompilado" onchange="carregarCompilado(this.value)">
                            <option selected disabled>Selecione...</option>
                        </select>

                        <div id="dadosCompilado" class="d-none"></div>
                    `;

                    painel.innerHTML = html;

                    // preencher select com propriedades
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let s = document.getElementById("selectCompilado");
                            prop.propriedades.forEach(p => {
                                s.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });
                }

                // --- ANOTAÇÕES --- //
                if (area === "anotacoes") {

                    let html = `
                        <div class='titulo-secao'>ANOTAÇÕES</div>

                        <hr>
                        <!--  VISUALIZAR TODAS AS PROPRIEDADES  -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodosNotas" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodosNotas">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class="subtitulo-secao">ADICIONE ANOTAÇÃO</label>

                        <div style="display:flex; gap:10px; align-items:center;">
                            <select id="selectPropriedadeNota" class="form-select" style="width:70%;">
                                <option value="">Anotação geral (sem propriedade)</option>
                            </select>

                            <button class="btn btn-success" onclick="salvarNota()" style="width:50px;">
                                <i class="bi bi-check-lg"></i>
                            </button>

                        </div>

                        <textarea id="campoNota" class="form-control mt-2" rows="4" placeholder="Faça sua anotação aqui..."></textarea>

                        <hr>

                        <p class="subtitulo-secao">SUAS ANOTAÇÕES:</p>

                        <div id="listaAnotacoes"></div>

                        <hr>
                        <div style="text-align:center;">
                            <img src="img/siad_eire.png" style="width:180px;">
                        </div>
                    `;

                    painel.innerHTML = html;

                    // Carregar lista de propriedades no select
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let sel = document.getElementById("selectPropriedadeNota");
                            prop.propriedades.forEach(p => {
                                sel.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });

                    // Carregar anotações do banco
                    CarregarNotas();
                }

                // --- SIAD --- //
                if (area === "siad") {

                    let html = `
                        <div class='titulo-secao'>SIAD</div>
                        <hr>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarTodos" onchange="mostrarTodasPropriedades(this.checked)">
                            <label class="form-check-label" for="mostrarTodos">
                                Visualizar todas as propriedades no mapa
                            </label>
                        </div>

                        <hr>

                        <label class='subtitulo-secao'>SELECIONAR PROPRIEDADE</label>

                        <button id="btnLimparSIAD"
                                class="btn btn-secondary btn-mini mb-2 d-none"
                                onclick="limparSIAD()">
                            <i class="bi bi-eraser"></i>
                        </button>

                        <select class="form-select mb-3" id="selectSIAD" onchange="carregarSIAD(this.value)">
                            <option selected disabled>Selecione...</option>
                        </select>

                        <div id="dadosSIAD" class="d-none"></div>

                        
                    `;

                    painel.innerHTML = html;

                    // Preencher propriedades no select
                    fetch("carregar_dados.php?area=propriedades")
                        .then(r => r.json())
                        .then(prop => {
                            let s = document.getElementById("selectSIAD");
                            prop.propriedades.forEach(p => {
                                s.innerHTML += `<option value="${p.car}">${p.nome_propriedade}</option>`;
                            });
                        });
                }
                
                
                // ---- FIM MENU ---- //

            });
        }
    </script>

    <script>
        window.onload = function () {
            abrirPainel('propriedades');
        };
    </script>

    <!-- JS DASHBOARD -->
    <script>
        let registros = [];
        let cultivos = [];

        function carregarDadosDashboard(car) {
            fetch(`carregar_dados.php?area=dashboard&car=${car}`)
                .then(r => r.json())
                .then(data => {
                    registros = data.registros || [];
                    cultivos = data.cultivos || [];
                });
        }

        function montarGraficoEnergiaBarra() {

            if (!registros || registros.length === 0) return;

            const canvas = document.getElementById("graficoEnergiaBarra");
            if (!canvas) return;

            const nomesMeses = [
                "Janeiro", "Fevereiro", "Março", "Abril",
                "Maio", "Junho", "Julho", "Agosto",
                "Setembro", "Outubro", "Novembro", "Dezembro"
            ];


            const consumoPorMes = {};

            registros.forEach(r => {
                const labelMes = nomesMeses[r.mes - 1];

                if (!consumoPorMes[labelMes]) {
                    consumoPorMes[labelMes] = 0;
                }

                consumoPorMes[labelMes] += Number(r.consumo_kwh || 0);
            });

            const labels = Object.keys(consumoPorMes);
            const dados  = Object.values(consumoPorMes);

            if (window.chartEnergiaBarra) {
                window.chartEnergiaBarra.destroy();
            }

            window.chartEnergiaBarra = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Consumo de Energia (kWh)',
                        backgroundColor: '#ffc10796',
                        borderColor: '#FFB300',
                        data: dados
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        }

        function montarGraficoIrrigacaoBarra() {

            if (!registros || registros.length === 0) return;

            const canvas = document.getElementById("graficoIrrigacaoBarra");
            if (!canvas) return;

           const nomesMeses = [
                "Janeiro", "Fevereiro", "Março", "Abril",
                "Maio", "Junho", "Julho", "Agosto",
                "Setembro", "Outubro", "Novembro", "Dezembro"
            ];


            const volumePorMes = {};

            registros.forEach(r => {
                const labelMes = nomesMeses[r.mes - 1];

                if (!volumePorMes[labelMes]) {
                    volumePorMes[labelMes] = 0;
                }

                volumePorMes[labelMes] += Number(r.volume_total_m3 || 0);
            });

            const labels = Object.keys(volumePorMes);
            const dadosIrrig  = Object.values(volumePorMes);

            if (window.chartIrrigacaoBarra) {
                window.chartIrrigacaoBarra.destroy();
            }

            window.chartIrrigacaoBarra = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Vomule de Água (m³)',
                        data: dadosIrrig
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        }

       function alimentarCardCultivo() {

            if (!cultivos || cultivos.length === 0) return;

            const mapa = {};

            cultivos.forEach(c => {
                if (!c.tipo_cultura) return;

                if (!mapa[c.tipo_cultura]) {
                    mapa[c.tipo_cultura] = {
                        produtividade: 0,
                        area: 0
                    };
                }

                mapa[c.tipo_cultura].produtividade += Number(c.produtividade_kg || 0);
                mapa[c.tipo_cultura].area += Number(c.area_cultivada_m2 || 0);
            });

            // pega o cultivo com MAIOR PRODUTIVIDADE
            const cultivoPrincipal = Object.entries(mapa)
                .sort((a, b) => b[1].produtividade - a[1].produtividade)[0];

            if (!cultivoPrincipal) return;

            const nomeCultivo = cultivoPrincipal[0];
            const dados = cultivoPrincipal[1];

            document.getElementById('infoCultivo').innerText = nomeCultivo;

            document.getElementById('infoProdutividade').innerText =
                dados.produtividade.toLocaleString('pt-BR') + ' kg';

            document.getElementById('infoArea').innerText =
                (dados.area / 10000).toLocaleString('pt-BR') + ' ha';
        }

        function alimentarCardCustoEnergia() {

            if (!registros || registros.length === 0) {
                document.getElementById('infoCustoEnergia').innerText = 'R$ 0,00';
                document.getElementById('infoRede').innerText = 'Não informado';
                return;
            }

            let custoTotal = 0;
            const fontes = {};

            registros.forEach(r => {
                custoTotal += Number(r.custo_total || 0);

                if (r.fonte) {
                    fontes[r.fonte] = (fontes[r.fonte] || 0) + 1;
                }
            });

            // Fonte mais frequente
            const fontePredominante = Object.entries(fontes)
                .sort((a, b) => b[1] - a[1])[0]?.[0] || 'Não informado';

            document.getElementById('infoCustoEnergia').innerText =
                custoTotal.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });

            document.getElementById('infoRede').innerText = fontePredominante;
        }

        function alimentarCardsIrrigacao() {

            if (!registros || registros.length === 0) {
                document.getElementById('infoAreaIrrigada').innerText = '0 ha';
                document.getElementById('infoMetodo').innerText = 'Não informado';
                return;
            }

            let areaTotal = 0;
            const areaPorMetodo = {};

            registros.forEach(r => {
                const area = Number(r.area_irrigada_m2 || 0);
                areaTotal += area;

                if (!r.metodo) return;

                areaPorMetodo[r.metodo] =
                    (areaPorMetodo[r.metodo] || 0) + area;
            });

            // método com MAIOR área irrigada
            const metodoPredominante = Object.entries(areaPorMetodo)
                .sort((a, b) => b[1] - a[1])[0]?.[0] || 'Não informado';

            document.getElementById('infoAreaIrrigada').innerText =
                (areaTotal / 10000).toLocaleString('pt-BR') + ' ha';

            document.getElementById('infoMetodo').innerText = metodoPredominante;
        }




        function abrirDashboard(car, nomePropriedade) {

            document.getElementById("tituloDashboard").innerText =
                `PROPRIEDADE – ${nomePropriedade}`;
            

            document.getElementById("modalDashboard").style.display = "block";

            carregarDadosDashboard(car);

            setTimeout(() => {
                montarGraficoIrrigacaoBarra();
                alimentarCardsIrrigacao();
            }, 300);

            setTimeout(() => {
                alimentarCardCultivo();
            }, 300);

            setTimeout(() => {
                alimentarCardCustoEnergia();
                montarGraficoEnergiaBarra();
            }, 300);
        }

        function fecharDashboard() {
            document.getElementById("modalDashboard").style.display = "none";
        }
    </script>

   
    <!-- FUNÇÃO: MOSTRAR MARCADORES -->
    <script>
        let marcadoresPropriedades = [];

        function mostrarTodasPropriedades(ativo) {

            // Limpa marcadores antigos
            marcadoresPropriedades.forEach(m => m.setMap(null));
            marcadoresPropriedades = [];

            if (!ativo) return; // Se desmarcou, apenas limpa

            // Buscar propriedades
            fetch("carregar_dados.php?area=propriedades")
                .then(r => r.json())
                .then(data => {

                    const bounds = new google.maps.LatLngBounds();

                    data.propriedades.forEach(p => {

                        let lat = parseFloat(p.latitude);
                        let lng = parseFloat(p.longitude);

                        if (!lat || !lng) return;

                        const iconVerde = {
                            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#4a5644" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7z"/>
                                    <circle cx="12" cy="9" r="3" fill="#b1cab1ff"/>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(40, 40),
                            anchor: new google.maps.Point(20, 40)
                        };

                        let marker = new google.maps.Marker({
                            position: { lat, lng },
                            map: map,
                            title: p.nome_propriedade,
                            icon: iconVerde
                        });

                        let popup = new google.maps.InfoWindow({
                            content: `
                                <div style="min-width:220px">
                                    <strong>${p.nome_propriedade}</strong><br>
                                    CAR: ${p.car}<br>
                                    Produtor: ${p.nome_produtor}<br>
                                    Município: ${p.municipio}<br><br>

                                    <button 
                                        onclick="abrirDashboard('${p.car}', '${p.nome_propriedade}')"
                                        style="
                                            padding:6px 10px;
                                            background:#4a5644;
                                            color:#fff;
                                            border:none;
                                            border-radius:4px;
                                            cursor:pointer;
                                            width:100%;
                                        ">
                                        <i class="bi bi-clipboard-data-fill"></i>  Informações
                                    </button>
                                </div>
                            `
                        });

                        marker.addListener("click", () => {
                            popup.open(map, marker);
                        });

                        marcadoresPropriedades.push(marker);
                        bounds.extend({ lat, lng });
                    });

                    // Ajusta zoom para todos os pontos
                    if (!bounds.isEmpty()) {
                        map.fitBounds(bounds);
                    }
                });
        }

        function limparSelecaoPropriedade() {
            const select = document.getElementById("selectPropriedade");
            select.selectedIndex = 0;

            // limpa o polígono ativo da propriedade
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            // limpa marcador ativo, se existir
            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }

            // reseta visão
            map.setCenter({ lat: -30.348, lng: -55.52 });
            map.setZoom(11);

            const btn = document.getElementById("btnLimparSelecao");
            if (btn) btn.classList.add("d-none");
        }

        function limparIrrigacao() {

            // Voltar select ao padrão
            const s = document.getElementById("selectIrrigacao");
            s.selectedIndex = 0;

            // Esconder botão
            document.getElementById("btnLimparIrrigacao").classList.add("d-none");

            // Esconder dados
            document.getElementById("dadosIrrigacao").classList.add("d-none");
            document.getElementById("dadosIrrigacao").innerHTML = "";

            // limpa o polígono ativo da propriedade
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            // limpa marcador ativo, se existir
            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }

            // reseta visão
            map.setCenter({ lat: -30.348, lng: -55.52 });
            map.setZoom(11);

            const btn = document.getElementById("btnLimparIrrigacao");
            if (btn) btn.classList.add("d-none");
        }

        function limparCultivo() {

            // Oculta dados
            document.getElementById("dadosCultivo").classList.add("d-none");
            document.getElementById("dadosCultivo").innerHTML = "";

            // Esconde botão limpar
            document.getElementById("btnLimparCultivo").classList.add("d-none");

            // Reseta select
            document.getElementById("selectCultivo").value = "Selecione...";

            // limpa o polígono ativo da propriedade
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            // limpa marcador ativo, se existir
            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }
        }

        function limparEnergia() {

            // Oculta dados
            document.getElementById("dadosEnergia").classList.add("d-none");
            document.getElementById("dadosEnergia").innerHTML = "";

            // Esconde botão limpar
            document.getElementById("btnLimparEnergia").classList.add("d-none");

            // Reseta select principal
            document.getElementById("selectEnergia").value = "Selecione...";

            // limpa o polígono ativo da propriedade (mesmo comportamento dos outros menus)
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            // limpa marcador ativo, se existir
            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }
        }

        function limparCompilado() {

            document.getElementById("dadosCompilado").innerHTML = "";
            document.getElementById("dadosCompilado").classList.add("d-none");

            document.getElementById("btnLimparCompilado").classList.add("d-none");

            // reset select
            document.getElementById("selectCompilado").value = "Selecione...";

            // limpa polígono e marcador caso existam
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }
        }

        // Função para limpar seleção SIAD
        function limparSIAD() {
            document.getElementById("selectSIAD").value = "";
            document.getElementById("dadosSIAD").classList.add("d-none");
            document.getElementById("dadosSIAD").innerHTML = "";

            // reset select
            document.getElementById("selectSIAD").value = "Selecione...";

            // limpa polígono e marcador caso existam
            if (poligonoAtivo) {
                poligonoAtivo.setMap(null);
                poligonoAtivo = null;
            }

            if (window.markerAtual) {
                window.markerAtual.setMap(null);
                window.markerAtual = null;
            }
        }



    </script>

    
    <!-- DASHBOARD -->
    <div id="modalDashboard" class="modal-dashboard">
        <div class="modal-conteudo modal-dialog-scrollable">

            <div class="modal-header">
                <span class="fechar" onclick="fecharDashboard()">×</span>
                <h3 class="subtitulo-secao" id="tituloDashboard"></h3>
            </div>

            <div class="modal-body dashboard-grid">

                <!-- COLUNA ESQUERDA - GRÁFICOS -->
                <div class="dashboard-graficos">

                    <div class="card-dashboard">
                        <h6 class="subtitulo-secao"><i class="bi bi-droplet resumo-icone"></i> IRRIGAÇÃO</h6>
                        <div class="grafico-container">
                            <canvas id="graficoIrrigacaoBarra"></canvas>
                        </div>
                    </div>

                    <div class="card-dashboard">
                        <h6 class="subtitulo-secao"><i class="bi bi-lightning"></i> CONSUMO DE ENERGIA</h6>
                        <div class="grafico-container">
                            <canvas id="graficoEnergiaBarra"></canvas>
                        </div>
                    </div>

                </div>

                <!-- COLUNA DIREITA - RESUMO -->
                <div class="dashboard-resumo">

                    <!-- ===== IRRIGAÇÃO ===== -->
                    <div class="resumo-bloco">
                        <h8 class="subtitulo-secao">
                            <i class="bi bi-droplet resumo-icone"></i>
                            IRRIGAÇÃO
                        </h8>

                        <div class="info-card">
                            <span class="label">Área total irrigada</span>
                            <strong id="infoAreaIrrigada">—</strong>
                        </div>

                        <div class="info-card">
                            <span class="label">Método de irrigação</span>
                            <strong id="infoMetodo">—</strong>
                        </div>
                    </div>


                    <!-- ===== ENERGIA ===== -->
                    <div class="resumo-bloco">
                        <h8 class="subtitulo-secao">
                            <i class="bi bi-lightning"></i>
                            ENERGIA
                        </h8>

                        <div class="info-card">
                            <span class="label">Custo total de energia</span>
                            <strong id="infoCustoEnergia">—</strong>
                        </div>

                        <div class="info-card">
                            <span class="label">Rede elétrica</span>
                            <strong id="infoRede">—</strong>
                        </div>
                    </div>

                    <!-- ===== CULTIVO ===== -->
                    <div class="resumo-bloco">
                        <h8 class="subtitulo-secao">
                            <i class="bi bi-feather2"></i>
                            CULTIVO
                        </h8>

                        <div class="info-card">
                            <span class="label">Cultivo principal</span>
                            <strong id="infoCultivo">—</strong>   
                        </div>

                        <div class="info-card">
                            <span class="label">Produtividade</span>
                            <strong id="infoProdutividade">—</strong>    
                        </div>

                        <div class="info-card">
                            <span class="label">Área total cultivada</span>
                            <strong id="infoArea">—</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
               
            </div>

        </div>
    </div>

    <!-- Inicialização dos Popovers -->
    <script>
    
        function ativarPopovers() {
        const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
        popovers.forEach(el => {
            new bootstrap.Popover(el, {
                trigger: 'focus',
                placement: 'right',
                html: true
            });
        });
        }

        document.addEventListener("DOMContentLoaded", function () {

        const popoverTriggerList =
            document.querySelectorAll('[data-bs-toggle="popover"]');

        popoverTriggerList.forEach(el => {
            new bootstrap.Popover(el, {
                trigger: 'focus',     // melhor pra dashboard
                placement: 'right',
                html: true
            });
        });

        });
    </script>

    <!-- MODAL SIAD -->
    <div class="modal fade" id="modalCriteriosAlerta" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                <i class="bi bi-exclamation-triangle"></i>
                Critérios de Alerta do SIAD
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted">
                Estes critérios são utilizados pelo SIAD para destacar situações que
                merecem atenção na gestão hídrica, produtiva e energética.
                </p>

                <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Indicador</th>
                        <th>Verde (Adequado)</th>
                        <th>Amarelo (Atenção)</th>
                        <th>Vermelho (Crítico)</th>
                        <th>Apoio à decisão</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Eficiência hídrica (kg/m³)</td>
                            <td>&gt; 0,30</td>
                            <td>0,10 – 0,30</td>
                            <td>&lt; 0,10</td>
                            <td>
                                Avalia o retorno produtivo obtido a partir da água utilizada.
                                Valores baixos indicam baixa conversão da água em produção agrícola.
                            </td>
                        </tr>

                        <tr>
                            <td>Custo por m³ irrigado (R$/m³)</td>
                            <td>&lt; 0,05</td>
                            <td>0,05 – 0,15</td>
                            <td>&gt; 0,15</td>
                            <td>
                                Indica o impacto do custo energético sobre a irrigação.
                                Custos elevados reduzem a eficiência econômica do uso da água.
                            </td>
                        </tr>

                        <tr>
                            <td>Custo por kg produzido (R$/kg)</td>
                            <td>&lt; 0,50</td>
                            <td>0,50 – 1,00</td>
                            <td>&gt; 1,00</td>
                            <td>
                                Avalia a eficiência econômica da produção agrícola considerando os custos energéticos.
                            </td>
                        </tr>

                        <tr>
                            <td>Eficiência global (kg/R$)</td>
                            <td>&gt; 3,00</td>
                            <td>1,50 – 3,00</td>
                            <td>&lt; 1,50</td>
                            <td>
                                Indicador integrado que relaciona produção agrícola, consumo de água e custo energético,
                                apoiando decisões sobre a eficiência global do sistema produtivo.
                            </td>
                        </tr>
                    </tbody>


                </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                Fechar
                </button>
            </div>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
