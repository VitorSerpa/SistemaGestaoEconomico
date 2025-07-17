<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos Econômicos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/grupoEconomico.css') }}">
</head>

<body>
    @include('components.Header')

    <main class="main">
        <h1>Grupos Econômicos</h1>

        <div class="search-container">
            <input type="text" placeholder="ID ou Nome do grupo" class="input" oninput="filtrarGrupos(this.value)">
            <button class="buttonOption" id="buttonCreate">Criar novo grupo</button>
        </div>

        <div class="grupo-container">
            @foreach($grupos as $grupo)
                <div class="grupo" data-id="{{ $grupo->id_grupo }}" data-nome="{{ $grupo->nome_grupo }}"
                    data-data="{{ $grupo->data_criacao }}">

                    <h1 class="title">{{ $grupo->nome_grupo }}</h1>

                    <section class="infoSection">
                        <h3 class="id">ID: {{ $grupo->id_grupo }}</h3>
                        <h3>Data de criação:</h3>

                        @php
                            $partes = explode(' ', $grupo->data_criacao);
                            $dataFormatada = \Carbon\Carbon::parse($partes[0])->format('d/m/Y');
                        @endphp

                        <p>Data: {{ $dataFormatada }}</p>
                        <p>Hora: {{ $partes[1] ?? '' }}</p>
                    </section>

                    <button class="buttonOption gerenciarButton" type="button">Gerenciar</button>
                </div>
            @endforeach
        </div>
    </main>

    <div class="criarGrupoDiv" id="criarGrupoDiv" style="display: none;">
        <h2>Criar Grupo Econômico</h2>
        <form action="{{ route('grupoEconomico.criar') }}" method="POST">
            @csrf
            <h3>Nome do grupo:</h3>
            <input type="text" name="nome_grupo" placeholder="Nome do grupo" required>

            <div class="buttonDivCriar">
                <button id="cancelButton" class="cancelButton" type="button">Cancelar</button>
                <button class="buttonOption" type="submit">Criar</button>
            </div>
        </form>
    </div>

    <div class="gerenciarSection" id="gerenciarSection" style="display: none;">
        <h2 id="gerenciarNome">Grupo</h2>

        <h3>Novo nome:</h3>
        <input class="" type="text" name="novo_nome" id="novoNomeInput" form="updateForm">

        <form id="updateForm" method="POST" action="{{ route('grupoEconomico.atualizar') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_grupo" id="updateIdGrupo">
            <input type="hidden" name="nome_grupo" id="hiddenNomeGrupo">
            <button class="buttonOption" type="submit">Atualizar</button>
        </form>
        <section class="infoSection">
            <h3 class="id" id="gerenciarId">ID: </h3>
            <h3>Data de criação:</h3>
            <p id="gerenciarData">Data: </p>
            <p id="gerenciarHora">Hora: </p>
        </section>

        <div class="buttonDiv">
            <form id="deleteForm" method="POST" action="{{ route('grupoEconomico.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteIdGrupo">
                <button class="cancelButton" type="button" onclick="confirmarExclusao()">Deletar Grupo</button>
            </form>


            <button class="buttonOption" onclick="ocultarGerenciar()">Fechar</button>
        </div>
    </div>


    <script>
        const createSection = document.getElementById("criarGrupoDiv");
        const buttonCancel = document.getElementById("cancelButton");
        const buttonCreate = document.getElementById("buttonCreate");

        buttonCreate.onclick = () => {
            createSection.style.display = "block";
        };
        buttonCancel.onclick = () => {
            createSection.style.display = "none";
        };

        function filtrarGrupos(valor) {
            const grupos = document.querySelectorAll('.grupo');
            if (isInt(valor)) {
                grupos.forEach(grupo => {
                    const id = grupo.dataset.id;
                    grupo.style.display = id.includes(valor) ? 'block' : 'none';
                });
            } else {
                valor = valor.toLowerCase();
                grupos.forEach(grupo => {
                    const nome = grupo.dataset.nome.toLowerCase();
                    grupo.style.display = nome.includes(valor) ? 'block' : 'none';
                });
            }
        }

        function confirmarExclusao() {
            const id = document.getElementById("deleteIdGrupo").value;
            const nome = document.getElementById("gerenciarNome").textContent;

            if (confirm(`Tem certeza que deseja excluir o grupo "${nome}" (ID: ${id})? Esta ação não poderá ser desfeita.`)) {
                document.getElementById("deleteForm").submit();
            }
        }

        function isInt(valor) {
            const numero = Number(valor);
            return Number.isInteger(numero);
        }

        function formatarData(dataCompleta) {
            const [data, hora] = dataCompleta.split(" ");
            const [ano, mes, dia] = data.split("-");
            return {
                data: `${dia}/${mes}/${ano}`,
                hora: hora || ''
            };
        }

        function ocultarGerenciar() {
            document.getElementById("gerenciarSection").style.display = "none";
        }

        document.querySelectorAll('.gerenciarButton').forEach(botao => {
            botao.addEventListener('click', function () {
                const grupo = this.closest('.grupo');
                const id = grupo.dataset.id;
                const nome = grupo.dataset.nome;
                const dataBruta = grupo.dataset.data;

                const { data, hora } = formatarData(dataBruta);

                document.getElementById("novoNomeInput").value = nome;

                document.getElementById("gerenciarNome").textContent = nome;
                document.getElementById("gerenciarId").textContent = "ID: " + id;
                document.getElementById("gerenciarData").textContent = "Data: " + data;
                document.getElementById("gerenciarHora").textContent = "Hora: " + hora;

                document.getElementById("deleteIdGrupo").value = id;
                document.getElementById("updateIdGrupo").value = id;

                document.getElementById("gerenciarSection").style.display = "block";
            });
        });

        document.getElementById("updateForm").addEventListener("submit", function (e) {
            const nome = document.getElementById("novoNomeInput").value;
            const id = document.getElementById("updateIdGrupo").value;

            if (!confirm(`Tem certeza que deseja atualizar o grupo (ID: ${id}) para o nome "${nome}"?`)) {
                e.preventDefault(); 
                return;
            }

            document.getElementById("hiddenNomeGrupo").value = nome;
        });
    </script>
</body>

</html>