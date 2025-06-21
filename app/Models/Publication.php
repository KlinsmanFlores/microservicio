<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    //
    protected $fillable=['magazine_id','title','content'];
    public function magazine()
    {
        return $this -> belongsTo(Magazine::class);
    }
}
