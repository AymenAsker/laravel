<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderServicePhone extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'phone_number',
    ];


    public function providerService()
    {
        return $this->belongsTo(ProviderService::class, 'provider_service_id', 'id');
    }
}
