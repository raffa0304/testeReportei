<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>
        
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body>
        <div class="divLogin">
            <h1>Realize seu Login <br> 
                Clicando Aqui <br>
                <ion-icon name="logo-github"></ion-icon>
            </h1>

            <a href="{{$output}}" type="submit" class="button divInput">Entrar</a>
        </div>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    </body>
</html>
