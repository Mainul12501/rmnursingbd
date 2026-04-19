<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentRequest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'requested_user_id',
        'name',
        'mobile',
        'email',
        'subject',
        'message',
        'status',
        'managed_user_id',
        'company_service_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'appointment_requests';

    public function requestedUser()
    {
        return $this->belongsTo(User::class, 'requested_user_id');
    }

    public function managedBy()
    {
        return $this->belongsTo(User::class, 'managed_user_id');
    }

    public function companyService()
    {
        return $this->belongsTo(CompanyService::class);
    }
}
