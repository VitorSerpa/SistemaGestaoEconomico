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
        <h1>Unidades</h1>
        <div class="search-container">
            <input type="text" placeholder="ID ou Nome" class="input" oninput="filtrarGrupos(this.value)">

            <button class="buttonOption" id="buttonCreate">Criar nova Unidade</button>
        </div>
        <div class="grupo-container">
            @foreach($unidades as $unidade)
                <div class="grupo">
                    <h1 class="title">{{ $unidade->nome_fantasia}}</h1>

                    <section class="infoSection">

                        <h3 class="id">ID: {{ $unidade->id_unidade}}</h3>

                        <h3>Bandeira:</h3>
                        <p>{{ $unidade->bandeira->nome_bandeira }}</p>

                        <h3>Nome fantasia:</h3>
                        <p>{{ $unidade->nome_fantasia }}</p>

                        <h3>Razão social:</h3>
                        <p>{{ $unidade->razao_social }}</p>

                        <h3>CNPJ:</h3>
                        <p>{{ $unidade->CNPJ }}</p>

                        <h3>Data de criação:</h3>
                        @php
                            $dados = $unidade->data_criacao;
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
            <h2>Criar Unidade</h2>
            <form action="{{ route('unidades.post') }}" method="POST">
                @csrf
                <h3>Nome fantasia:</h3>
                <input type="text" name="nome_fantasia" placeholder="Nome da fantasia" required>

                <h3>Razão social:</h3>
                <input type="text" name="razao_social" placeholder="Razão social" required>

                <h3>CNPJ:</h3>
                <input type="text" name="CNPJ" placeholder="00.000.000/0000-00" required>

                <h3>Bandeira relacionada:</h3>
                <select class="selectInput" name="id_bandeira" id="">
                    @foreach ($bandeiras as $bandeira)
                        <option selected value="{{ $bandeira->id_bandeira }}">{{ $bandeira->nome_bandeira }}</option>
                    @endforeach
                </select>

                <div class="buttonDiv">
                    <button class="buttonOption" type="submit">Criar</button>
                    <button id="cancelButton" class="cancelButton" type="button">Cancelar</button>
                </div>
            </form>
        </div>

        <div class="gerenciarSection" id="gerenciarUnidadeSection" style="display: none;">
            <h2 id="gerenciarUnidadeNome">Unidade</h2>

            <h3>Nome fantasia:</h3>
            <input type="text" id="novoNomeFantasiaInput" form="updateUnidadeForm">

            <h3>Razão social:</h3>
            <input type="text" id="novaRazaoSocialInput" form="updateUnidadeForm">

            <h3>CNPJ:</h3>
            <input type="text" id="novoCNPJInput" form="updateUnidadeForm">

            <h3>Bandeira relacionada:</h3>
            <select class="selectInput" name="id_bandeira" id="selectBandeira" form="updateUnidadeForm">
                @foreach ($bandeiras as $bandeira)
                    <option value="{{ $bandeira->id_bandeira }}">{{ $bandeira->nome_bandeira }}</option>
                @endforeach
            </select>

            <form id="updateUnidadeForm" method="POST" action="{{ route("unidades.atualizar") }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_unidade" id="updateIdUnidade">
                <input type="hidden" name="nome_fantasia" id="hiddenNomeFantasia">
                <input type="hidden" name="razao_social" id="hiddenRazaoSocial">
                <input type="hidden" name="CNPJ" id="hiddenCNPJ">
                <button class="buttonOption" type="submit">Atualizar</button>
            </form>

            <section class="infoSection">
                <h3 class="id" id="gerenciarUnidadeId">ID:</h3>
                <h3>Bandeira:</h3>
                <p id="gerenciarBandeiraNome">Bandeira</p>
                <h3>Data de criação:</h3>
                <p id="gerenciarUnidadeData">Data:</p>
                <p id="gerenciarUnidadeHora">Hora:</p>
            </section>

            <div class="buttonDiv">
                <form id="deleteUnidadeForm" method="POST" action="{{ route("unidades.delete") }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteIdUnidade">
                    <button class="cancelButton" type="button" onclick="confirmarExclusaoUnidade()">Deletar
                        Unidade</button>
                </form>

                <button class="buttonOption" onclick="ocultarGerenciarUnidade()">Fechar</button>
            </div>
        </div>

        @if (session('erro_cnpj'))
            <script>
                alert("{{ session('erro_cnpj') }}");
            </script>
        @endif

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
                    const bandeira = grupo.querySelectorAll('p')[0].textContent.trim();
                    const fantasia = grupo.querySelectorAll('p')[1].textContent.trim();
                    const razao = grupo.querySelectorAll('p')[2].textContent.trim();
                    const cnpj = grupo.querySelectorAll('p')[3].textContent.trim();
                    const dataTexto = grupo.querySelectorAll('p')[4].textContent.trim();
                    const horaTexto = grupo.querySelectorAll('p')[5].textContent.trim();

                    document.getElementById("gerenciarUnidadeNome").textContent = fantasia;
                    document.getElementById("gerenciarUnidadeId").textContent = "ID: " + id;
                    document.getElementById("gerenciarBandeiraNome").textContent = bandeira;
                    document.getElementById("gerenciarUnidadeData").textContent = "Data: " + dataTexto;
                    document.getElementById("gerenciarUnidadeHora").textContent = "Hora: " + horaTexto;

                    document.getElementById("novoNomeFantasiaInput").value = fantasia;
                    document.getElementById("novaRazaoSocialInput").value = razao;
                    document.getElementById("novoCNPJInput").value = cnpj;

                    document.getElementById("deleteIdUnidade").value = id;
                    document.getElementById("updateIdUnidade").value = id;

                    document.getElementById("gerenciarUnidadeSection").style.display = "block";
                });
            });

            document.getElementById("updateUnidadeForm").addEventListener("submit", function (e) {
                const nome = document.getElementById("novoNomeFantasiaInput").value;
                const razao = document.getElementById("novaRazaoSocialInput").value;
                const cnpj = document.getElementById("novoCNPJInput").value;
                const id = document.getElementById("updateIdUnidade").value;

                if (!confirm(`Deseja atualizar a unidade (ID: ${id}) com nome "${nome}"?`)) {
                    e.preventDefault();
                    return;
                }

                document.getElementById("hiddenNomeFantasia").value = nome;
                document.getElementById("hiddenRazaoSocial").value = razao;
                document.getElementById("hiddenCNPJ").value = cnpj;
            });

            function confirmarExclusaoUnidade() {
                const id = document.getElementById("deleteIdUnidade").value;
                const nome = document.getElementById("gerenciarUnidadeNome").textContent;

                if (confirm(`Deseja realmente excluir a unidade "${nome}" (ID: ${id})? Esta ação é irreversível.`)) {
                    document.getElementById("deleteUnidadeForm").submit();
                }
            }

            function ocultarGerenciarUnidade() {
                document.getElementById("gerenciarUnidadeSection").style.display = "none";
            }
        </script>

    </main>
</body>

</html>