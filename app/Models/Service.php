<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model implements Sortable
{
    use HasFactory,HasSlug,SortableTrait;

    protected $fillable = [
        'category_id',
        'service_name',
        'service_icon',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('service_name')
            ->saveSlugsTo('slug');
    }

    public function buildSortQuery()
    {
        return static::query()->where('category_id', $this->category_id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function providerServices()
    {
        return $this->hasMany(ProviderService::class, 'service_id', 'id');
    }
}
