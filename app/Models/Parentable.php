<?php

namespace App\Models;

use App\Models\Pupil;
use Illuminate\Database\Eloquent\Model;

class Parentable extends Model
{

    protected $fillable = ['relation', 'creator', 'editor', 'authorized', 'ability', 'parentor_id', 'pupil_id'];

    public function pupils()
    {
    	return $this->hasMany(Pupil::class);
    }
    



}
