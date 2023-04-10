<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements Sortable
{
    use HasFactory,HasSlug,SortableTrait;

    protected $fillable = [
        'category_name',
        'category_icon',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('category_name')
            ->saveSlugsTo('slug');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }
}
