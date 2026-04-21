<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientReview extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'client_name',
        'client_image',
        'rating',
        'content',
        'pub_date',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'client_reviews';

    protected $casts = [
        'status' => 'integer',
    ];
}
