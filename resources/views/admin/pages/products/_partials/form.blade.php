{{-- esse CSRF_TOKEN é uma proteção que o laravel coloca contra ataque no site
para evitar multiplos cadastros no site!
Pois o laravel verifica se o token que está na sessão é o mesmo token
que está no formulário, batendo os 2 valores está ok!!!!
Repare nos values dos campos input; temos old('name') e old ('description'),
isso é um helper do laravel que.. quando ocorre a validação do form, caso retorne
erros, o laravel retorna a pagina denovo para o form.. e esse helper garante que
os dados digitados nos campos fiquem lá novamente, evitando digitar denovo! 
repare tb nos values dos inputs que tem $product->name ?? old('name') -> isso significa que essa variável
só será impressa caso ela tenha valor... senao tiver valor old('name') que será impresso!
isso ajuda no Create e do Edit do CRUD, pois no Create o old age evitando a digitação novamente 
e no Edit a variável é escrita para podemos editar tal produto --}}

{{-- aqui estão as validações de form --}}
@include('admin.includes.alerts')

@csrf
<div class="form-group">
    <input class="form-control" type="text" name="name" placeholder="Nome:" value="{{ $product->name ?? old('name') }}">
</div>
<div class="form-group">
    <input class="form-control" type="text" name="price" placeholder="Preço:" value="{{ $product->price ?? old('price') }}">
</div>
<div class="form-group">
    <input class="form-control" type="text" name="description" placeholder="Descrição:" value="{{ $product->description ?? old('description') }}">
</div>
<div class="form-group">
    <input class="form-control" type="file" name="image">
</div>
<div class="form-group">
    <button class="btn btn-success" type="submit">Enviar</button>
</div>