<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\StoreUpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $request;
    private $repository;

    public function __construct(Request $request, Product $product) 
    {
        $this->request = $request;
        $this->repository = $product;//isso pega uma instancia de Model Product
        
        //dump & die esse dd                
        //dd($this->request->prm1);
        //esse middeware auth, garante que tal rota só pose ser acessada
        //caso o usuário estiver logado! tb pode ser chamado dentro do controller! mas é bom evitar
        //
        //$this->middleware('auth');
        //tambem podemos filtrar quais rotas o middleware vai agir em cima
        /*$this->middleware('auth')->only([
            'create', 'store'
        ]);*/
        
        //Aqui o middleware só não age em cima de index e show.. no resto do CRUD sim..
        // $this->middleware('auth')->except([
        //     'index', 'show'
        // ]);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()    
    {          
        //return 'Listagem de produtos';
        //nos controllers temos que retornar a VIEW
        //return view('teste'); //essa view vem de Views/teste.blade.php
        
        //podemos passar dados para a view
        // $teste2 = '<h1>Olá</h1>';
        // $teste3 = 654;
        // $teste4 = 123;
        // $products = ['Tv', 'Geladeira', 'Forno', 'Sofá'];
        // $teste6 = '';              
        /*return view('teste', [
            'teste' => $teste
        ]);*/
        //aqui outro modo de passar os dados para view usando compact (cria uma array de variáveis)
        // return view('admin.pages.products.index', 
        //     compact('teste2', 'teste3', 'teste4', 'products', 'teste6'));
        
        //isso retorna os dados da tabela product pelo Eloquent ORM
        //$products = Product::all();
        //$products = Product::get();
        $products = Product::latest()->paginate(); //paginação padrao de 15 registros
        
        return view('admin.pages.products.index', [
            'products' => $products,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductRequest $request)
    {
        $data = $request->only('name', 'description', 'price');

        if($request->hasFile('image') && $request->image->isValid()) {
            $imagePath = $request->image->store('products');

            $data['image'] = $imagePath;
        }

        //Product::create($data);
        $this->repository->create($data);

        return redirect()->route('products.index');



        /* aqui alguns modos de validar formulários! mas não é o modo correto de se fazer!
           o modo correto é usar REQUEST.. veja em Http/Requests/* 
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:1000',
            'photo' => 'required|image'
        ]);*/

        //dd('OK');

        //dd($request->all());
        //dd($request->only(['name', 'description']));
        //dd($request->name);
        //dd($request->description);
        //dd($request->has('name'));//se tiver name, retorna true
        // se o campo 'teste' não existir no input do formulario então fica com o valor default
        //dd($request->input('teste', 'default'));
        // traz todos os campos, execeto 'name'
        //dd($request->except('name'));

        //aqui verifica se esta tudo OK com o upload da foto
        //if($request->file('image')->isValid()) {
            //dd($request->photo->getClientOriginalName());
            //esse store armazena a foto em storage/app! cria pasta products e cria hash para nome da foto
            //dd($request->photo->store('products'));
            //com esse codigo podemos deixar o nome da foto como quisermos
            //$fileName = $request->name . '.' . $request->photo->extension();
            //dd($request->photo->storeAs('products', $fileName));
        //}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // aqui pegamos o produto ONDE id=$id
        //$product = Product::where('id', $id)->first();
        //aqui outro modo que retorna true se achou o ID do produto
        //se for false então faz um redirect e volta na view que estava anterior
        
        if(!$product = $this->repository->find($id))
            return redirect()->back();

        return view('admin.pages.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        if(!$product = $this->repository->find($id))
            return redirect()->back();
        
        return view('admin.pages.products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductRequest $request, $id)
    {
        if(!$product = $this->repository->find($id))
            return redirect()->back();

        $data = $request->all();    

        if($request->hasFile('image') && $request->image->isValid()) {

            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            $imagePath = $request->image->store('products');

            $data['image'] = $imagePath;
        }
        
        $product->update($data);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //senao encontrar o produto para deletar usa redirect e volta pra view antetior que estava
        $product = $this->repository->where('id', $id)->first();
        if(!$product)
            return redirect()->back();
        
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('products.index');
    }

    /**
     * Search products
     */
    public function search(Request $request) 
    {
        $filters = $request->except('_token');

        $products = $this->repository->search($request->filter);

        return view('admin.pages.products.index', [
            'products' => $products,
            'filters'  => $filters,
        ]);
    }
}
