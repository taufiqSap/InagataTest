<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
 public function rules()
{
    return [
        'title' => 'required|string|max:100',
        'content' => 'required|string|max:500',
        'author' => 'required|string|max:100',
        'categories_id' => 'required|exists:categories,id'
    ];

}
    public function messages()
{
    return [
        'title.required' => 'Judul artikel tidak boleh kosong.',
        'content.required' => 'Konten artikel tidak boleh kosong.',
        'author.required' => 'author harus di isi',
        'categories_id.required' => 'Kategori harus diisi.',
        'categories_id.exists' => 'Kategori tidak valid atau tidak ditemukan.'
    ];
}
    
}
