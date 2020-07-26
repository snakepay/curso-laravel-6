<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /* temos que garantir que name aqui será único certo!! para isso colocamos unique:tabela
            que nesse caso é unique:products! mas temos também que garantir na edição de tal produto,
            que possa ser editado com o mesmo nome, pois caso não queiramos mudar o nome ele
            tem que editar outra coisa tp a descrição.. e quando clicar no botão editar,
            para nao dar conflito de nome unico temos que pegar o segmento da url como $id!
            esse segmento é a qnt de / dps da url padrao.. ex: 
            http://curso-laravel-repositories.test/products/102/edit -> aqui temos 3 segmentos
            e o segmento 2 tem o ID do produto em questao para edição! veja abaixo!!
            dentro do return em 'name' a parte: name,{$id},id faz essa exceção para poder
            editar o produto mantendo o mesmo nome e não gerando erro!!!*/ 
        
        $id = $this->segment(2);

        return [
            'name' => "required|min:3|max:255|unique:products,name,{$id},id",
            'description' => 'required|min:3|max:1000',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'image' => 'nullable|image'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Nome Obrigatório',
            'name.min' => 'Nome deve ter pelo menos 3 caracteres'
        ];
    }
}
