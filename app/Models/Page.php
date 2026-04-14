<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'page_title',
        'menu_title',
        'main_image',
        'sub_images',
        'page_content',
        'slug',
        'status',
        'order',
    ];

    protected $searchableFields = ['*'];
}
