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
        'origin',
        'externalId'
    ];

    const CREATED_AT = 'publishedAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    const ORIGIN_EXTERNAL = 'external';

    public function scopeExternal($query)
    {
        return $query->where('origin', self::ORIGIN_EXTERNAL);
    }

    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = (bool) $value;
    }
}
