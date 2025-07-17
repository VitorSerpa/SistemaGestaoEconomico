<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/relatorios.css') }}">
</head>

<body>
    @include('components.Header')
    <main class="mainSection">
        <div class="registerSection">
            <h2>Relatórios registrados</h2>
            @foreach ($relatorios as $relatorio)
                <div class="registro">
                    <p>
                        Grupo: {{ $relatorio->grupo }} 
                    </p>
                    <p>
                        Nome: {{ $relatorio->objeto }} 
                    </p>
                    <p>
                        Ação: {{ $relatorio->acao }} 
                    </p>
                    <p>
                        Data: {{ \Carbon\Carbon::parse($relatorio->hora)->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            @endforeach
        </div>
    </main>
</body>

</html>