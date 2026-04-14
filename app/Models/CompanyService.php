<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyService extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'content_title',
        'page_content',
        'page_main_image',
        'service_menu_type',
        'status',
        'page_sub_images',
        'created_by',
        'slug',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'company_services';

    protected $casts = [
        'page_sub_images' => 'array',
        'status' => 'integer',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
