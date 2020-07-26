{{-- <div class="alert"> --}}
    {{-- esse content veio da view index.blade.php --}}
    {{-- <p>Alert - {{ $content }}</p> --}}
    {{-- se quisermos vireficar se $content existe antes de mandar imprimir nao precisa usar @if, veja --}}
    {{-- <p>Alert - {{ $content ?? '' }}</p> --}}
{{-- </div> --}}

{{-- Esse $errors->any() é um array de erros gerados por validações REQUEST de forms
dentro de Http/Requests/StoreUpdateProductRequest! la dentro tem os passos de validar,
se retornar algum erro, volta pra esse FORM os dados dentro de $errors!
e com um foreach podemos ver quais foram os erros de validação --}}
@if ($errors->any())
<ul>
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
</ul>
@endif