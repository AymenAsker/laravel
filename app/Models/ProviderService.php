<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProviderService extends Model
{
    use HasFactory,HasSlug;

    protected $fillable = [
        'provider_id',
        'service_id',
        'name_brand',
        'day_of_week',
        'start_time',
        'end_time',
        'details',
        'status',
        'status_a',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function scopeStatus(Builder $builder)
    {
        return $builder->where('status_a', 1)->where('status', 1);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('details')
            ->saveSlugsTo('slug');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function providerServicePrice()
    {
        return $this->hasMany(ProviderServicePrice::class, 'provider_service_id', 'id');
    }

    public function providerServicePhone()
    {
        return $this->hasMany(ProviderServicePhone::class, 'provider_service_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'provider_service_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'provider_service_id', 'id');
    }
}
