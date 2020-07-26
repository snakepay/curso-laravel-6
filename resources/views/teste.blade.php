<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Minha View</title>
        <meta charset="UTF-8">
    </head>
    <body>
        minha view blade nova... valor de teste vindo da controller -> {!! $teste2 !!} - {{ $teste3 }}
        <!-- interpolçao {!! $teste2 !!} não evita ataque de XSS.. se tiver comando será executado ou ate tag html 
             interpolção {{ $teste3 }} evita ataque XSS e se tiver tag html ou comando, vira html e nao afeta a pagina
        -->
    </body>
</html>
