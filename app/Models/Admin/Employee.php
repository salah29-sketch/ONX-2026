<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function getPhotoAttribute()
    {
        return $this->getFirstMedia('photo');
    }
}
