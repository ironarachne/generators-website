<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    protected $hidden = ['id', 'created_at', 'updated_at', 'language_id'];

    public function language()
    {
        return $this->belongsTo('App\Language');
    }
}
