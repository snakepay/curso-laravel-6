<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::view('/', 'welcome');

/* Aqui seria um modo mais simples de retornar uma VIEW sem passar dados pelo Controller */
Route::view('/view', 'welcome');

// Route::get('/contato', function () {
//     return 'Contato';
// });

// Route::any('/empresa', function() {
//     return 'Empresa';
// });

// Route::match(['get', 'post'], '/home', function(){
//     return 'Home';
// });

//Rota com parâmetro! aqui flag de function pode ser outro nome.. o laravel aceita normal
// Route::get('/categorias/{flag}', function($prm1){
//     return "Produtos da categoria: {$prm1}";
// });
//Rota com parâmetro! aqui precisa $flag estar dentro de function para pegar
// Route::get('/categoria/{flag}/post', function($flag){
//     return "Produtos da categoria2: {$flag}";
// });

//Parâmetro opcional se usa ? na flag. Mas em function precisa deixar algo de valor padrão se nao vier nada da flag
// Route::get('/produto/{idProduto?}', function($idProduto = ''){
//     return "Produto: {$idProduto}";
// });

/**** REDIRECIONAMENTO DE ROTAS - Se uma rota precisar redirecionar para outra *****/
//Route::get('/redirect1', function() {
//    return redirect('redirect2');    //esse redirect vem de uma Helpers
//});

// Route::redirect('redirect1', 'redirect2');

// Route::get('/redirect2', function() {
//     return ('redirect2');
// });
/***********************************************************************************/

/* ROTAS NOMEADAS - Se algume vez precisar mudar alguam rota, pra evitar de refatorar o codigo todo
 * se pode usar uma ROTA NOMEADA com ->name(nomeRota), dai é só chamar ela por redirect()->route(nomeRota(feita em ->name));
 * Com isso podemos mudar /nome-url para qualquer nome que vai funcionar por causa do route 
 */
// Route::get('/nome-url', function() {
//     return 'Hey hey hey';
// })->name('url.name');

// Route::get('/redirect3', function() {
//     return redirect()->route('url.name');    //esse redirect vem de uma Helpers
// });
/**********************************************************************************/



/**********************************************************************************/
// **************************************************************************
/* GRUPOS DE ROTAS e MIDLEWARE (filtros para garantir autenticação no sistema) 
 * 
 * Nessa parte onde as rotas dos ADMIN tem o middleware.. esse middleware garante que,
 * para acessarmos as paginas do ADMIN precisamos estar LOGADOS, senão estiver logado
 * o middleware redireciona para a página de LOGIN da rota /login!!
 * isso é feito automaticamente, só precisamos criar a rota /login!
 * o middleware recebe string ou array pode ser tb: ['auth', 'nomeMiddleware' ...]
 */
// Route::get('/login', function(){
//     return 'Login';
// })->name('login');

// Route::get('/admin/dashboard', function(){
//    return 'Home Admin';
// })->middleware('auth');
// //
// Route::get('/admin/financeiro', function(){
//    return 'Financeiro Admin';
// })->middleware('auth');
// //
// Route::get('/admin/produtos', function(){
//    return 'Produtos Admin';
// })->middleware('auth');

/* Agora caso precisemos alterar o nome do middleware, e para evitarmos refatorar o codigo todo
 * podemos criar um GRUPO DE ROTAS que o middleware vai agir em cima.. vejamos abaixo como esse modo
 * de criar a middleware para as rotas é melhor e evita refatoração de codigo!
 * Dentro do grupo middleware temos um grupo de prefixo de nome para rotas com o nome de admin,
 * com isso evitamos de ficar pondo /admin/dashboard, /admin/financeiro e /admin/produtos!
 * Evita refatoração de codigo se um dia precisarmos mudar o nome de admin para wp-admin por exemplo!
 * mudamos somente o prefix que vai funcionar para todas as rotas automaticamente
 */
//Route::middleware(['auth'])->group(function(){    
//    Route::prefix('admin')->group( function() {
//        Route::get('/dashboard', function(){
//         return 'Home Admin';
//        });
//
//        Route::get('/financeiro', function(){
//         return 'Financeiro Admin';
//        });
//
//        Route::get('/produtos', function(){
//         return 'Produtos Admin';
//        });     
//        
//        //aqui seria no caso se for passada na url apenas admin!! dai cai aqui na rota /
//        //Route::get('/', function(){
//        //return 'Admin';
//        //});
//        
//        /*aqui a mesma rota get /, mas passando chamando um controller; o @ chama algum método desse controller!
//         * aqui nesse caso criamos um controllerdentro de app/Http/Controllers/Admin/TesteController.php
//         * então por ser customizado temos que passar o caminho dele para a rota acha-lo!!!
//         * caso contrário se for dentro do arquivo app/Http/Controller/Controller.php, não precisa
//         * passar o caminho todo somente o nome do Controller.php que a rota já iria achá-lo
//         */
//        Route::get('/', 'Admin\TesteController@teste');
//    });
//});

