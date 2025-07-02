<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';

    protected $fillable = [
    
        'title',
        'content',
        'author',
        'categories_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
