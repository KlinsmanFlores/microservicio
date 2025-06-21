<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    //
    protected $fillable = ['name', 'issn' , ' founded'];
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
