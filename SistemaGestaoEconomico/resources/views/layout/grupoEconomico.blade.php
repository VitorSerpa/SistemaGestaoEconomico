<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset("css/grupoEconomico.css") }}">
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
                <div class="grupo">
                    <h1 class="title">{{ $grupo->nome_grupo }}</h1>

                    <section class="infoSection">

                        <h3 class="id">ID: {{ $grupo->id_grupo }}</h3>

                        <h3>Data de criação:</h3>
                        @php
                            $dados = $grupo->data_criacao;
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
                        <button class="buttonOption">Ver Bandeiras</button>
                    </form>
                </div>
            @endforeach
        </div>
    </main>
    <div class="criarGrupoDiv" id="criarGrupoDiv">
        <h2>Criar Grupo Econômico</h2>
        <form action="{{ route('grupoEconomico.criar') }}" method="POST">
            @csrf
            <h3>Nome do grupo:</h3>
            <input type="text" name="nome_grupo" placeholder="Nome do grupo" required>
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

</body>

</html>