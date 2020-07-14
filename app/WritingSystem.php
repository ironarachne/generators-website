<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WritingSystem extends Model
{
    protected $hidden = ['pivot', 'id', 'created_at', 'updated_at'];

    public function languages()
    {
        return $this->belongsToMany('App\Language');
    }
}
