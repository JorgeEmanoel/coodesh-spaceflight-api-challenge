<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'url',
        'imageUrl',
        'newsSite',
        'summary',
        'publishedAt',
        'updatedAt',
        'featured',
        'launches',
        'events',
    ];

    const CREATED_AT = 'publishedAt';
    const UPDATED_AT = 'updatedAt';

    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = (bool) $value;
    }
}
