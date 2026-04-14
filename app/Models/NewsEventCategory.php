<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsEventCategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'slug', 'created_by', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'news_event_categories';

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function newsEvents()
    {
        return $this->hasMany(NewsEvent::class);
    }
}
