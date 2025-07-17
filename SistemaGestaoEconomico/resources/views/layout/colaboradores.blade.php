<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Colaboradores</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/colaborador.css') }}" />
</head>

<body>
    @include('components.Header')

    <main class="main">
        <h1>Colaboradores</h1>

        <div class="search-container">
            <input type="text" placeholder="ID ou Nome" class="input" oninput="filtrarGrupos(this.value)" />
            <button class="buttonOption" id="buttonCreate">Criar novo Colaborador</button>
        </div>

        <div class="grupo-container">
            @foreach($colaboradores as $colaborador)
                <div class="grupo">
                    <h1 class="title">{{ $colaborador->nome }}</h1>

                    <section class="infoSection">
                        <h3 class="id">ID: {{ $colaborador->id_colaborador }}</h3>

                        <h3>Unidade:</h3>
                        <p>{{ $colaborador->unidade->nome_fantasia }}</p>

                        <h3>Email:</h3>
                        <p>{{ $colaborador->email }}</p>

                        <h3>CPF:</h3>
                        <p>{{ $colaborador->CPF }}</p>

                        <h3>Data de criação:</h3>
                        @php
                            $dados = $colaborador->data_criacao;
                            $partes = explode(' ', $dados);
                            $diaCorreto = explode("-", $partes[0]);
                            $partes[0] = $diaCorreto[2] . "/" . $diaCorreto[1] . "/" . $diaCorreto[0];
                        @endphp
                        <p>Data: {{ $partes[0] }}</p>
                        <p>Hora: {{ $partes[1] ?? '' }}</p>
                    </section>

                    <button class="buttonOption gerenciarButton" type="button">Gerenciar</button>
                </div>
            @endforeach
        </div>


        <div class="criarGrupoDiv" id="criarGrupoDiv" style="display:none;">
            <h2>Criar Colaborador</h2>
            <form action="{{ route('colaborador.post') }}" method="POST">
                @csrf

                <h3>Nome:</h3>
                <input type="text" name="nome" placeholder="Nome" required />

                <h3>Email:</h3>
                <input type="email" name="email" placeholder="Email" required />

                <h3>CPF:</h3>
                <input type="text" name="CPF" placeholder="000.000.000-00" required />

                <h3>Unidade relacionada:</h3>
                <select class="selectInput" name="id_unidade" id="id_unidade">
                    @foreach ($unidades as $unidade)
                        <option value="{{ $unidade->id_unidade }}">{{ $unidade->nome_fantasia }}</option>
                    @endforeach
                </select>

                <div class="buttonDiv">
                    <button class="buttonOption" type="submit">Criar</button>
                    <button id="cancelButton" class="cancelButton" type="button">Cancelar</button>
                </div>
                @if(session('alert'))
                    <script>
                        alert('{{ session('alert') }}');
                    </script>
                @endif
            </form>
        </div>

        <div class="gerenciarSection" id="gerenciarColaboradorSection" style="display:none;">
            <h2 id="gerenciarColaboradorNome">Colaborador</h2>

            <h3>Nome:</h3>
            <input type="text" id="novoNomeInput" form="updateColaboradorForm" />

            <h3>Email:</h3>
            <input type="email" id="novoEmailInput" form="updateColaboradorForm" />

            <h3>CPF:</h3>
            <input type="text" id="novoCPFInput" form="updateColaboradorForm" />

            <h3>Unidade relacionada:</h3>
            <select class="selectInput" name="id_unidade" id="selectUnidade" form="updateColaboradorForm">
                @foreach ($unidades as $unidade)
                    <option value="{{ $unidade->id_unidade }}">{{ $unidade->nome_fantasia }}</option>
                @endforeach
            </select>

            <form id="updateColaboradorForm" method="POST" action="{{ route("colaborador.atualizar") }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_colaborador" id="updateIdColaborador" />
                <input type="hidden" name="nome" id="hiddenNome" />
                <input type="hidden" name="email" id="hiddenEmail" />
                <input type="hidden" name="CPF" id="hiddenCPF" />
                <input type="hidden" name="id_unidade_hidden" id="hiddenIdUnidade" />
                <button class="buttonOption" type="submit">Atualizar</button>
            </form>

            <section class="infoSection">
                <h3 class="id" id="gerenciarColaboradorId">ID:</h3>
                <h3>Unidade:</h3>
                <p id="gerenciarUnidadeNome">Unidade</p>
                <h3>Data de criação:</h3>
                <p id="gerenciarColaboradorData">Data:</p>
                <p id="gerenciarColaboradorHora">Hora:</p>
            </section>

            <div class="buttonDiv">
                <form id="deleteColaboradorForm" method="POST" action="{{ route("colaborador.delete") }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteIdColaborador" />
                    <button class="cancelButton" type="button" onclick="confirmarExclusaoColaborador()">Deletar
                        Colaborador</button>
                </form>

                <button class="buttonOption" onclick="ocultarGerenciarColaborador()">Fechar</button>
            </div>
        </div>

        @if (session('erro_cnpj'))
            <script>
                alert("{{ session('erro_cnpj') }}");
            </script>
        @endif

        <script>
            const createSection = document.getElementById('criarGrupoDiv');
            const buttonCancel = document.getElementById('cancelButton');
            const buttonCreate = document.getElementById('buttonCreate');

            buttonCreate.onclick = () => {
                createSection.style.display = 'block';
            };

            buttonCancel.onclick = () => {
                createSection.style.display = 'none';
            };

            function filtrarGrupos(valor) {
                const grupos = document.querySelectorAll('.grupo');

                if (isInt(valor)) {
                    grupos.forEach((grupo) => {
                        const nome = grupo.querySelector('.id').textContent.toLowerCase();
                        if (nome.includes(valor.toLowerCase())) {
                            grupo.style.display = 'block';
                        } else {
                            grupo.style.display = 'none';
                        }
                    });
                } else {
                    grupos.forEach((grupo) => {
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
                const numero = Number(valor);
                return Number.isInteger(numero);
            }

            document.querySelectorAll('.grupo .gerenciarButton').forEach((botao) => {
                botao.addEventListener('click', function () {
                    const grupo = this.closest('.grupo');

                    const nome = grupo.querySelector('.title').textContent.trim();
                    const id = grupo.querySelector('.id').textContent.replace('ID: ', '').trim();
                    const unidade = grupo.querySelectorAll('p')[0].textContent.trim();
                    const email = grupo.querySelectorAll('p')[1].textContent.trim();
                    const cpf = grupo.querySelectorAll('p')[2].textContent.trim();
                    const dataTexto = grupo.querySelectorAll('p')[3].textContent.trim();
                    const horaTexto = grupo.querySelectorAll('p')[4].textContent.trim();

                    document.getElementById('gerenciarColaboradorNome').textContent = nome;
                    document.getElementById('gerenciarColaboradorId').textContent = 'ID: ' + id;
                    document.getElementById('gerenciarUnidadeNome').textContent = unidade;
                    document.getElementById('gerenciarColaboradorData').textContent = 'Data: ' + dataTexto;
                    document.getElementById('gerenciarColaboradorHora').textContent = 'Hora: ' + horaTexto;

                    document.getElementById('novoNomeInput').value = nome;
                    document.getElementById('novoEmailInput').value = email;
                    document.getElementById('novoCPFInput').value = cpf;
                    document.getElementById('selectUnidade').value =
                        Array.from(document.getElementById('selectUnidade').options)
                            .find(option => option.text === unidade)?.value || '';

                    document.getElementById('updateIdColaborador').value = id;

                    document.getElementById('hiddenNome').value = nome;
                    document.getElementById('hiddenEmail').value = email;
                    document.getElementById('hiddenCPF').value = cpf;
                    document.getElementById('hiddenIdUnidade').value = document.getElementById('selectUnidade').value;

                    document.getElementById('gerenciarColaboradorSection').style.display = 'block';
                });
            });

            document.getElementById('updateColaboradorForm').addEventListener('submit', function (e) {
                const nome = document.getElementById('novoNomeInput').value;
                const email = document.getElementById('novoEmailInput').value;
                const cpf = document.getElementById('novoCPFInput').value;
                const id = document.getElementById('updateIdColaborador').value;
                const idUnidade = document.getElementById('selectUnidade').value;

                if (!confirm(`Deseja atualizar o colaborador (ID: ${id}) com nome "${nome}"?`)) {
                    e.preventDefault();
                    return;
                }

                document.getElementById('hiddenNome').value = nome;
                document.getElementById('hiddenEmail').value = email;
                document.getElementById('hiddenCPF').value = cpf;
                document.getElementById('hiddenIdUnidade').value = idUnidade;
            });

            function confirmarExclusaoColaborador() {
                const id = document.getElementById("gerenciarColaboradorId").textContent.replace("ID:", "").trim();
                const nome = document.getElementById("gerenciarColaboradorNome").textContent;

                if (
                    confirm(
                        `Deseja realmente excluir o colaborador "${nome}" (ID: ${id})? Esta ação é irreversível.`
                    )
                ) {
                    document.getElementById("deleteIdColaborador").value = id;
                    document.getElementById("deleteColaboradorForm").submit();
                }
            }
            function ocultarGerenciarColaborador() {
                document.getElementById('gerenciarColaboradorSection').style.display = 'none';
            }


        </script>
    </main>
</body>

</html>