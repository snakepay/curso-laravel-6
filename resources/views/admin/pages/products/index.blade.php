{{-- template para ser mostrado nessa view app abaixo --}}
@extends('admin.layouts.app')

{{-- esse section content aparece na view app que está chamando esse conteúdo --}}
@section('content')
{{-- essses elses podem ser usados em qualquer dessas estruturas de controle --}}
    <h2>Exibindo os produtos</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Cadastrar</a>

    <form action="{{ route('products.search') }}" method="post" class="form form-inline">
        @csrf
    <input type="text" name="filter" placeholder="Filtar:" class="form-control" value="{{ $filters['filter'] ?? '' }}">
        <button type="submit" class="btn btn-info">Pesquisar</button>
    </form>
    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                        <img src="{{ url("storage/{$product->image}") }}" alt="{{ $product->name }}" style="max-width: 100px;">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td width='100'>
                        <a href="{{ route('products.edit', $product->id)}}">Editar</a>
                        <a href="{{ route('products.show', $product->id)}}">Detalhes</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- essa linha abaixo mostra os link de PAGINAÇÃO com filtros de busca--}}
    @if (isset($filters))
        {!! $products->appends($filters)->links() !!}        
    @else
        {!! $products->links() !!}
    @endif

@endsection
    
    {{-- <h1>Estruturas de controle</h1>
    {{ $teste2 }} - {{ $teste3 }}
    @if ($teste4 === 123)
        <h4>O teste4 é igual 123</h4>
    @else
        <h4>Teste4 é diferente de 123M</h4>
    @endif --}}

    {{-- aqui unless é o contrário de if!! se FOR FALSO ele entra no unless --}}
    {{-- @unless ($teste4 === '123')
        <h4>Teste4 é diferente de tipo 123</h4>
    @endunless --}}

    {{-- se existir essa variável ele entra no isset o codigo --}}
    {{-- @isset($teste5)
        {{ $teste5 }}
    @endisset --}}

    {{-- @empty($teste6)
    <h4>{{ $teste6 }} - está vazia teste6</h4>
    @endempty --}}

    {{-- só vai executar auth se o usuario estiver logado, senao executa o else --}}
    {{-- @auth
        <h3>User Autenticado</h3>
    @else 
        <h3>User NÃO Autenticado</h3>
    @endauth  --}}

    {{-- aqui só entra em guest se o usuário nao estiver logado --}}
    {{-- @guest
        <h3>User NÃO Autenticado</h3>
    @endguest

    @switch($teste2)
        @case(1)
            Igual a 1
            @break
        @case(2)
            Igual a 2
            @break
        @default
            Impossível saber esse valor....
    @endswitch --}}

    {{-- <hr>

    <h1>Estruturas de repetição</h1>

    @isset($products)
        @foreach ($products as $product) --}}
        {{-- esse $loop vc pode por classes em certos produtos dentro do loop! ver documentação --}}
            {{-- <p class="@if($loop->last) last @endif">{{ $product }}</p>
        @endforeach        
    @endisset

    <hr> --}}

    {{-- esse forelse é como o for de cima! se nao exister tal variável ele executa empty
        se existir ele entra em forelse e mostra o produto --}}
    {{-- @forelse ($products as $product)
        <p class="@if($loop->first) last @endif">{{ $product }}</p>
    @empty
        <p>Não existe produto cadastrado</p>
    @endforelse

    <hr> --}}

    {{-- podemos centralizar todos os alerts do sistema e chamalos com include!
        esse 'content' está mandando esse dado para admin.alerts.alerts.blade.php
        MAS não é bom passar dados via include.. temos que passar por components--}}
    {{-- @include('admin.includes.alerts', ['content' => 'Alerta de preços de produtos']) --}}

    {{-- Aqui vem o exemplo do components para passar os dados e qm recebe esses dados é 
        admin.components.card na variável $slot!  component já faz include e passa os dados --}}
    {{-- Esse @slot('title') manda dados para a var $title de admin.components.card --}}
    {{-- @component('admin.components.card')
        @slot('title')
            <h1>Título Card</h1>
        @endslot
        Um card de exemplo
    @endcomponent


@endsection --}}

{{-- esse push envia essa CSS para o STACK STYLES que fica em app.blade.php --}}
{{-- @push('styles')
    <style>
        .last { background: #CCC; }
    </style>    
@endpush

@push('scripts')
    <script>
        document.body.style.background = '#efefef';
    </script>
@endpush --}}

{{-- esse section vai para o @yield title de app--}}
{{-- @section('title', 'Gestão de Admin') --}}