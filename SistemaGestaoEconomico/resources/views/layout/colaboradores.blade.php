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
        <h1>Colaboradores</h1>
        <div class="search-container">
            <input type="text" placeholder="ID, Nome ou Grupo" class="input" oninput="filtrarGrupos(this.value)">

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
                    <form method="get">
                        <button class="buttonOption" type="submit">Gerenciar</button>
                    </form>
                    <form action="">
                        <button class="buttonOption">Ver Colaboradores</button>
                    </form>
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
                <h3>Usuário:</h3>
                <input type="text" name="usuario" placeholder="Usuário">
                <h3>Senha:</h3>
                <input type="password" name="senha" placeholder="Senha">
                <div class="buttonDiv">
                    <button class="buttonOption" type="submit">Criar</button>
                    <button id="cancelButton" class="cancelButton" type="button">Cancelar</button>
                </div>
            </form>
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
        </script>

    </main>
</body>

</html>