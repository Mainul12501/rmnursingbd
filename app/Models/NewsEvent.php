<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'news_event_category_id',
        'title',
        'main_image',
        'sub_images',
        'main_content',
        'status',
        'slug',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'news_events';

    protected $casts = [
        'sub_images' => 'array',
        'status' => 'integer',
    ];

    public function newsEventCategory()
    {
        return $this->belongsTo(NewsEventCategory::class, 'news_event_category_id');
    }
}
