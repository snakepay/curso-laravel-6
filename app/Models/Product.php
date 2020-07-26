<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /* esse atributo $fillable garante que somente esses campos sejem
       inseridos no banco de dados.. isso vem do controller products.show
       quando vai cadastrar um novo produto no banco usando :
       $data = $request->only('name', 'description', 'price');
       Product::create($data);
       esse create que vai criar o registro no banco, mas quais campos ele vai mandar??
       os campos que estão sendo pedidos por $request-only...
       mas pra isso funcionar dentro aqui da Model Product precisamos permitir
       quais são os campos que podem ser inseridos assim de uma vez, evitando assim ataque XSS!
       e precisa ser nesse nome $fillable para funcionar */
    protected $fillable = ['name', 'description', 'price', 'image'];

    public function search($filter = null)
    {
        $results = $this->where( function($query) use ($filter) {
            if($filter) {
                $query->where('name', 'LIKE', "%{$filter}%");
            }
        })//->toSql();       
        ->paginate();

        return $results;
    }
}
