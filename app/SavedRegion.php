<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedRegion extends Model
{
    protected $table = 'regions';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
