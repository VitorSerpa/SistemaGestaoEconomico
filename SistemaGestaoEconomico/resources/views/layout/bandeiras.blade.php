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
            <input type="text" placeholder="ID, Nome ou Grupo" class="input" oninput="filtrarGrupos(this.value)">

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
                            $partes[0] = $diaCorreto[2]."/".$diaCorreto[1]."/".$diaCorreto[0];
                        @endphp

                        <p>Data: {{ $partes[0] }}</p>
                        <p>Hora: {{ $partes[1] ?? '' }}</p>

                    </section>
                    <form  method="get">
                        <button class="buttonOption" type="submit">Gerenciar</button>
                    </form>
                    <form action="">
                        <button class="buttonOption">Ver Unidades</button>
                    </form>
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