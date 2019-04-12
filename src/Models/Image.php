<?php

namespace Mattmangoni\NovaBlogifyTool\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * Fillable properties.
     * @var array
     */
    protected $fillable = [
        'title',
        'filename',
        'size',
    ];

    /**
     * Get image's link.
     * @return string
     */
    public function getLinkAttribute()
    {
        return url('storage/'.$this->filename);
    }
}
