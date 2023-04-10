<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_id',
        'provider_id',
        'provider_service_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function providerService()
    {
        return $this->belongsTo(ProviderService::class, 'provider_service_id', 'id');
    }
}
