<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Economico</title>
    <link rel="stylesheet" href="{{ asset("css/styles.css") }}">
    <link rel="stylesheet" href="{{ asset("css/bandeiras.css") }}">
</head>

<body>
    @include('components.Header')

    <main class="main">
        <h1>Bandeiras Comerciais</h1>
        <div class="search-container">
            <input type="text" placeholder="ID ou Nome" class="input" oninput="filtrarGrupos(this.value)">

            <button class="buttonOption" id="buttonCreate">Criar nova bandeira</button>
        </div>
        <div class="grupo-container">
            @foreach($bandeiras as $bandeira)
                <div class="grupo">
                    <h1 class="title">{{ $bandeira->nome_bandeira }}</h1>

                    <section class="infoSection">

                        <h3 class="id">ID: {{ $bandeira->id_bandeira }}</h3>

                        <h3>Grupo Ecônomico:</h3>
                        <p>{{ $bandeira->grupo->nome_grupo}}</p>

                        <h3>Data de criação:</h3>
                        @php
                            $dados = $bandeira->data_criacao;
                            $partes = explode(' ', $dados);
                            $diaCorreto = explode("-", $partes[0]);
                            $partes[0] = $diaCorreto[2] . "/" . $diaCorreto[1] . "/" . $diaCorreto[0];
                        @endphp

                        <p>Data: {{ $partes[0] }}</p>
                        <p>Hora: {{ $partes[1] ?? '' }}</p>

                    </section>
                    <button class="buttonOption" type="submit">Gerenciar</button>
                </div>
            @endforeach
        </div>
        <div class="criarGrupoDiv" id="criarGrupoDiv">
            <h2>Criar Grupo Econômico</h2>
            <form action="{{ route('bandeira.post') }}" method="POST">
                @csrf
                <h3>Nome da bandeira:</h3>
                <input type="text" name="nome_bandeira" placeholder="Nome da bandeira" required>

                <h3>Grupo econômico relacionado:</h3>
                <select class="selectInput" name="id_grupo" id="">
                    @foreach ($grupos as $grupo)
                        <option selected value="{{ $grupo->id_grupo }}">{{ $grupo->nome_grupo }}</option>
                    @endforeach
                </select>

                <div class="buttonDiv">
                    <button class="buttonOption" type="submit">Criar</button>
                    <button id="cancelButton" class="cancelButton" type="button">Cancelar</button>
                </div>
            </form>
        </div>

        <div class="gerenciarSection" id="gerenciarBandeiraSection" style="display: none;">
            <h2 id="gerenciarBandeiraNome">Bandeira</h2>

            <h3>Novo nome:</h3>
            <input type="text" name="novo_nome" id="novoNomeBandeiraInput" form="updateBandeiraForm" required>
            <br><br>

            <select class="selectInput" name="id_grupo_economico" id="grupoSelect" form="updateBandeiraForm" required>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id_grupo }}">{{ $grupo->nome_grupo }}</option>
                @endforeach
            </select>

            <form id="updateBandeiraForm" method="POST" action="{{ route('bandeira.atualizar') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_bandeira" id="updateIdBandeira">
                <button class="buttonOption" type="submit">Atualizar</button>
            </form>

            <section class="infoSection">
                <h3 class="id" id="gerenciarBandeiraId">ID:</h3>
                <h3>Grupo Econômico:</h3>
                <p id="gerenciarGrupoNome">Grupo</p>
                <h3>Data de criação:</h3>
                <p id="gerenciarBandeiraData">Data:</p>
                <p id="gerenciarBandeiraHora">Hora:</p>
            </section>

            <div class="buttonDiv">
                <form id="deleteBandeiraForm" method="POST" action="{{ route("bandeira.delete") }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteIdBandeira">
                    <button class="cancelButton" type="button" onclick="confirmarExclusaoBandeira()">Deletar
                        Bandeira</button>
                </form>

                <button class="buttonOption" onclick="ocultarGerenciarBandeira()">Fechar</button>
            </div>
        </div>

        <script>
            const createSection = document.getElementById("criarGrupoDiv");
            const buttonCancel = document.getElementById("cancelButton");
            const buttonCreate = document.getElementById("buttonCreate")

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
                        const nome = grupo.querySelector('.id').textContent.toLowerCase();
                        if (nome.includes(valor.toLowerCase())) {
                            grupo.style.display = 'block';
                        } else {
                            grupo.style.display = 'none';
                        }
                    });
                } else {
                    grupos.forEach(grupo => {
                        const nome = grupo.querySelector('.title').textContent.toLowerCase();
                        if (nome.includes(valor.toLowerCase())) {
                            grupo.style.display = 'block';
                        } else {
                            grupo.style.display = 'none';
                        }
                    });
                }

            }

            function isInt(valor) {
                const numero = Number(valor)
                return Number.isInteger(numero)
            }

            document.querySelectorAll('.grupo .buttonOption[type="submit"]').forEach(botao => {
                botao.addEventListener('click', function () {
                    const grupo = this.closest('.grupo');
                    const nome = grupo.querySelector('.title').textContent.trim();
                    const id = grupo.querySelector('.id').textContent.replace("ID: ", "").trim();
                    const grupoNome = grupo.querySelector('p').textContent.trim();
                    const dataTexto = grupo.querySelectorAll('p')[1].textContent.replace("Data: ", "").trim();
                    const horaTexto = grupo.querySelectorAll('p')[2].textContent.replace("Hora: ", "").trim();

                    document.getElementById("novoNomeBandeiraInput").value = nome;

                    document.getElementById("gerenciarBandeiraNome").textContent = nome;
                    document.getElementById("gerenciarBandeiraId").textContent = "ID: " + id;
                    document.getElementById("gerenciarGrupoNome").textContent = grupoNome;
                    document.getElementById("gerenciarBandeiraData").textContent = "Data: " + dataTexto;
                    document.getElementById("gerenciarBandeiraHora").textContent = "Hora: " + horaTexto;

                    document.getElementById("deleteIdBandeira").value = id;
                    document.getElementById("updateIdBandeira").value = id;

                    document.getElementById("gerenciarBandeiraSection").style.display = "block";
                });
            });

            document.getElementById("updateBandeiraForm").addEventListener("submit", function (e) {
                const nome = document.getElementById("novoNomeBandeiraInput").value;
                const id = document.getElementById("updateIdBandeira").value;

                if (!confirm(`Tem certeza que deseja atualizar a bandeira (ID: ${id}) para o nome "${nome}"?`)) {
                    e.preventDefault();
                    return;
                }

                document.getElementById("hiddenNomeBandeira").value = nome;
            });

            function confirmarExclusaoBandeira() {
                const id = document.getElementById("deleteIdBandeira").value;
                const nome = document.getElementById("gerenciarBandeiraNome").textContent;

                if (confirm(`Deseja realmente excluir a bandeira "${nome}" (ID: ${id})? Esta ação é irreversível.`)) {
                    document.getElementById("deleteBandeiraForm").submit();
                }
            }

            function ocultarGerenciarBandeira() {
                document.getElementById("gerenciarBandeiraSection").style.display = "none";
            }


        </script>

    </main>
</body>

</html>