/* Mas vamos super que queremos mudar o nome da pasta Admin... se tivermos 10 rotas precisaremos
 * refatorar o codigo e arrumar o namespace desse controller para a rota o achar...
 * com isso podemos criar o grupo de namespace, evitando esse problema!
 * agora vem o mesmo exemplo de grupo de rotas acima!!!
 * Nesse exemplo abaixo seria o Admin\TesteController... 
 * se mudar o namespace ja mudo sozinho em todas as rotas
 */

//Route::middleware(['auth'])->group(function(){    
//    Route::prefix('admin')->group( function() {
//        Route::namespace('Admin')->group(function() {
//            Route::get('/dashboard', 'TesteController@teste')->name('admin.dashboard');
//
//            Route::get('/financeiro', 'TesteController@teste')->name('admin.financeiro');
//
//            Route::get('/produtos', 'TesteController@teste')->name('admin.produtos');             
//
//            Route::get('/', function(){
//                return redirect()->route('admin.dashboard');
//            })->name('admin.home');
//        });        
//    });
//});

/* Agora para melhorar mais ainda... repare que em ->name() todas as rotas tem admin. !!!
 * Vamos fazer um group name para esse admin.
 */
/*
Route::middleware(['auth'])->group(function(){    
    Route::prefix('admin')->group( function() {
        Route::namespace('Admin')->group(function() {
            Route::name('admin.')->group(function () {
                Route::get('/dashboard', 'TesteController@teste')->name('dashboard');

                Route::get('/financeiro', 'TesteController@teste')->name('financeiro');

                Route::get('/produtos', 'TesteController@teste')->name('produtos');             

                Route::get('/', function(){
                    return redirect()->route('admin.dashboard');
                })->name('home');                
            });
        });        
    });
});*/

/* Agora para melhora mais o codigo... vamos fazer com apenas 1 group.. passando todos os groups um array! 
 * Dentro do array group a posição 'as' referencia o 'name'
 */

// Route::group([
//     'middleware' => ['auth'],
//     'prefix' => 'admin',
//     'namespace' => 'Admin',
//     'as' => 'admin.'
// ], function() {
//     Route::get('/dashboard', 'TesteController@teste')->name('dashboard');

//     Route::get('/financeiro', 'TesteController@teste')->name('financeiro');

//     Route::get('/produtos', 'TesteController@teste')->name('produtos');             

//     Route::redirect('/', 'dashboard')->name('home');

//     // Route::get('/', function(){
//     //     return redirect()->route('admin.dashboard');
//     // })->name('home');  
// });
/********************************************************************************/

/* Os modos acima das rotas precisam ser evitados.. temos que chamar Controllers na rotas..*/

/*Vai a controller dps da rota com a chamada de alguma função da Controller pelo @ 
Route::get('/products', 'ProductController@index')->name('products.index');


Route::get('/products/create', 'ProductController@create')->name('products.create');

Route::delete('/products/{id}','ProductController@destroy')->name('products.destroy');
Route::put('/products/{id}','ProductController@update')->name('products.update');

//Aqui nessa rota tem um parâmetro ID!! esse ID ja vai automatico para a função @SHOW de ProductController
Route::get('/products/{id}', 'ProductController@show')->name('products.show');
Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');

// cadastra os produtos
Route::post('/productse', 'ProductController@store')->name('products.store');*/

// Fizemos um CRUD com as rotas de cima... mas o laraval tem um modo de fazer isso melhor, segue abaixo

/* essa parte para search em filtros a rota precisa ser any para pegar! porque quando
   submetemos a busca é uma requisição POST e quando paginamos é GET */
Route::any('products/search', 'ProductController@search')->name('products.search')->middleware('auth');
Route::resource('products', 'ProductController')->middleware('auth');
//esse middleware acima tb pode ser chamado dentro do controoler.. veja o construtor do controller


//essa parte é sobre AUTH.. ver na documentação sobre auth
// Auth::routes();
Auth::routes(['register' => false]);
