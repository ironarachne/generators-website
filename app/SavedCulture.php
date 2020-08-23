<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedCulture extends Model
{
    protected $table = 'cultures';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
