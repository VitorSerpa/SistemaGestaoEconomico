<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="{{ asset('/css/loginPage.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
</head>

<body>
    <main class="main">
        <section class="loginSection">
            <form method="POST" action="{{ route('login.auth') }}">
                @csrf

                <div>
                    <label for="username">Usuário</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div>
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit">
                    Login
                </button>

                @if($errors->any())
                    <div class="erro">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif
            </form>
        </section>
    </main>
</body>

</html>