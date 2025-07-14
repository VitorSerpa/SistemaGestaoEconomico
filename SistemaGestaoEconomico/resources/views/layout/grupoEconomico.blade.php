<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset ("css/grupoEconomico.css") }}">
</head>

<body>
    @include('components.Header')
    <main>
        <h1>Grupos Econômicos</h1>
        <div class="grupo-container">

            @foreach($grupos as $grupo)
                <div class="grupo">
                    <h1>{{ $grupo->nome_grupo }}</h1>
                    
                    <h3>ID:</h3>
                    {{ $grupo->id_grupo }}
                    <h3>Data de criação:</h3>
                    @php
                        $dados = $grupo->data_criacao;
                        $partes = explode(' ', $dados);
                    @endphp
    
                    <p>Data: {{ $partes[0] }}</p>
                    <p>Hora: {{ $partes[1] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </main>


</body>

</html>